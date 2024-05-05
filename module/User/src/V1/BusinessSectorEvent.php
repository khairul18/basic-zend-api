<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class BusinessSectorEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_BUSINESS_SECTOR         = 'create.business.sector';
    const EVENT_CREATE_BUSINESS_SECTOR_ERROR   = 'create.business.sector.error';
    const EVENT_CREATE_BUSINESS_SECTOR_SUCCESS = 'create.business.sector.success';

    const EVENT_UPDATE_BUSINESS_SECTOR         = 'update.business.sector';
    const EVENT_UPDATE_BUSINESS_SECTOR_ERROR   = 'update.business.sector.error';
    const EVENT_UPDATE_BUSINESS_SECTOR_SUCCESS = 'update.business.sector.success';

    /**#@-*/

    /**
     * @var User\Entity\BusinessSector
     */
    protected $businessSectorEntity;

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
     * Get the value of businessSectorEntity
     *
     * @return  User\Entity\BusinessSector
     */
    public function getBusinessSectorEntity()
    {
        return $this->businessSectorEntity;
    }

    /**
     * Set the value of businessSectorEntity
     *
     * @param  User\Entity\BusinessSector  $businessSectorEntity
     *
     * @return  self
     */
    public function setBusinessSectorEntity(\User\Entity\BusinessSector $businessSectorEntity)
    {
        $this->businessSectorEntity = $businessSectorEntity;

        return $this;
    }
}
