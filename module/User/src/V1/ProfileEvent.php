<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class ProfileEvent extends Event
{
    /**#@+
     * Profile events triggered by eventmanager
     */

    const EVENT_RENEW_QR_CODE  = 'create.renew.qrcode';
    const EVENT_RENEW_QR_CODE_ERROR   = 'create.renew.qrcode.error';
    const EVENT_RENEW_QR_CODE_SUCCESS = 'create.renew.qrcode.success';

    const EVENT_CREATE_PROFILE  = 'create.profile';
    const EVENT_CREATE_PROFILE_ERROR   = 'create.profile.error';
    const EVENT_CREATE_PROFILE_SUCCESS = 'create.profile.success';

    const EVENT_UPDATE_PROFILE  = 'update.profile';
    const EVENT_UPDATE_PROFILE_ERROR   = 'update.profile.error';
    const EVENT_UPDATE_PROFILE_SUCCESS = 'update.profile.success';

    const EVENT_DELETE_PROFILE  = 'delete.profile';
    const EVENT_DELETE_PROFILE_ERROR   = 'delete.profile.error';
    const EVENT_DELETE_PROFILE_SUCCESS = 'delete.profile.success';
    /**#@-*/

    /**
     * @var string
     */
    protected $qrCodeUrl;

    /**
     * @var Array
     */
    protected $optionFields;

    /**
     * @var string
     */
    protected $qrCodeOwner;

    /**
     * @var User\Entity\UserProfile
     */
    protected $userProfileEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var array
     */
    protected $updateData;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @var array
     */
    protected $deleteProfile;

    /**
     * @return the $user
     */
    public function getUserProfileEntity()
    {
        return $this->userProfileEntity;
    }

    /**
     * @param Aqilix\ORM\Entity\EntityInterface $userProfile
     */
    public function setUserProfileEntity(EntityInterface $userProfile)
    {
        $this->userProfileEntity = $userProfile;
    }

    /**
     * @return the $updateData
     */
    public function getUpdateData()
    {
        return $this->updateData;
    }

    /**
     * @param object $updateData
     */
    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;
    }

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

    /**
     * Get the value of deleteProfile
     *
     * @return  array
     */
    public function getDeleteProfile()
    {
        return $this->deleteProfile;
    }

    /**
     * Set the value of deleteProfile
     *
     * @param  array  $deleteProfile
     *
     * @return  self
     */
    public function setDeleteProfile(array $deleteProfile)
    {
        $this->deleteProfile = $deleteProfile;

        return $this;
    }

    /**
     * Get the value of qrCodeUrl
     *
     * @return
     */
    public function getQrCodeUrl()
    {
        return $this->qrCodeUrl;
    }

    /**
     * Set the value of qrCodeUrl
     *
     * @param   $qrCodeUrl
     *
     * @return  self
     */
    public function setQrCodeUrl($qrCodeUrl)
    {
        $this->qrCodeUrl = $qrCodeUrl;

        return $this;
    }

    /**
     * Get the value of qrCodeOwner
     *
     * @return
     */
    public function getQrCodeOwner()
    {
        return $this->qrCodeOwner;
    }

    /**
     * Set the value of qrCodeOwner
     *
     * @param   $qrCodeOwner
     *
     * @return  self
     */
    public function setQrCodeOwner($qrCodeOwner)
    {
        $this->qrCodeOwner = $qrCodeOwner;

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
    public function setOptionFields(array $optionFields)
    {
        $this->optionFields = $optionFields;

        return $this;
    }
}
