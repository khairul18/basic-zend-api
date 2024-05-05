<?php

namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\TaxValueEvent;

class TaxValue
{
    use EventManagerAwareTrait;

    protected $taxValueEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $taxValueEvent = new TaxValueEvent();
        $taxValueEvent->setInputFilter($inputFilter);
        $taxValueEvent->setName(TaxValueEvent::EVENT_CREATE_TAX_VALUE);
        $create = $this->getEventManager()->triggerEvent($taxValueEvent);
        if ($create->stopped()) {
            $taxValueEvent->setName(TaxValueEvent::EVENT_CREATE_TAX_VALUE_ERROR);
            $taxValueEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($taxValueEvent);
            throw $taxValueEvent->getException();
        } else {
            $taxValueEvent->setName(TaxValueEvent::EVENT_CREATE_TAX_VALUE_SUCCESS);
            $this->getEventManager()->triggerEvent($taxValueEvent);
            return $taxValueEvent->getTaxValueEntity();
        }
    }


    /**
     * Update TaxValue
     *
     * @param \User\Entity\TaxValue  $taxValue
     * @param array                     $updateData
     */
    public function update($taxValue, $inputFilter)
    {
        $taxValueEvent = $this->getTaxValueEvent();
        $taxValueEvent->setTaxValueEntity($taxValue);

        $taxValueEvent->setUpdateData($inputFilter->getValues());
        $taxValueEvent->setInputFilter($inputFilter);
        $taxValueEvent->setName(TaxValueEvent::EVENT_UPDATE_TAX_VALUE);

        $update = $this->getEventManager()->triggerEvent($taxValueEvent);
        if ($update->stopped()) {
            $taxValueEvent->setName(TaxValueEvent::EVENT_UPDATE_TAX_VALUE_ERROR);
            $taxValueEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($taxValueEvent);
            throw $taxValueEvent->getException();
        } else {
            $taxValueEvent->setName(TaxValueEvent::EVENT_UPDATE_TAX_VALUE_SUCCESS);
            $this->getEventManager()->triggerEvent($taxValueEvent);
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
     * Get the value of taxValueEvent
     */
    public function getTaxValueEvent()
    {
        if ($this->taxValueEvent == null) {
            $this->taxValueEvent = new TaxValueEvent();
        }

        return $this->taxValueEvent;
    }

    /**
     * Set the value of taxValueEvent
     *
     * @return  self
     */
    public function setTaxValueEvent($taxValueEvent)
    {
        $this->taxValueEvent = $taxValueEvent;

        return $this;
    }
}
