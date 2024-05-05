<?php
namespace QRCode\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use QRCode\V1\QRCodeEvent;
use User\Mapper\AccountTrait as AccountMapperTrait;
use QRCode\Mapper\QRCodeTrait as QRCodeMapperTrait;
use QRCode\Entity\QRCode as QRCodeEntity;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class QRCodeEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    use AccountMapperTrait;

    use QRCodeMapperTrait;

    /**
     *
     * @var DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    protected $qrCodeHydrator;

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
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            QRCodeEvent::EVENT_CREATE_QRCODE,
            [$this, 'createQRCode'],
            499
        );

        $this->listeners[] = $events->attach(
            QRCodeEvent::EVENT_CREATE_MASS_QRCODE,
            [$this, 'createMassQRCode'],
            499
        );
    }


    /**
     * Get config
     *
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function QRCodeGenerator($userProfile)
    {
        $qrCodeEntity = new QRCodeEntity;
        $qrCodeCollection = [];
        $stringQR  = bin2hex(random_bytes(10));

        $qrCodeCollection = [
            "value" => $stringQR,
            "isAvailable" => '1'
        ];

        $qrCodeData = $this->getQrCodeHydrator()->hydrate($qrCodeCollection, $qrCodeEntity);
        $this->getQRCodeMapper()->save($qrCodeData);

        $qrcode = new BaconQrCodeGenerator;
        $path   = $this->getConfig()['img_dir']. '/' . $qrCodeData->getuuid() . '.png';
        $newPath = str_replace('data/', '', $path);
        $qrCodeData->setPath($newPath);
        $qrcodeimg = $qrcode->format('png')->size(500)
                   ->merge('data/logo/MyXtendLogo.png')
                   ->errorCorrection('H')
                   ->generate($stringQR, $path);
        $this->getQRCodeMapper()->save($qrCodeData);
        return $qrCodeData;
    }

    public function createQRCode(QRCodeEvent $event)
    {
        $userProfile  = $event->getUserProfile()->getuuid();
        try {
            $qrcodeResult = $this->QRCodeGenerator($userProfile);
            $event->setQrCodeEntity($qrcodeResult);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => "QR Code Generated Successfully",
                    "userProfile"  => $userProfile,
                    ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage(),
                    "userProfile"  => $userProfile,
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function createMassQRCode(QRCodeEvent $event)
    {
        $userProfile  = $event->getUserProfile()->getuuid();
        $units = $event->getUnits();
        try {
            $qrCodeCollection = [];
            for ($i = 0; $i < $units; $i++) {
                $qrcodeResult = $this->QRCodeGenerator($userProfile);
                $qrCodeCollection[] = $qrcodeResult;
            }
            $event->setQrCodeCollection($qrCodeCollection);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => "QR Code Generated Successfully",
                    "userProfile"  => $userProfile,
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage(),
                    "userProfile"  => $userProfile,
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }


    /**
     * Get the value of qrCodeHydrator
     *
     * @return  DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    public function getQrCodeHydrator()
    {
        return $this->qrCodeHydrator;
    }

    /**
     * Set the value of qrCodeHydrator
     *
     * @param  DoctrineModule\Stdlib\Hydrator\DoctrineObject  $qrCodeHydrator
     *
     * @return  self
     */
    public function setQrCodeHydrator($qrCodeHydrator)
    {
        $this->qrCodeHydrator = $qrCodeHydrator;
        return $this;
    }
}
