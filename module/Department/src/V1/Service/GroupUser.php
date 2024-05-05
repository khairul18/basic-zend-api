<?php
namespace Department\V1\Service;

use Department\Entity\GroupUser as GroupUserEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Department\V1\GroupUserEvent;

class GroupUser
{
    use EventManagerAwareTrait;

    protected $groupUserEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $groupUserEvent = new GroupUserEvent();
        $groupUserEvent->setInputFilter($inputFilter);
        $groupUserEvent->setName(GroupUserEvent::EVENT_CREATE_GROUP_USER);
        $create = $this->getEventManager()->triggerEvent($groupUserEvent);
        if ($create->stopped()) {
            $groupUserEvent->setName(GroupUserEvent::EVENT_CREATE_GROUP_USER_ERROR);
            $groupUserEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($groupUserEvent);
            throw $groupUserEvent->getException();
        } else {
            $groupUserEvent->setName(GroupUserEvent::EVENT_CREATE_GROUP_USER_SUCCESS);
            $this->getEventManager()->triggerEvent($groupUserEvent);
            return $groupUserEvent->getGroupUserEntity();
        }
    }

    /**
     * Update GroupUser
     *
     * @param \Department\Entity\GroupUser  $groupUser
     * @param array                     $updateData
     */
    public function update($groupUser, $inputFilter)
    {
        $groupUserEvent = $this->getGroupUserEvent();
        $groupUserEvent->setGroupUserEntity($groupUser);

        $groupUserEvent->setUpdateData($inputFilter->getValues());
        $groupUserEvent->setInputFilter($inputFilter);
        $groupUserEvent->setName(GroupUserEvent::EVENT_UPDATE_GROUP_USER);

        $update = $this->getEventManager()->triggerEvent($groupUserEvent);
        if ($update->stopped()) {
            $groupUserEvent->setName(GroupUserEvent::EVENT_UPDATE_GROUP_USER_ERROR);
            $groupUserEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($groupUserEvent);
            throw $groupUserEvent->getException();
        } else {
            $groupUserEvent->setName(GroupUserEvent::EVENT_UPDATE_GROUP_USER_SUCCESS);
            $this->getEventManager()->triggerEvent($groupUserEvent);
        }
    }

    public function delete(GroupUserEntity $deletedData)
    {
        $groupUserEvent = new GroupUserEvent();
        $groupUserEvent->setDeleteData($deletedData);
        $groupUserEvent->setName(GroupUserEvent::EVENT_DELETE_GROUP_USER);
        $create = $this->getEventManager()->triggerEvent($groupUserEvent);
        if ($create->stopped()) {
            $groupUserEvent->setName(GroupUserEvent::EVENT_DELETE_GROUP_USER_ERROR);
            $groupUserEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($groupUserEvent);
            throw $groupUserEvent->getException();
        } else {
            $groupUserEvent->setName(GroupUserEvent::EVENT_DELETE_GROUP_USER_SUCCESS);
            $this->getEventManager()->triggerEvent($groupUserEvent);
            return true;
        }
    }

    public function getGroupUserEvent()
    {
        if ($this->groupUserEvent == null) {
            $this->groupUserEvent = new GroupUserEvent();
        }

        return $this->groupUserEvent;
    }

    public function setGroupUserEvent(GroupUserEvent $groupUserEvent)
    {
        $this->groupUserEvent = $groupUserEvent;
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
