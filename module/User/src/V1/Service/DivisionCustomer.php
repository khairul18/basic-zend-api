<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\DivisionCustomerEvent;

class DivisionCustomer
{
    use EventManagerAwareTrait;

    protected $divisionCustomerEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $divisionCustomerEvent = new DivisionCustomerEvent();
        $divisionCustomerEvent->setInputFilter($inputFilter);
        $divisionCustomerEvent->setName(DivisionCustomerEvent::EVENT_CREATE_DIVISION_CUSTOMER);
        $create = $this->getEventManager()->triggerEvent($divisionCustomerEvent);
        if ($create->stopped()) {
            $divisionCustomerEvent->setName(DivisionCustomerEvent::EVENT_CREATE_DIVISION_CUSTOMER_ERROR);
            $divisionCustomerEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($divisionCustomerEvent);
            throw $divisionCustomerEvent->getException();
        } else {
            $divisionCustomerEvent->setName(DivisionCustomerEvent::EVENT_CREATE_DIVISION_CUSTOMER_SUCCESS);
            $this->getEventManager()->triggerEvent($divisionCustomerEvent);
            return $divisionCustomerEvent->getDivisionCustomerEntity();
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
     * Get the value of divisionCustomerEvent
     */
    public function getDivisionCustomerEvent()
    {
        if ($this->divisionCustomerEvent == null) {
            $this->divisionCustomerEvent = new DivisionCustomerEvent();
        }

        return $this->divisionCustomerEvent;
    }

    /**
     * Set the value of divisionCustomerEvent
     *
     * @return  self
     */
    public function setDivisionCustomerEvent($divisionCustomerEvent)
    {
        $this->divisionCustomerEvent = $divisionCustomerEvent;

        return $this;
    }
}
