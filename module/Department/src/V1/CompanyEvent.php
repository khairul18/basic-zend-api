<?php

namespace Department\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class CompanyEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */

    const EVENT_CREATE_COMPANY         = 'create.company';
    const EVENT_CREATE_COMPANY_ERROR   = 'create.company.error';
    const EVENT_CREATE_COMPANY_SUCCESS = 'create.company.success';

    const EVENT_UPDATE_COMPANY         = 'update.company';
    const EVENT_UPDATE_COMPANY_ERROR   = 'update.company.error';
    const EVENT_UPDATE_COMPANY_SUCCESS = 'update.company.success';

    const EVENT_DELETE_COMPANY         = 'delete.company';
    const EVENT_DELETE_COMPANY_ERROR   = 'delete.company.error';
    const EVENT_DELETE_COMPANY_SUCCESS = 'delete.company.success';

    const EVENT_DIVISION_COMPANY         = 'division.company';
    const EVENT_DIVISION_COMPANY_ERROR   = 'division.company.error';
    const EVENT_DIVISION_COMPANY_SUCCESS = 'division.company.success';

    /**#@-*/


    /**
     * @var User\Entity\UserProfile
     */
    protected $userProfileEntity;

    /**
     * @var Department\Entity\Company
     */
    protected $companyEntity;

    /**
     * @var Department\Entity\Department
     */
    protected $departmentEntity;

    /**
     * @var User\Entity\Branch
     */
    protected $branchEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var \Exception
     */
    protected $exception;

    protected $updateData;

    protected $deleteData;

    /**
     * @var string
     */
    protected $notificationId;

    protected $notificationMessage;

    protected $bodyResponse;


    /**
     * @return the $inputFilter
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * @param Zend\InputFilter\InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * @return the $exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function getUpdateData()
    {
        return $this->updateData;
    }

    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;
    }

    /**
     * Get the value of notificationId
     *
     * @return  string
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }

    /**
     * Set the value of notificationId
     *
     * @param  string  $notificationId
     *
     * @return  self
     */
    public function setNotificationId($notificationId)
    {
        $this->notificationId = $notificationId;

        return $this;
    }

    /**
     * Get the value of bodyResponse
     */
    public function getBodyResponse()
    {
        return $this->bodyResponse;
    }

    /**
     * Set the value of bodyResponse
     *
     * @return  self
     */
    public function setBodyResponse($bodyResponse)
    {
        $this->bodyResponse = $bodyResponse;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotificationMessage()
    {
        return $this->notificationMessage;
    }

    /**
     * @param mixed $notificationMessage
     *
     * @return self
     */
    public function setNotificationMessage($notificationMessage)
    {
        $this->notificationMessage = $notificationMessage;

        return $this;
    }

    /**
     * Get the value of companyEntity
     *
     * @return  Department\Entity\Company
     */
    public function getCompanyEntity()
    {
        return $this->companyEntity;
    }

    /**
     * Set the value of companyEntity
     *
     * @param  Department\Entity\Company  $companyEntity
     *
     * @return  self
     */
    public function setCompanyEntity(\Department\Entity\Company $companyEntity)
    {
        $this->companyEntity = $companyEntity;

        return $this;
    }

    /**
     * Get the value of deleteData
     */
    public function getDeleteData()
    {
        return $this->deleteData;
    }

    /**
     * Set the value of deleteData
     *
     * @return  self
     */
    public function setDeleteData($deleteData)
    {
        $this->deleteData = $deleteData;

        return $this;
    }

    /**
     * Get the value of departmentEntity
     *
     * @return  Department\Entity\Department
     */
    public function getDepartmentEntity()
    {
        return $this->departmentEntity;
    }

    /**
     * Set the value of departmentEntity
     *
     * @param  Department\Entity\Department  $departmentEntity
     *
     * @return  self
     */
    public function setDepartmentEntity(\Department\Entity\Department $departmentEntity)
    {
        $this->departmentEntity = $departmentEntity;

        return $this;
    }

    /**
     * Get the value of branchEntity
     *
     * @return  User\Entity\Branch
     */
    public function getBranchEntity()
    {
        return $this->branchEntity;
    }

    /**
     * Set the value of branchEntity
     *
     * @param  User\Entity\Branch  $branchEntity
     *
     * @return  self
     */
    public function setBranchEntity(\User\Entity\Branch $branchEntity)
    {
        $this->branchEntity = $branchEntity;

        return $this;
    }

    /**
     * Get the value of userProfileEntity
     *
     * @return  User\Entity\UserProfile
     */
    public function getUserProfileEntity()
    {
        return $this->userProfileEntity;
    }

    /**
     * Set the value of userProfileEntity
     *
     * @param  User\Entity\UserProfile  $userProfileEntity
     *
     * @return  self
     */
    public function setUserProfileEntity(\User\Entity\UserProfile $userProfileEntity)
    {
        $this->userProfileEntity = $userProfileEntity;

        return $this;
    }
}
