<?php

namespace Department\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class DepartmentEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_DEPARTMENT         = 'create.department';
    const EVENT_CREATE_DEPARTMENT_ERROR   = 'create.department.error';
    const EVENT_CREATE_DEPARTMENT_SUCCESS = 'create.department.success';

    const EVENT_UPDATE_DEPARTMENT         = 'update.department';
    const EVENT_UPDATE_DEPARTMENT_ERROR   = 'update.department.error';
    const EVENT_UPDATE_DEPARTMENT_SUCCESS = 'update.department.success';

    const EVENT_DELETE_DEPARTMENT         = 'delete.department';
    const EVENT_DELETE_DEPARTMENT_ERROR   = 'delete.department.error';
    const EVENT_DELETE_DEPARTMENT_SUCCESS = 'delete.department.success';

    /**#@-*/

    /**
     * @var Department\Entity\Department
     */
    protected $departmentEntity;

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
     * Get the value of departmentEntity
     *
     * @return  Department\Entity\Department
     */
    public function getDepartmentEntity()
    {
        return $this->departmentEntity;
    }

    /**
     * Set the value of departmentEntity
     *
     * @param  Department\Entity\Department  $departmentEntity
     *
     * @return  self
     */
    public function setDepartmentEntity(\Department\Entity\Department $departmentEntity)
    {
        $this->departmentEntity = $departmentEntity;

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
}
