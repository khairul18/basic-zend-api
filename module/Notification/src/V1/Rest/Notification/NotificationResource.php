<?php
namespace Notification\V1\Rest\Notification;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use User\V1\Rest\AbstractResource;
use Zend\Paginator\Paginator as ZendPaginator;
use Notification\Mapper\Notification as NotificationMapper;
use Notification\Mapper\NotificationTrait as NotificationMapperTrait;
use User\Mapper\UserProfile as UserProfileMapper;

class NotificationResource extends AbstractResource
{
    use NotificationMapperTrait;

    protected $notificationService;

    public function __construct(
        NotificationMapper $notificationMapper,
        UserProfileMapper $userProfileMapper
    ) {
        $this->setNotificationMapper($notificationMapper);
        $this->setUserProfileMapper($userProfileMapper);
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
        $userProfile = $this->fetchUserProfile();
        if ($userProfile === null) {
            return;
        }

        $queryParams = [
            'uuid' => $id,
        ];

        $data = $this->getNotificationMapper()->fetchOneBy($queryParams);
        if (is_null($data)) {
            $data = new ApiProblem(404, "Notification not found");
        }

        return $data;
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
        if ($userProfile === null) {
            return;
        }

        $queryParams = [
            'status_type' => 'OVERTIME,LEAVE,REIMBURSEMENT,PURCHASE_REQUISITION'
        ];
        $queryParams = array_merge($queryParams, $params->toArray());
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

        $qb = $this->getNotificationMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getNotificationMapper()->createPaginatorAdapter($qb);
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
        try {
            $newData = $this->getInputFilter();
            $oldData = $this->getNotificationMapper()->fetchOneBy(['uuid' => $id]);
            $status  = $this->getNotificationService()
                             ->update($newData, $oldData);
            return $status;
        } catch (\User\V1\Service\Exception\RuntimeException $e) {
            return new ApiProblem(500, $e->getMessage());
        }
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
     * Get the value of notificationService
     */
    public function getNotificationService()
    {
        return $this->notificationService;
    }

    /**
     * Set the value of notificationService
     *
     * @return  self
     */
    public function setNotificationService($notificationService)
    {
        $this->notificationService = $notificationService;

        return $this;
    }
}
