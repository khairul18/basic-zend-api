<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\PositionCustomerEvent;

class PositionCustomer
{
    use EventManagerAwareTrait;

    protected $positionCustomerEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $positionCustomerEvent = new PositionCustomerEvent();
        $positionCustomerEvent->setInputFilter($inputFilter);
        $positionCustomerEvent->setName(PositionCustomerEvent::EVENT_CREATE_POSITION_CUSTOMER);
        $create = $this->getEventManager()->triggerEvent($positionCustomerEvent);
        if ($create->stopped()) {
            $positionCustomerEvent->setName(PositionCustomerEvent::EVENT_CREATE_POSITION_CUSTOMER_ERROR);
            $positionCustomerEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($positionCustomerEvent);
            throw $positionCustomerEvent->getException();
        } else {
            $positionCustomerEvent->setName(PositionCustomerEvent::EVENT_CREATE_POSITION_CUSTOMER_SUCCESS);
            $this->getEventManager()->triggerEvent($positionCustomerEvent);
            return $positionCustomerEvent->getPositionCustomerEntity();
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
     * Get the value of positionCustomerEvent
     */
    public function getPositionCustomerEvent()
    {
        if ($this->positionCustomerEvent == null) {
            $this->positionCustomerEvent = new PositionCustomerEvent();
        }

        return $this->positionCustomerEvent;
    }

    /**
     * Set the value of positionCustomerEvent
     *
     * @return  self
     */
    public function setPositionCustomerEvent($positionCustomerEvent)
    {
        $this->positionCustomerEvent = $positionCustomerEvent;

        return $this;
    }
}
