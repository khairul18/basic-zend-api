<?php

namespace User\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class UserAclEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_ACTION_USER_ACL         = 'action.user.acl';
    const EVENT_ACTION_USER_ACL_ERROR   = 'action.user.acl.error';
    const EVENT_ACTION_USER_ACL_SUCCESS = 'action.user.acl.success';
    /**#@-*/

    /**
     * @var User\Entity\UserAcl
     */
    protected $userAclEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var Array
     */
    protected $optionFields;

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
     * Get the value of userAclEntity
     *
     * @return  User\Entity\UserAcl
     */
    public function getUserAclEntity()
    {
        return $this->userAclEntity;
    }

    /**
     * Set the value of userAclEntity
     *
     * @param  User\Entity\UserAcl  $userAclEntity
     *
     * @return  self
     */
    public function setUserAclEntity(\User\Entity\UserAcl $userAclEntity)
    {
        $this->userAclEntity = $userAclEntity;

        return $this;
    }

    /**
     * Get the value of optionFields
     *
     * @return  Array
     */ 
    public function getOptionFields()
    {
        return $this->optionFields;
    }

    /**
     * Set the value of optionFields
     *
     * @param  Array  $optionFields
     *
     * @return  self
     */ 
    public function setOptionFields(Array $optionFields)
    {
        $this->optionFields = $optionFields;

        return $this;
    }
}
