<?php
namespace User\V1\Service;

use User\Entity\UserAccess as UserAccessEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\UserAccessEvent;

class UserAccess
{
    use EventManagerAwareTrait;

    protected $userAccessEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $userAccessEvent = new UserAccessEvent();
        $userAccessEvent->setInputFilter($inputFilter);
        $userAccessEvent->setName(UserAccessEvent::EVENT_CREATE_USER_ACCESS);
        $create = $this->getEventManager()->triggerEvent($userAccessEvent);
        if ($create->stopped()) {
            $userAccessEvent->setName(UserAccessEvent::EVENT_CREATE_USER_ACCESS_ERROR);
            $userAccessEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userAccessEvent);
            throw $userAccessEvent->getException();
        } else {
            $userAccessEvent->setName(UserAccessEvent::EVENT_CREATE_USER_ACCESS_SUCCESS);
            $this->getEventManager()->triggerEvent($userAccessEvent);
            return $userAccessEvent->getUserAccessEntity();
        }
    }

    /**
     * Update UserAccess
     *
     * @param \User\Entity\UserAccess  $userAccess
     * @param array                     $updateData
     */
    public function update($userAccess, $inputFilter)
    {
        $userAccessEvent = $this->getUserAccessEvent();
        $userAccessEvent->setUserAccessEntity($userAccess);

        $userAccessEvent->setUpdateData($inputFilter->getValues());
        $userAccessEvent->setInputFilter($inputFilter);
        $userAccessEvent->setName(UserAccessEvent::EVENT_UPDATE_USER_ACCESS);

        $update = $this->getEventManager()->triggerEvent($userAccessEvent);
        if ($update->stopped()) {
            $userAccessEvent->setName(UserAccessEvent::EVENT_UPDATE_USER_ACCESS_ERROR);
            $userAccessEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($userAccessEvent);
            throw $userAccessEvent->getException();
        } else {
            $userAccessEvent->setName(UserAccessEvent::EVENT_UPDATE_USER_ACCESS_SUCCESS);
            $this->getEventManager()->triggerEvent($userAccessEvent);
        }
    }

    public function delete(UserAccessEntity $deletedData)
    {
        $userAccessEvent = new UserAccessEvent();
        $userAccessEvent->setDeleteData($deletedData);
        $userAccessEvent->setName(UserAccessEvent::EVENT_DELETE_USER_ACCESS);
        $create = $this->getEventManager()->triggerEvent($userAccessEvent);
        if ($create->stopped()) {
            $userAccessEvent->setName(UserAccessEvent::EVENT_DELETE_USER_ACCESS_ERROR);
            $userAccessEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userAccessEvent);
            throw $userAccessEvent->getException();
        } else {
            $userAccessEvent->setName(UserAccessEvent::EVENT_DELETE_USER_ACCESS_SUCCESS);
            $this->getEventManager()->triggerEvent($userAccessEvent);
            return true;
        }
    }

    public function getUserAccessEvent()
    {
        if ($this->userAccessEvent == null) {
            $this->userAccessEvent = new UserAccessEvent();
        }

        return $this->userAccessEvent;
    }

    public function setUserAccessEvent(UserAccessEvent $userAccessEvent)
    {
        $this->userAccessEvent = $userAccessEvent;
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
}
