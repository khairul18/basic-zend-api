<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class UserRoleEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_USER_ROLE         = 'create.user.role';
    const EVENT_CREATE_USER_ROLE_ERROR   = 'create.user.role.error';
    const EVENT_CREATE_USER_ROLE_SUCCESS = 'create.user.role.success';

    const EVENT_UPDATE_USER_ROLE         = 'update.user.role';
    const EVENT_UPDATE_USER_ROLE_ERROR   = 'update.user.role.error';
    const EVENT_UPDATE_USER_ROLE_SUCCESS = 'update.user.role.success';

    /**#@-*/

    /**
     * @var User\Entity\UserRole
     */
    protected $userRoleEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var \Exception
     */
    protected $exception;

    protected $updateData;

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
     * Get the value of userRoleEntity
     *
     * @return  User\Entity\UserRole
     */
    public function getUserRoleEntity()
    {
        return $this->userRoleEntity;
    }

    /**
     * Set the value of userRoleEntity
     *
     * @param  User\Entity\UserRole  $userRoleEntity
     *
     * @return  self
     */
    public function setUserRoleEntity(\User\Entity\UserRole $userRoleEntity)
    {
        $this->userRoleEntity = $userRoleEntity;

        return $this;
    }
}
