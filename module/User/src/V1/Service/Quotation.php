<?php

namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use User\V1\QuotationEvent;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\Entity\Quotation as QuotationEntity;

class Quotation
{
    use EventManagerAwareTrait;

    protected $quotationEvent;
    protected $config;

    public function save(ZendInputFilter $inputFilter, $optionFields = [])
    {
        $quotationEvent = $this->getQuotationEvent();
        $quotationEvent->setInputFilter($inputFilter);
        $quotationEvent->setOptionFields($optionFields);
        $quotationEvent->setName(QuotationEvent::EVENT_CREATE_QUOTATION);
        $create = $this->getEventManager()->triggerEvent($quotationEvent);
        if ($create->stopped()) {
            $quotationEvent->setName(QuotationEvent::EVENT_CREATE_QUOTATION_ERROR);
            $quotationEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($quotationEvent);
            throw $quotationEvent->getException();
        } else {
            $quotationEvent->setName(QuotationEvent::EVENT_CREATE_QUOTATION_SUCCESS);
            $this->getEventManager()->triggerEvent($quotationEvent);
            return $quotationEvent->getQuotationEntity();
        }
    }

    /**
     * Update Quotation
     *
     * @param \Item\Entity\UserProfile  $userProfile
     * @param array                     $updateData
     */
    public function update(QuotationEntity $quotation, ZendInputFilter $inputFilter, $optionFields = [])
    {
        $quotationEvent = $this->getQuotationEvent();
        $quotationEvent->setQuotationEntity($quotation);
        $quotationEvent->setUpdateData($inputFilter->getValues());
        $quotationEvent->setInputFilter($inputFilter);
        $quotationEvent->setOptionFields($optionFields);
        $quotationEvent->setName(QuotationEvent::EVENT_UPDATE_QUOTATION);
        $update = $this->getEventManager()->triggerEvent($quotationEvent);
        if ($update->stopped()) {
            $quotationEvent->setName(QuotationEvent::EVENT_UPDATE_QUOTATION_ERROR);
            $quotationEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($quotationEvent);
            throw $quotationEvent->getException();
        } else {
            $quotationEvent->setName(QuotationEvent::EVENT_UPDATE_QUOTATION_SUCCESS);
            $this->getEventManager()->triggerEvent($quotationEvent);
            return $quotationEvent->getQuotationEntity();
        }
    }

    public function action(QuotationEntity $quotation, ZendInputFilter $inputFilter)
    {
        $quotationEvent = new QuotationEvent();
        $quotationEvent->setQuotationEntity($quotation);
        $quotationEvent->setInputFilter($inputFilter);
        $quotationEvent->setName(QuotationEvent::EVENT_ACTION_QUOTATION);
        $action = $this->getEventManager()->triggerEvent($quotationEvent);
        if ($action->stopped()) {
            $quotationEvent->setName(QuotationEvent::EVENT_ACTION_QUOTATION_ERROR);
            $quotationEvent->setException($action->last());
            $this->getEventManager()->triggerEvent($quotationEvent);
            throw $quotationEvent->getException();
        } else {
            $quotationEvent->setName(QuotationEvent::EVENT_ACTION_QUOTATION_SUCCESS);
            $this->getEventManager()->triggerEvent($quotationEvent);
            return $quotationEvent->getQuotationEntity();
        }
    }
    /**
     * @param  \User\Entity\Supplier  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new QuotationEvent();
        $event->setQuotationEntity($entity);
        $event->setName(QuotationEvent::EVENT_DELETE_QUOTATION);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(QuotationEvent::EVENT_DELETE_QUOTATION_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(QuotationEvent::EVENT_DELETE_QUOTATION_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
    // here, check what u want to export
    public function exportQuotationGeneral($queryBuilder)
    {
        $tmpfname = tempnam('/tmp', 'report-');
        $result   = $queryBuilder->getResult();
        $record   = [];
        $file     = fopen($tmpfname, 'w');
        $headers = [
            'Quotation ID',
            'Customer',
            'Company',
            'Branch',
            'Reference Title',
            'Order Type',
            'Issued By',
            'Valid Till',
            'Status'
        ];
        fputcsv($file, $headers);
        foreach ($result as $quotation) {
            $userProfile = $quotation->getRequestedBy();
            $requestedBy = !is_null($userProfile) ? $userProfile->getFirstName() . ' ' . $userProfile->getLastName() : '-';
            $dueDate   = !is_null($quotation->getDueDate()) ? $quotation->getDueDate()->format('Y-m-d') : '-';
            $quotationDate   = !is_null($quotation->getQuotationDate()) ? $quotation->getQuotationDate()->format('Y-m-d') : '-';

            $record = [
                $quotation->getQuotationId(),
                $quotation->getCustomer()->getName(),
                $quotation->getCompany()->getName(),
                $quotation->getBranch()->getName(),
                $quotation->getReferenceTitle(),
                $quotation->getOrderType(),
                $requestedBy,
                $dueDate,
                $quotationDate,
                $quotation->getStatus()
            ];
            fputcsv($file, $record);
        }
        fclose($file);

        return $tmpfname;
    }

    public function getQuotationEvent()
    {
        if ($this->quotationEvent == null) {
            $this->quotationEvent = new QuotationEvent();
        }
        return $this->quotationEvent;
    }

    public function setQuotationEvent(QuotationEvent $quotationEvent)
    {
        $this->quotationEvent = $quotationEvent;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }
}
