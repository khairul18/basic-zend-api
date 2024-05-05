<?php

namespace User\V1\Rest\Profile;

use Zend\Paginator\Paginator as ZendPaginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use User\Mapper\UserProfile as UserProfileMapper;
use User\V1\Service\Profile as UserProfileService;
use User\V1\Rest\AbstractResource;
use User\Mapper\CompanyTrait as CompanyMapperTrait;
use User\Mapper\BranchTrait as BranchMapperTrait;
use User\Mapper\DepartmentTrait as DepartmentMapperTrait;
use Psr\Log\LoggerAwareTrait;
use User\V1\Role;

class ProfileResource extends AbstractResource
{
    use LoggerAwareTrait;
    use CompanyMapperTrait;
    use BranchMapperTrait;
    use DepartmentMapperTrait;

    private $userProfile;
    protected $userProfileMapper;
    protected $userProfileService;
    protected $profileService;

    public function __construct(
        $loggedInUser,
        UserProfileMapper $userProfileMapper,
        \User\Mapper\Company $companyMapper,
        \User\Mapper\Branch $branchMapper,
        \User\Mapper\Department $departmentMapper,
        \User\Mapper\UserAccess $userAccessMapper
    ) {

        $this->userProfile = $loggedInUser;
        $this->setUserProfileMapper($userProfileMapper);
        $this->setCompanyMapper($companyMapper);
        $this->setBranchMapper($branchMapper);
        $this->setDepartmentMapper($departmentMapper);
        $this->setUserAccessMapper($userAccessMapper);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $userProfile = $this->userProfile;
        if (!is_null($userProfile)) {
            $inputFilter    = $this->getInputFilter();
            $email          = $inputFilter->getValue('email');
            $icNumber       = $inputFilter->getValue('icNumber');
            $username       = $inputFilter->getValue('username');
            $companyUuid    = $inputFilter->getValue('company');
            $branchUuid     = $inputFilter->getValue('branch');
            $departmentUuid = $inputFilter->getValue('department');
            $parentUuid     = $inputFilter->getValue('parent');

            // store input of userEducation Array to log
            $this->logger->log(
                \Psr\Log\LogLevel::DEBUG,
                "{function}: Debugging UserEdu input\n======> {data}",
                [
                    "function" => __FUNCTION__,
                    "data" => $inputFilter->getValue('educations')
                ]
            );
            $usernameExist  = $this->getUserProfileMapper()->fetchOneBy([
                'username' => $username
            ]);
            if (!is_null($usernameExist)) {
                return new ApiProblemResponse(new ApiProblem(422, "Username has been used"));
            }

            $emailExist  = $this->getUserProfileMapper()->fetchOneBy([
                'email' => $email
            ]);
            if (!is_null($emailExist)) {
                return new ApiProblemResponse(new ApiProblem(422, "Email has been used"));
            }

            // $icNumberExist  = $this->getUserProfileMapper()->fetchOneBy([
            //     'icNumber' => $icNumber
            // ]);
            // if (! is_null($icNumberExist)) {
            //     return new ApiProblemResponse(new ApiProblem(422, "IC number has been registered"));
            // }

            $companyExist  = $this->getCompanyMapper()->fetchOneBy([
                'uuid' => $companyUuid
            ]);
            if (is_null($companyExist)) {
                return new ApiProblemResponse(new ApiProblem(404, "Company data not found"));
            }

            $branchExist  = $this->getBranchMapper()->fetchOneBy([
                'uuid' => $branchUuid
            ]);
            if (is_null($branchExist)) {
                return new ApiProblemResponse(new ApiProblem(404, "Branch data not found"));
            }

            $departmentExist  = $this->getDepartmentMapper()->fetchOneBy([
                'uuid' => $departmentUuid
            ]);
            if (is_null($departmentExist)) {
                return new ApiProblemResponse(new ApiProblem(404, "Department data not found"));
            }

            if (!is_null($parentUuid)) {
                $parentExist  = $this->getUserProfileMapper()->fetchOneBy([
                    'uuid' => $parentUuid
                ]);
                if (is_null($parentExist)) {
                    return new ApiProblemResponse(new ApiProblem(404, "User Profile for Parent Data not found"));
                }
            }

            $inputFilter->add(['name'  => 'userProfile']);
            $inputFilter->get('userProfile')->setValue($userProfile);

            $account = $userProfile->getAccount();
            if (is_null($account)) {
                return new ApiProblemResponse(new ApiProblem(404, "User Account not found"));
            }

            $inputFilter->add(['name'  => 'account']);
            $inputFilter->get('account')->setValue($account);

            if (is_null($account->getTimezone())) {
                return new ApiProblemResponse(new ApiProblem(404, "Account Timezone not found"));
            }

            $inputFilter->add(['name'  => 'timezone']);
            $inputFilter->get('timezone')->setValue($account->getTimezone());

            $edu = json_decode($inputFilter->getValue('educations'));
            if (!is_array($edu)) {
                return new ApiProblemResponse(new ApiProblem(422, "Education field must be array"));
            }

            try {
                $educationFields = json_decode($inputFilter->getValue('educations'));
                $user = $this->getUserProfileService()->create($userProfile, $inputFilter, $educationFields);
            } catch (\User\V1\Service\Exception\RuntimeException $e) {
                return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
            }

            return $user;
        }
        return new ApiProblemResponse(new ApiProblem(404, "User Identity not found"));
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $userProfile = $this->fetchUserProfile();
        $userProfileUuid = $userProfile->getUuid();
        if (!is_null($userProfile)) {
            try {
                $queryParamUserAccess = [
                    'userProfile' => $userProfileUuid
                ];
                $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
                //initiate var role, create condition to check if userAccess isExist 
                $role = '';
                if (!is_null($userAccess)) {
                    $role = strtolower($userAccess->getUserRole()->getName());
                }

                // Only admin can delete user profile
                if (!$role === \User\V1\Role::ADMIN) {
                    return new ApiProblemResponse(new ApiProblem(403, "Your User Can't Access This Page!!!, Please Contact Admin."));
                }
                $deleteUserProfile = $this->getUserProfileMapper()->fetchOneBy(['uuid' => $id]);
                if (is_null($deleteUserProfile)) {
                    return new ApiProblemResponse(new ApiProblem(404, "User Profile Not Found"));
                }

                return $this->getUserProfileService()->deleteProfile($userProfile, $id);
            } catch (\User\V1\Service\Exception\RuntimeException $e) {
                return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
            }

            return $tenant;
        }
        return new ApiProblemResponse(new ApiProblem(404, "User Identity not found"));
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $userProfile = $this->fetchUserProfile();
        if ($userProfile === null || is_null($userProfile->getAccount())) {
            return;
        }

        $queryParams = [
            'uuid' => $id,
            'account' => $userProfile->getAccount()->getUuid(),
        ];

        $userProfile = $this->getUserProfileMapper()->fetchOneBy($queryParams);
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile not found"));
        }

