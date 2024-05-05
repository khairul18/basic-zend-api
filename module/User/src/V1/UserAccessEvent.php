<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class UserAccessEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_USER_ACCESS         = 'create.user.access';
    const EVENT_CREATE_USER_ACCESS_ERROR   = 'create.user.access.error';
    const EVENT_CREATE_USER_ACCESS_SUCCESS = 'create.user.access.success';

    const EVENT_UPDATE_USER_ACCESS         = 'update.user.access';
    const EVENT_UPDATE_USER_ACCESS_ERROR   = 'update.user.access.error';
    const EVENT_UPDATE_USER_ACCESS_SUCCESS = 'update.user.access.success';

    const EVENT_DELETE_USER_ACCESS         = 'delete.user.access';
    const EVENT_DELETE_USER_ACCESS_ERROR   = 'delete.user.access.error';
    const EVENT_DELETE_USER_ACCESS_SUCCESS = 'delete.user.access.success';

    /**#@-*/

    /**
     * @var User\Entity\UserAccess
     */
    protected $userAccessEntity;

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
     * Get the value of userAccessEntity
     *
     * @return  User\Entity\UserAccess
     */ 
    public function getUserAccessEntity()
    {
        return $this->userAccessEntity;
    }

    /**
     * Set the value of userAccessEntity
     *
     * @param  User\Entity\UserAccess  $userAccessEntity
     *
     * @return  self
     */ 
    public function setUserAccessEntity(\User\Entity\UserAccess $userAccessEntity)
    {
        $this->userAccessEntity = $userAccessEntity;

        return $this;
    }
}
