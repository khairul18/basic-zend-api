<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class EducationEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_EDUCATION         = 'create.education';
    const EVENT_CREATE_EDUCATION_ERROR   = 'create.education.error';
    const EVENT_CREATE_EDUCATION_SUCCESS = 'create.education.success';

    const EVENT_UPDATE_EDUCATION         = 'update.education';
    const EVENT_UPDATE_EDUCATION_ERROR   = 'update.education.error';
    const EVENT_UPDATE_EDUCATION_SUCCESS = 'update.education.success';

    /**#@-*/

    /**
     * @var User\Entity\Education
     */
    protected $educationEntity;

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
     * Get the value of educationEntity
     *
     * @return  User\Entity\Education
     */
    public function getEducationEntity()
    {
        return $this->educationEntity;
    }

    /**
     * Set the value of educationEntity
     *
     * @param  User\Entity\Education  $educationEntity
     *
     * @return  self
     */
    public function setEducationEntity(\User\Entity\Education $educationEntity)
    {
        $this->educationEntity = $educationEntity;

        return $this;
    }
}
