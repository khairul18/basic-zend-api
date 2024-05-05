<?php

namespace User\V1\Service;

use User\Entity\Customer as CustomerEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\CustomerEvent;

class Customer
{
    use EventManagerAwareTrait;

    protected $customerEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter, $optionFields = [], $socialMedia = [])
    {
        $customerEvent = new CustomerEvent();
        $customerEvent->setInputFilter($inputFilter);
        // $customerEvent->setOptionFields($optionFields);
        // $customerEvent->setSocialMediaArray($socialMedia);
        $customerEvent->setName(CustomerEvent::EVENT_CREATE_CUSTOMER);
        $create = $this->getEventManager()->triggerEvent($customerEvent);
        if ($create->stopped()) {
            $customerEvent->setName(CustomerEvent::EVENT_CREATE_CUSTOMER_ERROR);
            $customerEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($customerEvent);
            throw $customerEvent->getException();
        } else {
            $customerEvent->setName(CustomerEvent::EVENT_CREATE_CUSTOMER_SUCCESS);
            $this->getEventManager()->triggerEvent($customerEvent);
            return $customerEvent->getCustomerEntity();
        }
    }

    /**
     * Update Customer
     *
     * @param \User\Entity\Customer  $customer
     * @param array                  $updateData
     */
    public function update(CustomerEntity $customer, ZendInputFilter $inputFilter, $optionFields = [], $socialMedia = [])
    {
        $customerEvent = $this->getCustomerEvent();
        $customerEvent->setCustomerEntity($customer);
        // $customerEvent->setOptionFields($optionFields);
        // $customerEvent->setSocialMediaArray($socialMedia);
        $customerEvent->setUpdateData($inputFilter->getValues());
        $customerEvent->setInputFilter($inputFilter);
        $customerEvent->setName(CustomerEvent::EVENT_UPDATE_CUSTOMER);

        $update = $this->getEventManager()->triggerEvent($customerEvent);
        if ($update->stopped()) {
            $customerEvent->setName(CustomerEvent::EVENT_UPDATE_CUSTOMER_ERROR);
            $customerEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($customerEvent);
            throw $customerEvent->getException();
        } else {
            $customerEvent->setName(CustomerEvent::EVENT_UPDATE_CUSTOMER_SUCCESS);
            $this->getEventManager()->triggerEvent($customerEvent);
        }
    }

    public function delete(CustomerEntity $deletedData)
    {
        $customerEvent = new CustomerEvent();
        $customerEvent->setDeleteData($deletedData);
        $customerEvent->setName(CustomerEvent::EVENT_DELETE_CUSTOMER);
        $create = $this->getEventManager()->triggerEvent($customerEvent);
        if ($create->stopped()) {
            $customerEvent->setName(CustomerEvent::EVENT_DELETE_CUSTOMER_ERROR);
            $customerEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($customerEvent);
            throw $customerEvent->getException();
        } else {
            $customerEvent->setName(CustomerEvent::EVENT_DELETE_CUSTOMER_SUCCESS);
            $this->getEventManager()->triggerEvent($customerEvent);
            return true;
        }
    }

    public function getCustomerEvent()
    {
        if ($this->customerEvent == null) {
            $this->customerEvent = new CustomerEvent();
        }

        return $this->customerEvent;
    }

    public function setCustomerEvent(CustomerEvent $customerEvent)
    {
        $this->customerEvent = $customerEvent;
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
