<?php

namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\CompanyEvent;
use User\Entity\Company as CompanyEntity;

class Company
{
    use EventManagerAwareTrait;

    protected $companyEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $companyEvent = new CompanyEvent();
        $companyEvent->setInputFilter($inputFilter);
        $companyEvent->setName(CompanyEvent::EVENT_CREATE_COMPANY);
        $create = $this->getEventManager()->triggerEvent($companyEvent);
        if ($create->stopped()) {
            $companyEvent->setName(CompanyEvent::EVENT_CREATE_COMPANY_ERROR);
            $companyEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($companyEvent);
            throw $companyEvent->getException();
        } else {
            $companyEvent->setName(CompanyEvent::EVENT_CREATE_COMPANY_SUCCESS);
            $this->getEventManager()->triggerEvent($companyEvent);
            return $companyEvent->getCompanyEntity();
        }
    }

    /**
     * Update Company
     *
     * @param \User\Entity\Company  $company
     * @param array                     $updateData
     */
    public function update($company, $inputFilter)
    {
        $companyEvent = $this->getCompanyEvent();
        $companyEvent->setCompanyEntity($company);

        $companyEvent->setUpdateData($inputFilter->getValues());
        $companyEvent->setInputFilter($inputFilter);
        $companyEvent->setName(CompanyEvent::EVENT_UPDATE_COMPANY);

        $update = $this->getEventManager()->triggerEvent($companyEvent);
        if ($update->stopped()) {
            $companyEvent->setName(CompanyEvent::EVENT_UPDATE_COMPANY_ERROR);
            $companyEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($companyEvent);
            throw $companyEvent->getException();
        } else {
            $companyEvent->setName(CompanyEvent::EVENT_UPDATE_COMPANY_SUCCESS);
            $this->getEventManager()->triggerEvent($companyEvent);
        }
    }

    public function delete(CompanyEntity $deletedData)
    {
        $companyEvent = new CompanyEvent();
        $companyEvent->setDeleteData($deletedData);
        $companyEvent->setName(CompanyEvent::EVENT_DELETE_COMPANY);
        $create = $this->getEventManager()->triggerEvent($companyEvent);
        if ($create->stopped()) {
            $companyEvent->setName(CompanyEvent::EVENT_DELETE_COMPANY_ERROR);
            $companyEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($companyEvent);
            throw $companyEvent->getException();
        } else {
            $companyEvent->setName(CompanyEvent::EVENT_DELETE_COMPANY_SUCCESS);
            $this->getEventManager()->triggerEvent($companyEvent);
            return true;
        }
    }

    public function action($data, ZendInputFilter $inputFilter)
    {
        $companyEvent = new CompanyEvent();
        $level = strtolower($inputFilter->getValues()['level']);
        if ($level == 'department') {
            $companyEvent->setDepartmentEntity($data);
            $getEntity = $companyEvent->getDepartmentEntity();
        } elseif ($level == 'branch') {
            $companyEvent->setBranchEntity($data);
            $getEntity = $companyEvent->getBranchEntity();
        } elseif ($level == 'company') {
            $companyEvent->setCompanyEntity($data);
            $getEntity = $companyEvent->getCompanyEntity();
        } elseif ($level == 'personal') {
            $companyEvent->setUserProfileEntity($data);
            $getEntity = $companyEvent->getUserProfileEntity();
        }
        $companyEvent->setInputFilter($inputFilter);
        $companyEvent->setName(CompanyEvent::EVENT_DIVISION_COMPANY);
        $action = $this->getEventManager()->triggerEvent($companyEvent);
        if ($action->stopped()) {
            $companyEvent->setName(CompanyEvent::EVENT_DIVISION_COMPANY_ERROR);
            $companyEvent->setException($action->last());
            $this->getEventManager()->triggerEvent($companyEvent);
            throw $companyEvent->getException();
        } else {
            $companyEvent->setName(CompanyEvent::EVENT_DIVISION_COMPANY_SUCCESS);
            $this->getEventManager()->triggerEvent($companyEvent);
            return $getEntity;
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
     * Get the value of companyEvent
     */
    public function getCompanyEvent()
    {
        if ($this->companyEvent == null) {
            $this->companyEvent = new CompanyEvent();
        }
        return $this->companyEvent;
    }

    /**
     * Set the value of companyEvent
     *
     * @return  self
     */
    public function setCompanyEvent(CompanyEvent $companyEvent)
    {
        $this->companyEvent = $companyEvent;

        return $this;
    }
}
