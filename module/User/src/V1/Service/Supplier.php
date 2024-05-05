<?php

namespace User\V1\Service;

use User\V1\SupplierEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Supplier
{
    use EventManagerAwareTrait;

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return void
     */
    public function save(InputFilter $input)
    {
        $event = new SupplierEvent();
        $event->setInput($input);
        $event->setName(SupplierEvent::EVENT_CREATE_SUPPLIER);
        $create = $this->getEventManager()->triggerEvent($event);

        if ($create->stopped()) {
            $event->setName(SupplierEvent::EVENT_CREATE_SUPPLIER_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(SupplierEvent::EVENT_CREATE_SUPPLIER_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getSupplier();
        }
    }

    /**
     * @param  \User\Entity\Supplier  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \User\Entity\Supplier
     */
    public function update($entity, InputFilter $input)
    {
        $event = new SupplierEvent();
        $event->setSupplier($entity);
        $event->setInput($input);
        $event->setName(SupplierEvent::EVENT_UPDATE_SUPPLIER);
        $update = $this->getEventManager()->triggerEvent($event);

        if ($update->stopped()) {
            $event->setName(SupplierEvent::EVENT_UPDATE_SUPPLIER_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(SupplierEvent::EVENT_UPDATE_SUPPLIER_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getSupplier();
        }
    }

    /**
     * @param  \User\Entity\Supplier  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new SupplierEvent();
        $event->setSupplier($entity);
        $event->setName(SupplierEvent::EVENT_DELETE_SUPPLIER);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(SupplierEvent::EVENT_DELETE_SUPPLIER_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(SupplierEvent::EVENT_DELETE_SUPPLIER_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
