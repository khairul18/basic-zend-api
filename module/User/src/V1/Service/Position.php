<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\PositionEvent;

class Position
{
    use EventManagerAwareTrait;

    protected $positionEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $positionEvent = new PositionEvent();
        $positionEvent->setInputFilter($inputFilter);
        $positionEvent->setName(PositionEvent::EVENT_CREATE_POSITION);
        $create = $this->getEventManager()->triggerEvent($positionEvent);
        if ($create->stopped()) {
            $positionEvent->setName(PositionEvent::EVENT_CREATE_POSITION_ERROR);
            $positionEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($positionEvent);
            throw $positionEvent->getException();
        } else {
            $positionEvent->setName(PositionEvent::EVENT_CREATE_POSITION_SUCCESS);
            $this->getEventManager()->triggerEvent($positionEvent);
            return $positionEvent->getPositionEntity();
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
     * Get the value of positionEvent
     */
    public function getPositionEvent()
    {
        if ($this->positionEvent == null) {
            $this->positionEvent = new PositionEvent();
        }

        return $this->positionEvent;
    }

    /**
     * Set the value of positionEvent
     *
     * @return  self
     */
    public function setPositionEvent($positionEvent)
    {
        $this->positionEvent = $positionEvent;

        return $this;
    }
}
