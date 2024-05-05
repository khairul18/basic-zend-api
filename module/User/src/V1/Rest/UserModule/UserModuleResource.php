<?php
namespace User\V1\Rest\UserModule;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator as ZendPaginator;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserModule as UserModuleMapper;
use User\Mapper\UserModuleTrait as UserModuleMapperTrait;

class UserModuleResource extends AbstractResource
{
    use UserModuleMapperTrait;

    protected $userModuleService;

    public function __construct(
        UserProfileMapper $userProfileMapper,
        UserModuleMapper $userModuleMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserModuleMapper($userModuleMapper);
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
            $inputFilter->add(['name' => 'status']);
            $inputFilter->get('status')->setValue(1);

            $inputFilter->add(['name' => 'createdAt']);
            $inputFilter->get('createdAt')->setValue(new \DateTime('now'));

            $inputFilter->add(['name' => 'updatedAt']);
            $inputFilter->get('updatedAt')->setValue(new \DateTime('now'));

            $result = $this->getUserModuleService()->save($inputFilter);
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
        $userModule = $this->getUserModuleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($userModule)) {
            return new ApiProblemResponse(new ApiProblem(404, 'User Module data not found'));
        }

        return $userModule;
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

        $qb = $this->getUserModuleMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getUserModuleMapper()->createPaginatorAdapter($qb);
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
        $userModule = $this->getUserModuleMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($userModule)) {
            return new ApiProblemResponse(new ApiProblem(404, "User Module data not found!"));
        }
        $inputFilter = $this->getInputFilter();

        $this->getUserModuleService()->update($userModule, $inputFilter);
        return $userModule;
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
     * Get the value of userModuleService
     */ 
    public function getUserModuleService()
    {
        return $this->userModuleService;
    }

    /**
     * Set the value of userModuleService
     *
     * @return  self
     */ 
    public function setUserModuleService($userModuleService)
    {
        $this->userModuleService = $userModuleService;

        return $this;
    }
}
