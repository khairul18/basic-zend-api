<?php

namespace Department\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class GroupEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_GROUP         = 'create.group';
    const EVENT_CREATE_GROUP_ERROR   = 'create.group.error';
    const EVENT_CREATE_GROUP_SUCCESS = 'create.group.success';

    const EVENT_UPDATE_GROUP         = 'update.group';
    const EVENT_UPDATE_GROUP_ERROR   = 'update.group.error';
    const EVENT_UPDATE_GROUP_SUCCESS = 'update.group.success';

    const EVENT_DELETE_GROUP         = 'delete.group';
    const EVENT_DELETE_GROUP_ERROR   = 'delete.group.error';
    const EVENT_DELETE_GROUP_SUCCESS = 'delete.group.success';

    /**#@-*/

    /**
     * @var Department\Entity\Group
     */
    protected $groupEntity;

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
     * Get the value of groupEntity
     *
     * @return  Department\Entity\Group
     */ 
    public function getGroupEntity()
    {
        return $this->groupEntity;
    }

    /**
     * Set the value of groupEntity
     *
     * @param  Department\Entity\Group  $groupEntity
     *
     * @return  self
     */ 
    public function setGroupEntity(\Department\Entity\Group $groupEntity)
    {
        $this->groupEntity = $groupEntity;

        return $this;
    }
}
