<?php
namespace User\V1\Rest\UserDocument;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use User\V1\Rest\AbstractResource;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\UserDocumentTrait as UserDocumentMapperTrait;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use Zend\Paginator\Paginator as ZendPaginator;

class UserDocumentResource extends AbstractResource
{
    use UserProfileMapperTrait;
    use UserDocumentMapperTrait;
    use LoggerAwareTrait;

    protected $userDocumentService;

    function __construct(
        \User\Mapper\UserProfile $userProfileMapper,
        \User\Mapper\UserDocument $userDocumentMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserDocumentMapper($userDocumentMapper);
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
            $userDocument = $this->getUserDocumentService()->save($inputFilter);
        } catch (\User\V1\Service\Exception\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $userDocument;
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
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $urlParams   = $params->toArray();
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(401, 'You\'re not authorized'));
        }

        $queryParams = [];

        $order = null;
        $asc   = false;
        if (isset($urlParams['order'])) {
            $order = $urlParams['order'];
            unset($urlParams['order']);
        }

        if (isset($urlParams['asc'])) {
            $asc = $urlParams['asc'];
            unset($urlParams['asc']);
        }
        $queryParams = array_merge($queryParams, $urlParams);
        $qb = $this->getUserDocumentMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getUserDocumentMapper()->createPaginatorAdapter($qb);
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
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        try {
            $queryParams = ['uuid' => $id];
            $userDocumentEntity = $this->getUserDocumentMapper()->fetchOneBy($queryParams);
            $inputFilter = $this->getInputFilter();

            $inputFilter->add(['name' => 'updatedAt']);
            $inputFilter->get('updatedAt')->setValue(new \DateTime('now'));

            $userDocument = $this->getUserDocumentService()->update($userDocumentEntity, $inputFilter);
        } catch (\User\V1\Service\Exception\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $userDocument;
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
     * Get the value of userDocumentService
     */
    public function getUserDocumentService()
    {
        return $this->userDocumentService;
    }

    /**
     * Set the value of userDocumentService
     *
     * @return  self
     */
    public function setUserDocumentService($userDocumentService)
    {
        $this->userDocumentService = $userDocumentService;

        return $this;
    }
}
