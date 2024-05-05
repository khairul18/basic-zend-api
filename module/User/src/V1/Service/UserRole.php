<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\UserRoleEvent;

class UserRole
{
    use EventManagerAwareTrait;

    protected $userRoleEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $userRoleEvent = new UserRoleEvent();
        $userRoleEvent->setInputFilter($inputFilter);
        $userRoleEvent->setName(UserRoleEvent::EVENT_CREATE_USER_ROLE);
        $create = $this->getEventManager()->triggerEvent($userRoleEvent);
        if ($create->stopped()) {
            $userRoleEvent->setName(UserRoleEvent::EVENT_CREATE_USER_ROLE_ERROR);
            $userRoleEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userRoleEvent);
            throw $userRoleEvent->getException();
        } else {
            $userRoleEvent->setName(UserRoleEvent::EVENT_CREATE_USER_ROLE_SUCCESS);
            $this->getEventManager()->triggerEvent($userRoleEvent);
            return $userRoleEvent->getUserRoleEntity();
        }
    }

    /**
     * Update User Role
     *
     * @param \User\Entity\UserRole  $userRole
     * @param array                     $updateData
     */
    public function update($userRole, $inputFilter)
    {
        $userRoleEvent = $this->getUserRoleEvent();
        $userRoleEvent->setUserRoleEntity($userRole);

        $userRoleEvent->setUpdateData($inputFilter->getValues());
        $userRoleEvent->setInputFilter($inputFilter);
        $userRoleEvent->setName(UserRoleEvent::EVENT_UPDATE_USER_ROLE);

        $update = $this->getEventManager()->triggerEvent($userRoleEvent);
        if ($update->stopped()) {
            $userRoleEvent->setName(UserRoleEvent::EVENT_UPDATE_USER_ROLE_ERROR);
            $userRoleEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($userRoleEvent);
            throw $userRoleEvent->getException();
        } else {
            $userRoleEvent->setName(UserRoleEvent::EVENT_UPDATE_USER_ROLE_SUCCESS);
            $this->getEventManager()->triggerEvent($userRoleEvent);
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
     * Get the value of userRoleEvent
     */
    public function getUserRoleEvent()
    {
        if ($this->userRoleEvent == null) {
            $this->userRoleEvent = new UserRoleEvent();
        }

        return $this->userRoleEvent;
    }

    /**
     * Set the value of userRoleEvent
     *
     * @return  self
     */
    public function setUserRoleEvent($userRoleEvent)
    {
        $this->userRoleEvent = $userRoleEvent;

        return $this;
    }
}
