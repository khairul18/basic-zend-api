<?php
namespace Department\V1\Rest\Department;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator as ZendPaginator;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserProfile as UserProfileMapper;
use Department\Mapper\Department as DepartmentMapper;
use Department\Mapper\DepartmentTrait as DepartmentMapperTrait;
use User\V1\Role;

class DepartmentResource extends AbstractResource
{
    use DepartmentMapperTrait;

    protected $departmentService;

    public function __construct(
        UserProfileMapper $userProfileMapper,
        DepartmentMapper $departmentMapper,
        \User\Mapper\UserAccess $userAccessMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
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
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $data = (array) $data;
        $inputFilter = $this->getInputFilter();

        try {
            $inputFilter->add(['name' => 'account']);
            $inputFilter->get('account')->setValue($userProfile->getAccount());

            $inputFilter->add(['name' => 'isActive']);
            $inputFilter->get('isActive')->setValue(1);

            $inputFilter->add(['name' => 'createdAt']);
            $inputFilter->get('createdAt')->setValue(new \DateTime('now'));

            $inputFilter->add(['name' => 'updatedAt']);
            $inputFilter->get('updatedAt')->setValue(new \DateTime('now'));

            $result = $this->getDepartmentService()->save($inputFilter);
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

        try {
            $department = $this->getDepartmentMapper()->fetchOneBy(['uuid' => $id]);
            if (is_null($department)) {
                return new ApiProblem(404, "Department Data Not Found");
            }
            return $this->getDepartmentService()->delete($department);
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $department;
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
                // 'account'   => $userProfile->getAccount()->getUuid(),
                'uuid' => $id
            ];

            $data = $this->getDepartmentMapper()->fetchOneBy($queryParams);
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

        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (! is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }
        
        if ($role == Role::MANAGER) {
            $queryParams['company_uuid'] = $userProfile->getCompany()->getUuid();
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

        $qb = $this->getDepartmentMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getDepartmentMapper()->createPaginatorAdapter($qb);
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
        $department = $this->getDepartmentMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($department)) {
            return new ApiProblemResponse(new ApiProblem(404, "Department data not found!"));
        }
        $inputFilter = $this->getInputFilter();

        $this->getDepartmentService()->update($department, $inputFilter);
        return $department;
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
     * Get the value of departmentService
     */
    public function getDepartmentService()
    {
        return $this->departmentService;
    }

    /**
     * Set the value of departmentService
     *
     * @return  self
     */
    public function setDepartmentService($departmentService)
    {
        $this->departmentService = $departmentService;

        return $this;
    }
}
