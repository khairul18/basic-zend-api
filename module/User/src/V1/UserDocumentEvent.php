<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class UserDocumentEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_USER_DOCUMENT         = 'create.user.document';
    const EVENT_CREATE_USER_DOCUMENT_ERROR   = 'create.user.document.error';
    const EVENT_CREATE_USER_DOCUMENT_SUCCESS = 'create.user.document.success';

    const EVENT_UPDATE_USER_DOCUMENT         = 'update.user.document';
    const EVENT_UPDATE_USER_DOCUMENT_ERROR   = 'update.user.document.error';
    const EVENT_UPDATE_USER_DOCUMENT_SUCCESS = 'update.user.document.success';

    /**#@-*/

    /**
     * @var User\Entity\UserDocument
     */
    protected $userDocumentEntity;

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
     * Get the value of userDocumentEntity
     *
     * @return  User\Entity\UserDocument
     */
    public function getUserDocumentEntity()
    {
        return $this->userDocumentEntity;
    }

    /**
     * Set the value of userDocumentEntity
     *
     * @param  User\Entity\UserDocument  $userDocumentEntity
     *
     * @return  self
     */
    public function setUserDocumentEntity(\User\Entity\UserDocument $userDocumentEntity)
    {
        $this->userDocumentEntity = $userDocumentEntity;

        return $this;
    }
}
