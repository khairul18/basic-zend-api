<?php
namespace QRCode\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use QRCode\V1\QRCodeEvent;
use User\Mapper\AccountTrait as AccountMapperTrait;
use QRCode\Mapper\QRCodeTrait as QRCodeMapperTrait;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class QRCode
{
    use EventManagerAwareTrait;

    use LoggerAwareTrait;

    use AccountMapperTrait;

    use QRCodeMapperTrait;

    protected $qrCodeEvent;

    /**
     * Constructor
     *
     * @param QRcode\Mapper\QRCode   $trackingMapper
     */
    public function __construct(
        \QRCode\Mapper\QRCode $qrCodeMapper = null,
        \User\Mapper\Account $accountMapper = null
    ) {
        $this->setQRCodeMapper($qrCodeMapper);
        $this->setAccountMapper($accountMapper);
    }


    /**
     * Get the value of qrCodeEvent
     */
    public function getQrCodeEvent()
    {
        if ($this->qrCodeEvent == null) {
            $this->qrCodeEvent = new QRCodeEvent();
        }
        return $this->qrCodeEvent;
    }

    /**
     * Set the value of qrCodeEvent
     *
     * @return  selfinsert bulk gps log
     */
    public function setQrCodeEvent($qrCodeEvent)
    {
        $this->qrCodeEvent = $qrCodeEvent;

        return $this;
    }

    public function createQRCode($account)
    {
        $qrCodeEvent = $this->getQrCodeEvent();
        $qrCodeEvent->setUserProfile($account);
        $qrCodeEvent->setName(QRCodeEvent::EVENT_CREATE_QRCODE);
        $create = $this->getEventManager()->triggerEvent($qrCodeEvent);
        if ($create->stopped()) {
            $qrCodeEvent->setName(QRCodeEvent::EVENT_CREATE_QRCODE_ERROR);
            $qrCodeEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($qrCodeEvent);
            throw $qrCodeEvent->getException();
        } else {
            $qrCodeEvent->setName(QRCodeEvent::EVENT_CREATE_QRCODE_SUCCESS);
            $this->getEventManager()->triggerEvent($qrCodeEvent);
            return $qrCodeEvent->getQrCodeEntity();
        }
    }


    public function createMassQRCode($account, $units)
    {
        $qrCodeEvent = $this->getQrCodeEvent();
        $qrCodeEvent->setUserProfile($account);
        $qrCodeEvent->setUnits($units);
        $qrCodeEvent->setName(QRCodeEvent::EVENT_CREATE_MASS_QRCODE);
        $create = $this->getEventManager()->triggerEvent($qrCodeEvent);
        if ($create->stopped()) {
            $qrCodeEvent->setName(QRCodeEvent::EVENT_CREATE_MASS_QRCODE_ERROR);
            $qrCodeEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($qrCodeEvent);
            throw $qrCodeEvent->getException();
        } else {
            $qrCodeEvent->setName(QRCodeEvent::EVENT_CREATE_MASS_QRCODE_SUCCESS);
            $this->getEventManager()->triggerEvent($qrCodeEvent);
            return $qrCodeEvent->getQrCodeCollection();
        }
    }
}
