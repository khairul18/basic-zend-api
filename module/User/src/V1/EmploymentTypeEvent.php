<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class EmploymentTypeEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_EMPLOYMENT_TYPE         = 'create.employment.type';
    const EVENT_CREATE_EMPLOYMENT_TYPE_ERROR   = 'create.employment.type.error';
    const EVENT_CREATE_EMPLOYMENT_TYPE_SUCCESS = 'create.employment.type.success';

    const EVENT_UPDATE_EMPLOYMENT_TYPE         = 'update.employment.type';
    const EVENT_UPDATE_EMPLOYMENT_TYPE_ERROR   = 'update.employment.type.error';
    const EVENT_UPDATE_EMPLOYMENT_TYPE_SUCCESS = 'update.employment.type.success';

    /**#@-*/

    /**
     * @var User\Entity\EmploymentType
     */
    protected $employmentTypeEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var \Exception
     */
    protected $exception;

    protected $updateData;

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
     * Get the value of employmentTypeEntity
     *
     * @return  User\Entity\EmploymentType
     */
    public function getEmploymentTypeEntity()
    {
        return $this->employmentTypeEntity;
    }

    /**
     * Set the value of employmentTypeEntity
     *
     * @param  User\Entity\EmploymentType  $employmentTypeEntity
     *
     * @return  self
     */
    public function setEmploymentTypeEntity(\User\Entity\EmploymentType $employmentTypeEntity)
    {
        $this->employmentTypeEntity = $employmentTypeEntity;

        return $this;
    }
}
