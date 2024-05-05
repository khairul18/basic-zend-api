<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class PositionEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_POSITION         = 'create.position';
    const EVENT_CREATE_POSITION_ERROR   = 'create.position.error';
    const EVENT_CREATE_POSITION_SUCCESS = 'create.position.success';

    const EVENT_UPDATE_POSITION         = 'update.position';
    const EVENT_UPDATE_POSITION_ERROR   = 'update.position.error';
    const EVENT_UPDATE_POSITION_SUCCESS = 'update.position.success';

    /**#@-*/

    /**
     * @var User\Entity\Position
     */
    protected $positionEntity;

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
     * Get the value of positionEntity
     *
     * @return  User\Entity\Position
     */
    public function getPositionEntity()
    {
        return $this->positionEntity;
    }

    /**
     * Set the value of positionEntity
     *
     * @param  User\Entity\Position  $positionEntity
     *
     * @return  self
     */
    public function setPositionEntity(\User\Entity\Position $positionEntity)
    {
        $this->positionEntity = $positionEntity;

        return $this;
    }
}