        return $userProfile;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $userProfile = $this->fetchUserProfile();
        $userProfileUuid = $userProfile->getUuid();
        if ($userProfile === null) {
            return;
        }

        $urlParams   = $params->toArray();
        $queryParams = [
            'account'   => $userProfile->getAccount()->getUuid(),
        ];

        $queryParamUserAccess = [
            'userProfile' => $userProfileUuid
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (!is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role == Role::MANAGER) {
            $queryParams['parent_uuid'] = $userProfileUuid;
        }

        $queryParams = array_merge($queryParams, $urlParams);

        $order = null;
        $asc   = false;
        if (isset($queryParams['order'])) {
            $order = $queryParams['order'];
            unset($queryParams['order']);
        }

        if (isset($queryParams['ascending'])) {
            $asc = $queryParams['ascending'];
            unset($queryParams['ascending']);
        }

        $userProfileData = $this->getUserProfileMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getUserProfileMapper()->createPaginatorAdapter($userProfileData);
        return new ZendPaginator($paginatorAdapter);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $userProfile  = $this->fetchUserProfile();
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $inputFilter = $this->getInputFilter();

        $this->logger->log(
            \Psr\Log\LogLevel::INFO,
            "{function}: Debugging UserEdu patch input\n======> {data}",
            [
                "function" => __FUNCTION__,
                "data" => $inputFilter->getValue('educations')
            ]
        );

        $userProfileObj  = $this->getUserProfileMapper()->fetchOneBy([
            'uuid' => $id
        ]);
        if (is_null($userProfileObj)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile Not Found"));
        }
        // $icNumber = $inputFilter->getValue('icNumber');
        // $icNumberExist  = $this->getUserProfileMapper()->fetchOneBy([
        //     'icNumber' => $icNumber
        // ]);
        // if (!is_null($icNumberExist) && $icNumber != $userProfileObj->getIcNumber()) {
        //     return new ApiProblemResponse(new ApiProblem(422, "IC number has been registered"));
        // }

        $optionFields = json_decode($inputFilter->getValue('educations'));
        $result = $this->getUserProfileService()->update($userProfileObj, $inputFilter, $optionFields);
        return $result;
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $userProfile = $this->getUserProfileMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile not found"));
        }

        $inputFilter = $this->getInputFilter();
        $this->getUserProfileService()->update($userProfile, $inputFilter);
        return $userProfile;
    }

    /**
     * @return the $userProfileMapper
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * @param UserProfileMapper $userProfileMapper
     */
    public function setUserProfileMapper($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * @return the $userProfileService
     */
    public function getUserProfileService()
    {
        return $this->userProfileService;
    }

    /**
     * @param UserProfileService $userProfileService
     */
    public function setUserProfileService(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }
}
