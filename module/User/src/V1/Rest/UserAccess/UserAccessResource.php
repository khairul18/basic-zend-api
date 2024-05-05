<?php
namespace User\V1\Rest\UserAccess;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator as ZendPaginator;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserRoleTrait as UserRoleMapperTrait;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;

class UserAccessResource extends AbstractResource
{
    use UserRoleMapperTrait;
    use UserAccessMapperTrait;

    protected $userAccessService;

    public function __construct(
        UserProfileMapper $userProfileMapper,
        \User\Mapper\UserRole $userRoleMapper,
        \User\Mapper\UserAccess $userAccessMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserRoleMapper($userRoleMapper);
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
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $data = (array) $data;
        $inputFilter = $this->getInputFilter();
        $userProfileUuid = $inputFilter->getValue('userProfile');
        $userRoleUuid    = $inputFilter->getValue('userRole');

        $userProfileExist  = $this->getUserProfileMapper()->fetchOneBy([
            'uuid' => $userProfileUuid
        ]);
        if (is_null($userProfileExist)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Profile data not found"));
        }

        $userRoleExist  = $this->getUserRoleMapper()->fetchOneBy([
            'uuid' => $userRoleUuid
        ]);
        if (is_null($userRoleExist)) {
            return new ApiProblemResponse(new ApiProblem(404, "UserRole data not found"));
        }

        $account = $userProfile->getAccount();
        if (is_null($account)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Account not found"));
        }
        
        $userAccessExist  = $this->getUserAccessMapper()->fetchOneBy([
            'userProfile' => $userProfileUuid
        ]);

        if (! is_null($userAccessExist)) {
            return new ApiProblemResponse(new ApiProblem(422, "This user already has registered access!"));
        }

        try {
            $inputFilter->add(['name' => 'createdAt']);
            $inputFilter->get('createdAt')->setValue(new \DateTime('now'));

            $inputFilter->add(['name' => 'updatedAt']);
            $inputFilter->get('updatedAt')->setValue(new \DateTime('now'));

            $result = $this->getUserAccessService()->save($inputFilter);
        } catch (\User\V1\Service\Exception\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
        return $result;
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
        if (is_null($userProfile) || is_null($userProfile->getAccount())) {
            return new ApiProblemResponse(new ApiProblem(404, "You do not have access"));
        }

        if ($id == '7d9a0202-8b2c-4863-bbfb-e6722f33b2ee') {
            return new ApiProblem(422, "This data cannot be deleted or changed, Contact the admin if you need permission");
        }

        try {
            $userAccess = $this->getUserAccessMapper()->fetchOneBy(['uuid' => $id]);
            if (is_null($userAccess)) {
                return new ApiProblem(404, "User Access Data Not Found");
            }
    
            if (strtolower($userAccess->getUserRole()->getName()) == \User\V1\Role::ADMIN) {
                return new ApiProblemResponse(new ApiProblem(422, "You can't delete this data, please contact super admin!"));
            }

            return $this->getUserAccessService()->delete($userAccess);
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $userAccess;
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
        try {
            $userProfile = $this->fetchUserProfile();
            if ($userProfile === null) {
                return;
            }

            $queryParams = [
                'uuid' => $id
            ];

            $data = $this->getUserAccessMapper()->fetchOneBy($queryParams);
            if (is_null($data)) {
                return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
            }

            return $data;
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
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

        $urlParams   = $params->toArray();

        $queryParams = [];
        if (! is_null($userProfile->getAccount())) {
            $queryParams = ["account_uuid" => $userProfile->getAccount()->getUuid()];
        }

        // we can add condition to only show data that downStream (children) the user here
        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        $roleUuid = $userAccess->getUserRole()->getUuid();
        $rolesDown = $this->getUserRoleMapper()->getRoleDownStream($roleUuid);

        $queryParams['role_down_stream'] = $rolesDown;

        $queryParams = array_merge($queryParams, $urlParams);
        // var_dump($queryParams);exit;
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

        $qb = $this->getUserAccessMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getUserAccessMapper()->createPaginatorAdapter($qb);
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
        if ($id == '7d9a0202-8b2c-4863-bbfb-e6722f33b2ee') {
            return new ApiProblem(422, "This data cannot be deleted or changed, Contact the admin if you need permission");
        }
        
        $userAccess = $this->getUserAccessMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($userAccess)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Access data not found!"));
        }

        if (strtolower($userAccess->getUserRole()->getName()) == \User\V1\Role::ADMIN) {
            return new ApiProblemResponse(new ApiProblem(422, "You can't update this data, please contact super admin!"));
        }

        $inputFilter = $this->getInputFilter();

        $this->getUserAccessService()->update($userAccess, $inputFilter);
        return $userAccess;
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
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }

    /**
     * Get the value of userAccessService
     */ 
    public function getUserAccessService()
    {
        return $this->userAccessService;
    }

    /**
     * Set the value of userAccessService
     *
     * @return  self
     */ 
    public function setUserAccessService($userAccessService)
    {
        $this->userAccessService = $userAccessService;

        return $this;
    }
}
