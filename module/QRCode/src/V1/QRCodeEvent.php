<?php

namespace QRCode\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class QRCodeEvent extends Event
{
    const EVENT_CREATE_QRCODE           = 'create.qrcode';
    const EVENT_CREATE_QRCODE_SUCCESS   = 'create.qrcode.success';
    const EVENT_CREATE_QRCODE_ERROR     = 'create.qrcode.error';

    const EVENT_CREATE_MASS_QRCODE          = 'create.mass.qrcode';
    const EVENT_CREATE_MASS_QRCODE_SUCCESS  = 'create.mass.qrcode.success';
    const EVENT_CREATE_MASS_QRCODE_ERROR    = 'create.mass.qrcode.error';
    /**
     * @var QRCode\Entity\QRCode
     */

    protected $units;

    protected $qrCodeEntity;

    protected $qrCodeCollection;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var \Exception
     */
    protected $exception;

    protected $userProfile;

    /**
     * Get the value of qrCodeEntity
     *
     * @return  QRCode\Entity\QRCode
     */
    public function getQrCodeEntity()
    {
        return $this->qrCodeEntity;
    }

    /**
     * Set the value of qrCodeEntity
     *
     * @param  QRCode\Entity\QRCode  $qrCodeEntity
     *
     * @return  self
     */
    public function setQrCodeEntity(\QRCode\Entity\QRCode $qrCodeEntity)
    {
        $this->qrCodeEntity = $qrCodeEntity;

        return $this;
    }

    /**
     * Get the value of inputFilter
     *
     * @return  Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * Set the value of inputFilter
     *
     * @param  Zend\InputFilter\InputFilterInterface  $inputFilter
     *
     * @return  self
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;

        return $this;
    }

    /**
     * Get the value of exception
     *
     * @return  \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Set the value of exception
     *
     * @param  \Exception  $exception
     *
     * @return  self
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Get the value of userProfile
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set the value of userProfile
     *
     * @return  self
     */
    public function setUserProfile(\User\Entity\UserProfile $userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get the value of qrCodeCollection
     */
    public function getQrCodeCollection()
    {
        return $this->qrCodeCollection;
    }

    /**
     * Set the value of qrCodeCollection
     *
     * @return  self
     */
    public function setQrCodeCollection(array $qrCodeCollection)
    {
        $this->qrCodeCollection = $qrCodeCollection;

        return $this;
    }

    /**
     * Get the value of units
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Set the value of units
     *
     * @return  self
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }
}
