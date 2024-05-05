<?php
namespace User\V1\Rest\UserRole;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator as ZendPaginator;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserRole as UserRoleMapper;
use User\Mapper\UserRoleTrait as UserRoleMapperTrait;

class UserRoleResource extends AbstractResource
{
    use UserRoleMapperTrait;

    protected $userRoleService;

    public function __construct(
        UserProfileMapper $userProfileMapper,
        UserRoleMapper $userRoleMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserRoleMapper($userRoleMapper);
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
        
        $account = $userProfile->getAccount();
        if (is_null($account)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Account not found"));
        }

        try {
            $inputFilter->add(['name' => 'account']);
            $inputFilter->get('account')->setValue($account);

            $inputFilter->add(['name' => 'createdAt']);
            $inputFilter->get('createdAt')->setValue(new \DateTime('now'));

            $inputFilter->add(['name' => 'updatedAt']);
            $inputFilter->get('updatedAt')->setValue(new \DateTime('now'));

            $result = $this->getUserRoleService()->save($inputFilter);
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
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
        $userRole = $this->getUserRoleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($userRole)) {
            return new ApiProblemResponse(new ApiProblem(404, 'User Role data not found'));
        }

        return $userRole;
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
        if (! is_null($userProfile->getAccount())) {
            $queryParams = ["account" => $userProfile->getAccount()->getUuid()];
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

        $qb = $this->getUserRoleMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getUserRoleMapper()->createPaginatorAdapter($qb);
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
        $userRole = $this->getUserRoleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($userRole)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Role data not found!"));
        }
        $inputFilter = $this->getInputFilter();

        $this->getUserRoleService()->update($userRole, $inputFilter);
        return $userRole;
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
     * Get the value of userRoleService
     */ 
    public function getUserRoleService()
    {
        return $this->userRoleService;
    }

    /**
     * Set the value of userRoleService
     *
     * @return  self
     */ 
    public function setUserRoleService($userRoleService)
    {
        $this->userRoleService = $userRoleService;

        return $this;
    }
}
