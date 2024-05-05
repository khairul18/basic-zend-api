<?php

namespace Department\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class GroupUserEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_GROUP_USER         = 'create.group.user';
    const EVENT_CREATE_GROUP_USER_ERROR   = 'create.group.user.error';
    const EVENT_CREATE_GROUP_USER_SUCCESS = 'create.group.user.success';

    const EVENT_UPDATE_GROUP_USER         = 'update.group.user';
    const EVENT_UPDATE_GROUP_USER_ERROR   = 'update.group.user.error';
    const EVENT_UPDATE_GROUP_USER_SUCCESS = 'update.group.user.success';

    const EVENT_DELETE_GROUP_USER         = 'delete.group.user';
    const EVENT_DELETE_GROUP_USER_ERROR   = 'delete.group.user.error';
    const EVENT_DELETE_GROUP_USER_SUCCESS = 'delete.group.user.success';

    /**#@-*/

    /**
     * @var Department\Entity\GroupUser
     */
    protected $groupUserEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var \Exception
     */
    protected $exception;

    protected $updateData;

    protected $deleteData;

    /**
     * @var string
     */
    protected $notificationId;

    protected $notificationMessage;

    protected $bodyResponse;


    /**
     * @return the $inputFilter
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * @param Zend\InputFilter\InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * @return the $exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function getUpdateData()
    {
        return $this->updateData;
    }

    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;
    }

    /**
     * Get the value of notificationId
     *
     * @return  string
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }

    /**
     * Set the value of notificationId
     *
     * @param  string  $notificationId
     *
     * @return  self
     */
    public function setNotificationId($notificationId)
    {
        $this->notificationId = $notificationId;

        return $this;
    }

    /**
     * Get the value of bodyResponse
     */
    public function getBodyResponse()
    {
        return $this->bodyResponse;
    }

    /**
     * Set the value of bodyResponse
     *
     * @return  self
     */
    public function setBodyResponse($bodyResponse)
    {
        $this->bodyResponse = $bodyResponse;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotificationMessage()
    {
        return $this->notificationMessage;
    }

    /**
     * @param mixed $notificationMessage
     *
     * @return self
     */
    public function setNotificationMessage($notificationMessage)
    {
        $this->notificationMessage = $notificationMessage;

        return $this;
    }

    /**
     * Get the value of deleteData
     */
    public function getDeleteData()
    {
        return $this->deleteData;
    }

    /**
     * Set the value of deleteData
     *
     * @return  self
     */
    public function setDeleteData($deleteData)
    {
        $this->deleteData = $deleteData;

        return $this;
    }

    /**
     * Get the value of groupUserEntity
     *
     * @return  Department\Entity\GroupUser
     */ 
    public function getGroupUserEntity()
    {
        return $this->groupUserEntity;
    }

    /**
     * Set the value of groupUserEntity
     *
     * @param  Department\Entity\GroupUser  $groupUserEntity
     *
     * @return  self
     */ 
    public function setGroupUserEntity(\Department\Entity\GroupUser $groupUserEntity)
    {
        $this->groupUserEntity = $groupUserEntity;

        return $this;
    }
}
