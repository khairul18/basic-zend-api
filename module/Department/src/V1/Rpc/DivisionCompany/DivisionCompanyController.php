<?php

namespace Department\V1\Rpc\DivisionCompany;

use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Zend\Mvc\Controller\AbstractActionController;
use Department\Mapper\CompanyTrait as CompanyMapperTrait;
use User\Mapper\BranchTrait as BranchMapperTrait;
use Department\Mapper\DepartmentTrait as DepartmentMapperTrait;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;
use User\V1\Role as Role;

class DivisionCompanyController extends AbstractActionController
{
    use CompanyMapperTrait;
    use BranchMapperTrait;
    use DepartmentMapperTrait;
    use UserProfileMapperTrait;
    use UserAccessMapperTrait;

    /**
     * @var Department\V1\Service\Company
     */
    protected $companyService;

    /**
     * @var User\V1\Service\Branch
     */
    protected $branchService;

    /**
     * @var Department\V1\Service\Department
     */
    protected $departmentService;

    /**
     * @var User\Entity\UserProfile
     */
    protected $userProfile;

    /**
     * @var Zend\InputFilter\InputFilter
     */
    protected $uuidValidator;

    public function __construct(
        \Department\V1\Service\Company $companyService,
        \Department\Mapper\Company $companyMapper,
        \User\V1\Service\Branch $branchService,
        \User\Mapper\Branch $branchMapper,
        \Department\V1\Service\Department $departmentService,
        \Department\Mapper\Department $departmentMapper,
        $userProfile,
        \User\Mapper\UserProfile $userProfileMapper,
        \User\Mapper\UserAccess $userAccessMapper
    ) {
        $this->setCompanyService($companyService);
        $this->setCompanyMapper($companyMapper);
        $this->setBranchService($branchService);
        $this->setBranchMapper($branchMapper);
        $this->setDepartmentService($departmentService);
        $this->setDepartmentMapper($departmentMapper);
        $this->userProfile = $userProfile;
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserAccessMapper($userAccessMapper);
    }

    public function divisionCompanyAction()
    {
        $event = $this->getEvent();
        $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');
        $dataUuid = $inputFilter->getValues()['uuid'];
        $level = strtolower($inputFilter->getValues()['level']);
        $userProfile = $this->getUserProfile();

        $allowedUsers = [
            Role::ADMIN,
            Role::MANAGER,
        ];

        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (!is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if (!in_array($role, $allowedUsers)) {
            return new ApiProblemResponse(new ApiProblem(403, "Your account type doesn't have privilege for accessing this system"));
        }

        if ($level == 'company') {
            $data = $this->getCompanyMapper()->fetchOneBy(['uuid' => $dataUuid]);
        } elseif ($level == 'branch') {
            $data = $this->getBranchMapper()->fetchOneBy(['uuid' => $dataUuid]);
        } elseif ($level == 'department') {
            $data = $this->getDepartmentMapper()->fetchOneBy(['uuid' => $dataUuid]);
        } elseif ($level == 'personal') {
            $data = $this->getUserProfileMapper()->fetchOneBy(['uuid' => $dataUuid]);
        } else {
            return new ApiProblemResponse(new ApiProblem(404, "Level not available"));
        }
        if (is_null($data)) {
            return new ApiProblemResponse(new ApiProblem(404, "Data not found"));
        }

        try {
            $this->getCompanyService()->action($data, $inputFilter);

            // $hal = $this->getPluginManager()->get('Hal');
            // $reimbursementHalMetaData = $hal->getMetadataMap()->get(\Reimbursement\Entity\Reimburse::class);
            // $response = $hal->createEntityFromMetadata($dataAction, $reimbursementHalMetaData);

            // return new HalJsonModel(["payload" => $response]);
            return $this->getResponse()->setStatusCode(\Zend\Http\Response::STATUS_CODE_204);
        } catch (\Ticket\V1\Service\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
    }

    /**
     * Get the value of companyService
     *
     * @return  Department\V1\Service\Company
     */
    public function getCompanyService()
    {
        return $this->companyService;
    }

    /**
     * Set the value of companyService
     *
     * @param  Department\V1\Service\Company  $companyService
     *
     * @return  self
     */
    public function setCompanyService(\Department\V1\Service\Company $companyService)
    {
        $this->companyService = $companyService;

        return $this;
    }

    /**
     * Get the value of branchService
     *
     * @return  User\V1\Service\Branch
     */
    public function getBranchService()
    {
        return $this->branchService;
    }

    /**
     * Set the value of branchService
     *
     * @param  User\V1\Service\Branch  $branchService
     *
     * @return  self
     */
    public function setBranchService(\User\V1\Service\Branch $branchService)
    {
        $this->branchService = $branchService;

        return $this;
    }

    /**
     * Get the value of departmentService
     *
     * @return  Department\V1\Service\Department
     */
    public function getDepartmentService()
    {
        return $this->departmentService;
    }

    /**
     * Set the value of departmentService
     *
     * @param  Department\V1\Service\Department  $departmentService
     *
     * @return  self
     */
    public function setDepartmentService(\Department\V1\Service\Department $departmentService)
    {
        $this->departmentService = $departmentService;

        return $this;
    }

    /**
     * Get the value of userProfile
     *
     * @return  User\Entity\UserProfile
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set the value of userProfile
     *
     * @param  User\Entity\UserProfile  $userProfile
     *
     * @return  self
     */
    public function setUserProfile(\User\Entity\UserProfile $userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get the value of uuidValidator
     *
     * @return  Zend\InputFilter\InputFilter
     */
    public function getUuidValidator()
    {
        return $this->uuidValidator;
    }

    /**
     * Set the value of uuidValidator
     *
     * @param  Zend\InputFilter\InputFilter  $uuidValidator
     *
     * @return  self
     */
    public function setUuidValidator(Zend\InputFilter\InputFilter $uuidValidator)
    {
        $this->uuidValidator = $uuidValidator;

        return $this;
    }
}
