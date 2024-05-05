<?php

namespace User\V1\Service;

use User\Entity\Department as DepartmentEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\DepartmentEvent;

class Department
{
    use EventManagerAwareTrait;

    protected $departmentEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $departmentEvent = new DepartmentEvent();
        $departmentEvent->setInputFilter($inputFilter);
        $departmentEvent->setName(DepartmentEvent::EVENT_CREATE_DEPARTMENT);
        $create = $this->getEventManager()->triggerEvent($departmentEvent);
        if ($create->stopped()) {
            $departmentEvent->setName(DepartmentEvent::EVENT_CREATE_DEPARTMENT_ERROR);
            $departmentEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($departmentEvent);
            throw $departmentEvent->getException();
        } else {
            $departmentEvent->setName(DepartmentEvent::EVENT_CREATE_DEPARTMENT_SUCCESS);
            $this->getEventManager()->triggerEvent($departmentEvent);
            return $departmentEvent->getDepartmentEntity();
        }
    }

    /**
     * Update Department
     *
     * @param \User\Entity\Department  $department
     * @param array                     $updateData
     */
    public function update($department, $inputFilter)
    {
        $departmentEvent = $this->getDepartmentEvent();
        $departmentEvent->setDepartmentEntity($department);

        $departmentEvent->setUpdateData($inputFilter->getValues());
        $departmentEvent->setInputFilter($inputFilter);
        $departmentEvent->setName(DepartmentEvent::EVENT_UPDATE_DEPARTMENT);

        $update = $this->getEventManager()->triggerEvent($departmentEvent);
        if ($update->stopped()) {
            $departmentEvent->setName(DepartmentEvent::EVENT_UPDATE_DEPARTMENT_ERROR);
            $departmentEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($departmentEvent);
            throw $departmentEvent->getException();
        } else {
            $departmentEvent->setName(DepartmentEvent::EVENT_UPDATE_DEPARTMENT_SUCCESS);
            $this->getEventManager()->triggerEvent($departmentEvent);
        }
    }

    public function delete(DepartmentEntity $deletedData)
    {
        $departmentEvent = new DepartmentEvent();
        $departmentEvent->setDeleteData($deletedData);
        $departmentEvent->setName(DepartmentEvent::EVENT_DELETE_DEPARTMENT);
        $create = $this->getEventManager()->triggerEvent($departmentEvent);
        if ($create->stopped()) {
            $departmentEvent->setName(DepartmentEvent::EVENT_DELETE_DEPARTMENT_ERROR);
            $departmentEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($departmentEvent);
            throw $departmentEvent->getException();
        } else {
            $departmentEvent->setName(DepartmentEvent::EVENT_DELETE_DEPARTMENT_SUCCESS);
            $this->getEventManager()->triggerEvent($departmentEvent);
            return true;
        }
    }

    public function getDepartmentEvent()
    {
        if ($this->departmentEvent == null) {
            $this->departmentEvent = new DepartmentEvent();
        }

        return $this->departmentEvent;
    }

    public function setDepartmentEvent(DepartmentEvent $departmentEvent)
    {
        $this->departmentEvent = $departmentEvent;
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
