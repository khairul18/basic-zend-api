<?php
namespace User\V1\Rest\UserAcl;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator as ZendPaginator;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserAcl as UserAclMapper;
use User\Mapper\UserAclTrait as UserAclMapperTrait;
use User\V1\Role;

class UserAclResource extends AbstractResource
{
    use UserAclMapperTrait;

    protected $userAclService;

    public function __construct(
        UserProfileMapper $userProfileMapper,
        \User\Mapper\UserAcl $userAclMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserAclMapper($userAclMapper);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
        try {
            $userProfile = $this->fetchUserProfile();
            if ($userProfile === null) {
                return;
            }

            $queryParams = [
                'uuid' => $id
            ];

            $data = $this->getUserAclMapper()->fetchOneBy($queryParams);
            if (is_null($data)) {
                return new ApiProblemResponse(new ApiProblem(404, "User Acl data not found!"));
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
        // var_dump('was here');exit;
        $userProfile = $this->fetchUserProfile();

        $urlParams   = $params->toArray();

        $queryParams = [];
        
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

        $qb = $this->getUserAclMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getUserAclMapper()->createPaginatorAdapter($qb);
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
        return new ApiProblem(405, 'The POST method has not been defined');
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
     * Get the value of userAclService
     */ 
    public function getUserAclService()
    {
        return $this->userAclService;
    }

    /**
     * Set the value of userAclService
     *
     * @return  self
     */ 
    public function setUserAclService($userAclService)
    {
        $this->userAclService = $userAclService;

        return $this;
    }
}
