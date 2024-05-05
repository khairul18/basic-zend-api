<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\EducationEvent;

class Education
{
    use EventManagerAwareTrait;

    protected $educationEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $educationEvent = new EducationEvent();
        $educationEvent->setInputFilter($inputFilter);
        $educationEvent->setName(EducationEvent::EVENT_CREATE_EDUCATION);
        $create = $this->getEventManager()->triggerEvent($educationEvent);
        if ($create->stopped()) {
            $educationEvent->setName(EducationEvent::EVENT_CREATE_EDUCATION_ERROR);
            $educationEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($educationEvent);
            throw $educationEvent->getException();
        } else {
            $educationEvent->setName(EducationEvent::EVENT_CREATE_EDUCATION_SUCCESS);
            $this->getEventManager()->triggerEvent($educationEvent);
            return $educationEvent->getEducationEntity();
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
     * Get the value of educationEvent
     */
    public function getEducationEvent()
    {
        if ($this->educationEvent == null) {
            $this->educationEvent = new EducationEvent();
        }

        return $this->educationEvent;
    }

    /**
     * Set the value of educationEvent
     *
     * @return  self
     */
    public function setEducationEvent($educationEvent)
    {
        $this->educationEvent = $educationEvent;

        return $this;
    }
}
