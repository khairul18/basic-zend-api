<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\BusinessSectorEvent;

class BusinessSector
{
    use EventManagerAwareTrait;

    protected $businessSectorEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $businessSectorEvent = new BusinessSectorEvent();
        $businessSectorEvent->setInputFilter($inputFilter);
        $businessSectorEvent->setName(BusinessSectorEvent::EVENT_CREATE_BUSINESS_SECTOR);
        $create = $this->getEventManager()->triggerEvent($businessSectorEvent);
        if ($create->stopped()) {
            $businessSectorEvent->setName(BusinessSectorEvent::EVENT_CREATE_BUSINESS_SECTOR_ERROR);
            $businessSectorEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($businessSectorEvent);
            throw $businessSectorEvent->getException();
        } else {
            $businessSectorEvent->setName(BusinessSectorEvent::EVENT_CREATE_BUSINESS_SECTOR_SUCCESS);
            $this->getEventManager()->triggerEvent($businessSectorEvent);
            return $businessSectorEvent->getBusinessSectorEntity();
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
     * Get the value of businessSectorEvent
     */
    public function getBusinessSectorEvent()
    {
        if ($this->businessSectorEvent == null) {
            $this->businessSectorEvent = new BusinessSectorEvent();
        }

        return $this->businessSectorEvent;
    }

    /**
     * Set the value of businessSectorEvent
     *
     * @return  self
     */
    public function setBusinessSectorEvent($businessSectorEvent)
    {
        $this->businessSectorEvent = $businessSectorEvent;

        return $this;
    }
}
