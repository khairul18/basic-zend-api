<?php
namespace Department\V1\Service;

use Department\Entity\Group as GroupEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Department\V1\GroupEvent;

class Group
{
    use EventManagerAwareTrait;

    protected $groupEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $groupEvent = new GroupEvent();
        $groupEvent->setInputFilter($inputFilter);
        $groupEvent->setName(GroupEvent::EVENT_CREATE_GROUP);
        $create = $this->getEventManager()->triggerEvent($groupEvent);
        if ($create->stopped()) {
            $groupEvent->setName(GroupEvent::EVENT_CREATE_GROUP_ERROR);
            $groupEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($groupEvent);
            throw $groupEvent->getException();
        } else {
            $groupEvent->setName(GroupEvent::EVENT_CREATE_GROUP_SUCCESS);
            $this->getEventManager()->triggerEvent($groupEvent);
            return $groupEvent->getGroupEntity();
        }
    }

    /**
     * Update Group
     *
     * @param \Department\Entity\Group  $group
     * @param array                     $updateData
     */
    public function update($group, $inputFilter)
    {
        $groupEvent = $this->getGroupEvent();
        $groupEvent->setGroupEntity($group);

        $groupEvent->setUpdateData($inputFilter->getValues());
        $groupEvent->setInputFilter($inputFilter);
        $groupEvent->setName(GroupEvent::EVENT_UPDATE_GROUP);

        $update = $this->getEventManager()->triggerEvent($groupEvent);
        if ($update->stopped()) {
            $groupEvent->setName(GroupEvent::EVENT_UPDATE_GROUP_ERROR);
            $groupEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($groupEvent);
            throw $groupEvent->getException();
        } else {
            $groupEvent->setName(GroupEvent::EVENT_UPDATE_GROUP_SUCCESS);
            $this->getEventManager()->triggerEvent($groupEvent);
        }
    }

    public function delete(GroupEntity $deletedData)
    {
        $groupEvent = new GroupEvent();
        $groupEvent->setDeleteData($deletedData);
        $groupEvent->setName(GroupEvent::EVENT_DELETE_GROUP);
        $create = $this->getEventManager()->triggerEvent($groupEvent);
        if ($create->stopped()) {
            $groupEvent->setName(GroupEvent::EVENT_DELETE_GROUP_ERROR);
            $groupEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($groupEvent);
            throw $groupEvent->getException();
        } else {
            $groupEvent->setName(GroupEvent::EVENT_DELETE_GROUP_SUCCESS);
            $this->getEventManager()->triggerEvent($groupEvent);
            return true;
        }
    }

    public function getGroupEvent()
    {
        if ($this->groupEvent == null) {
            $this->groupEvent = new GroupEvent();
        }

        return $this->groupEvent;
    }

    public function setGroupEvent(GroupEvent $groupEvent)
    {
        $this->groupEvent = $groupEvent;
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
