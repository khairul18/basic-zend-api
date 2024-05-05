<?php
namespace User\V1\Rest\UserActivatedLog;

use Zend\Paginator\Paginator as ZendPaginator;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use ZF\ApiProblem\ApiProblemResponse;
use User\Mapper\UserActivatedLog as UserActivatedLogMapper;
use User\Mapper\UserActivatedLogTrait as UserActivatedLogMapperTrait;
use User\V1\Service\Profile as UserProfileService;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;

class UserActivatedLogResource extends AbstractResourceListener
{
    use UserActivatedLogMapperTrait;
    use UserAccessMapperTrait;

    protected $userActivatedLogMapper;

    public function __construct(
        $loggedInUser, 
        UserActivatedLogMapper $userActivatedLogMapper,
        \User\Mapper\UserAccess $userAccessMapper
    )
    {
        $this->userProfile = $loggedInUser;
        $this->setUserActivatedLogMapper($userActivatedLogMapper);
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
        return new ApiProblem(405, 'The POST method has not been defined');
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
        $userProfile = $this->userProfile;
        if ($userProfile === null || is_null($userProfile->getAccount())) {
            return;
        }
        
        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (! is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role !== \User\V1\Role::ADMIN) {
            return new ApiProblemResponse(new ApiProblem(403, "You have no access to here!"));
        }

        $logs = $this->getUserActivatedLogMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($logs)) {
            return new ApiProblemResponse(new ApiProblem(404, "There is no log found"));
        }

        return $logs;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $userProfile = $this->userProfile;
        if ($userProfile === null || is_null($userProfile->getAccount())) {
            return;
        }

        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (! is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role !== \User\V1\Role::ADMIN) {
            return new ApiProblemResponse(new ApiProblem(403, "You have no access to here!"));
        }

        $urlParams   = $params->toArray();
        $queryParams = [];
        $queryParams = array_merge($queryParams, $urlParams);

        $userRole    = $urlParams['role'];
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

        $logs = $this->getUserActivatedLogMapper()->fetchAll($queryParams, $order, $asc);
        if (is_null($logs)) {
            return new ApiProblemResponse(new ApiProblem(404, "There are no log"));
        }

        $paginatorAdapter = $this->getUserActivatedLogMapper()->createPaginatorAdapter($logs);
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
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
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
}
