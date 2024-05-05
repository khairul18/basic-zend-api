<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class UserModuleEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_USER_MODULE         = 'create.user.module';
    const EVENT_CREATE_USER_MODULE_ERROR   = 'create.user.module.error';
    const EVENT_CREATE_USER_MODULE_SUCCESS = 'create.user.module.success';

    const EVENT_UPDATE_USER_MODULE         = 'update.user.module';
    const EVENT_UPDATE_USER_MODULE_ERROR   = 'update.user.module.error';
    const EVENT_UPDATE_USER_MODULE_SUCCESS = 'update.user.module.success';

    /**#@-*/

    /**
     * @var User\Entity\UserModule
     */
    protected $userModuleEntity;

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
     * Get the value of userModuleEntity
     *
     * @return  User\Entity\UserModule
     */
    public function getUserModuleEntity()
    {
        return $this->userModuleEntity;
    }

    /**
     * Set the value of userModuleEntity
     *
     * @param  User\Entity\UserModule  $userModuleEntity
     *
     * @return  self
     */
    public function setUserModuleEntity(\User\Entity\UserModule $userModuleEntity)
    {
        $this->userModuleEntity = $userModuleEntity;

        return $this;
    }
}
