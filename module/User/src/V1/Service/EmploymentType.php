<?php
namespace User\V1\Service;

use User\Entity\EmploymentType as EmploymentTypeEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\EmploymentTypeEvent;

class EmploymentType
{
    use EventManagerAwareTrait;

    protected $employmentTypeEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $employmentTypeEvent = new EmploymentTypeEvent();
        $employmentTypeEvent->setInputFilter($inputFilter);
        $employmentTypeEvent->setName(EmploymentTypeEvent::EVENT_CREATE_EMPLOYMENT_TYPE);
        $create = $this->getEventManager()->triggerEvent($employmentTypeEvent);
        if ($create->stopped()) {
            $employmentTypeEvent->setName(EmploymentTypeEvent::EVENT_CREATE_EMPLOYMENT_TYPE_ERROR);
            $employmentTypeEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($employmentTypeEvent);
            throw $employmentTypeEvent->getException();
        } else {
            $employmentTypeEvent->setName(EmploymentTypeEvent::EVENT_CREATE_EMPLOYMENT_TYPE_SUCCESS);
            $this->getEventManager()->triggerEvent($employmentTypeEvent);
            return $employmentTypeEvent->getEmploymentTypeEntity();
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
     * Get the value of employmentTypeEvent
     */
    public function getEmploymentTypeEvent()
    {
        if ($this->employmentTypeEvent == null) {
            $this->employmentTypeEvent = new EmploymentTypeEvent();
        }

        return $this->employmentTypeEvent;
    }

    /**
     * Set the value of employmentTypeEvent
     *
     * @return  self
     */
    public function setEmploymentTypeEvent($employmentTypeEvent)
    {
        $this->employmentTypeEvent = $employmentTypeEvent;

        return $this;
    }
}
