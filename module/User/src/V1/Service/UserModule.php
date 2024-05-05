<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\UserModuleEvent;

class UserModule
{
    use EventManagerAwareTrait;

    protected $userModuleEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $userModuleEvent = new UserModuleEvent();
        $userModuleEvent->setInputFilter($inputFilter);
        $userModuleEvent->setName(UserModuleEvent::EVENT_CREATE_USER_MODULE);
        $create = $this->getEventManager()->triggerEvent($userModuleEvent);
        if ($create->stopped()) {
            $userModuleEvent->setName(UserModuleEvent::EVENT_CREATE_USER_MODULE_ERROR);
            $userModuleEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userModuleEvent);
            throw $userModuleEvent->getException();
        } else {
            $userModuleEvent->setName(UserModuleEvent::EVENT_CREATE_USER_MODULE_SUCCESS);
            $this->getEventManager()->triggerEvent($userModuleEvent);
            return $userModuleEvent->getUserModuleEntity();
        }
    }

    /**
     * Update User Module
     *
     * @param \User\Entity\UserModule  $userModule
     * @param array                     $updateData
     */
    public function update($userModule, $inputFilter)
    {
        $userModuleEvent = $this->getUserModuleEvent();
        $userModuleEvent->setUserModuleEntity($userModule);

        $userModuleEvent->setUpdateData($inputFilter->getValues());
        $userModuleEvent->setInputFilter($inputFilter);
        $userModuleEvent->setName(UserModuleEvent::EVENT_UPDATE_USER_MODULE);

        $update = $this->getEventManager()->triggerEvent($userModuleEvent);
        if ($update->stopped()) {
            $userModuleEvent->setName(UserModuleEvent::EVENT_UPDATE_USER_MODULE_ERROR);
            $userModuleEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($userModuleEvent);
            throw $userModuleEvent->getException();
        } else {
            $userModuleEvent->setName(UserModuleEvent::EVENT_UPDATE_USER_MODULE_SUCCESS);
            $this->getEventManager()->triggerEvent($userModuleEvent);
        }
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     *
     * @return self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the value of userModuleEvent
     */
    public function getUserModuleEvent()
    {
        if ($this->userModuleEvent == null) {
            $this->userModuleEvent = new UserModuleEvent();
        }

        return $this->userModuleEvent;
    }

    /**
     * Set the value of userModuleEvent
     *
     * @return  self
     */
    public function setUserModuleEvent($userModuleEvent)
    {
        $this->userModuleEvent = $userModuleEvent;

        return $this;
    }
}
