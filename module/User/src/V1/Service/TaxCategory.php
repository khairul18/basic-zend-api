<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\TaxCategoryEvent;

class TaxCategory
{
    use EventManagerAwareTrait;

    protected $taxCategoryEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $taxCategoryEvent = new TaxCategoryEvent();
        $taxCategoryEvent->setInputFilter($inputFilter);
        $taxCategoryEvent->setName(TaxCategoryEvent::EVENT_CREATE_TAX_CATEGORY);
        $create = $this->getEventManager()->triggerEvent($taxCategoryEvent);
        if ($create->stopped()) {
            $taxCategoryEvent->setName(TaxCategoryEvent::EVENT_CREATE_TAX_CATEGORY_ERROR);
            $taxCategoryEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($taxCategoryEvent);
            throw $taxCategoryEvent->getException();
        } else {
            $taxCategoryEvent->setName(TaxCategoryEvent::EVENT_CREATE_TAX_CATEGORY_SUCCESS);
            $this->getEventManager()->triggerEvent($taxCategoryEvent);
            return $taxCategoryEvent->getTaxCategoryEntity();
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
     * Get the value of taxCategoryEvent
     */
    public function getTaxCategoryEvent()
    {
        if ($this->taxCategoryEvent == null) {
            $this->taxCategoryEvent = new TaxCategoryEvent();
        }

        return $this->taxCategoryEvent;
    }

    /**
     * Set the value of taxCategoryEvent
     *
     * @return  self
     */
    public function setTaxCategoryEvent($taxCategoryEvent)
    {
        $this->taxCategoryEvent = $taxCategoryEvent;

        return $this;
    }
}
