<?php
namespace QRCode\V1\Service\Listener;

use ZF\ApiProblem\ApiProblem;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\V1\UserProfileEvent;
use User\V1\ProfileEvent;
use QRCode\Entity\QRCodeOwner as QRCodeOwnerEntity;
use QRCode\Mapper\QRCodeOwner as QRCodeOwnerMapper;
use QRCode\Mapper\QRCodeOwnerTrait as QRCodeOwnerMapperTrait;
use QRCode\Mapper\QRCodeOwnerTypeTrait as QRCodeOwnerTypeMapperTrait;
use QRCode\Mapper\QRCodeTrait as QRCodeMapperTrait;

class QRCodeOwnerEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use LoggerAwareTrait;
    use QRCodeOwnerMapperTrait;
    use QRCodeOwnerTypeMapperTrait;
    use QRCodeMapperTrait;

    /**
     *
     * @var DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    protected $qrCodeOwnerHydrator;

    /**
     * @var array
     */
    protected $config;

    public function __construct(
        $qrCodeOwnerMapper,
        $qRCodeOwnerTypeMapper,
        $qrCodeMapper
    ) {
        $this->setQRCodeOwnerMapper($qrCodeOwnerMapper);
        $this->setQRCodeOwnerTypeMapper($qRCodeOwnerTypeMapper);
        $this->setQRCodeMapper($qrCodeMapper);
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {

        // $this->listeners[] = $events->attach(
        //     UserProfileEvent::EVENT_CREATE_TENANT,
        //     [$this, 'linkNewQRCode'],
        //     499
        // );

        $this->listeners[] = $events->attach(
            ProfileEvent::EVENT_RENEW_QR_CODE,
            [$this, 'renewQrCode'],
            500
        );

        // $this->listeners[] = $events->attach(
        //     ProfileEvent::EVENT_CREATE_PROFILE_SUCCESS,
        //     [$this, 'renewQrCode'],
        //     500
        // );
    }

    public function linkNewQRCode(ProfileEvent $event)
    {
        try {
            $qrCodeOwner  = [];
            $userProfile  = $event->getUserProfileEntity();
            $account      = $userProfile->getAccount();

            //Lookup table qr_code
            $qrCodeObj = $this->getQRCodeMapper()->fetchOneBy([
                // 'account' => $account,
                'isAvailable' => '1'
            ]);
            //Check if QR Code is empty
            if (is_null($qrCodeObj)) {
                $event->stopPropagation(true);
                return new \User\V1\Service\Exception\RuntimeException('There are no QR Code stock left');
            }

            // get qrcode owner type uuid
            // $qRCodeOwnerTypeObj = $this->getQRCodeOwnerTypeMapper()->getEntityRepository()->findOneBy(['type' => 'User']);
            //Check if QR Code is empty
            // if (is_null($qRCodeOwnerTypeObj)) {
            //     $event->stopPropagation(true);
            //     return new \User\V1\Service\Exception\RuntimeException('QRCodeOwnerType Not Found');
            // }

            $qrCodeOwner = [
                "qrCode" => $qrCodeObj->getUuid(),
                "userProfile" => $userProfile->getUuid(),
                // "qrCodeOwnerType" => $qRCodeOwnerTypeObj->getType()
            ];

            //Create QR Code Owner
            $qRCodeOwnerEntity = new \QRCode\Entity\QRCodeOwner;
            $qrCodeOwnerResult = $this->getQRCodeOwnerHydrator()->hydrate($qrCodeOwner, $qRCodeOwnerEntity);
            $this ->getQRCodeOwnerMapper()->save($qrCodeOwnerResult);
            $event->setQrCodeOwner($qrCodeOwnerResult);

            //Update isAvailable to 0
            $qrCodeUpdate = ["isAvailable" => 0];
            $qrCodeResult = $this->getQRCodeHydrator()->hydrate($qrCodeUpdate, $qrCodeObj);
            $this ->getQRCodeMapper()->save($qrCodeResult);
            $userProfile->setQrCode($qrCodeObj);
            $event->setUserProfileEntity($userProfile);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} userProfile:{userProfileUuid} qrCode:{qrCodeUuid}",
                [
                    "function" => __FUNCTION__,
                    "userProfileUuid"  => $qrCodeOwnerResult->getUserProfile()->getUuid(),
                    "qrCodeUuid"      => $qrCodeOwnerResult->getQRCode()->getUuid()
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message}",
                [
                    "message"  => $e->getMessage(),
                    "function" => __FUNCTION__,
                ]
            );
            return $e;
        }
    }

    public function renewQrCode(ProfileEvent $event)
    {
        $qrCodeOwner = $link = [];
        try {
            // $userProfileData   = $event->getRenewQrCodeData();
            $userProfile  = $event->getUserProfileEntity();
            $account      = $userProfile->getAccount();

            //Get QR Code Owner Object that need to renew
            $qRCodeOwnerEntity  = $userProfile->getQrCode();

            if (is_null($qRCodeOwnerEntity)) {
                // Create new qr_code_owner if qr_code missing or something
                // $event->setRenewState(true);
                $this->linkNewQRCode($event);
                $qRCodeOwnerEntity = $event->getQrCodeOwner();
            } else {
                //Lookup table qr_code
                $qrCodeObj = $this->getQRCodeMapper()->getEntityRepository()->findOneBy([
                    // 'account' => $account->getUuid(),
                    'isAvailable' => '1'
                ]);

                //Check if QR Code is empty
                if (is_null($qrCodeObj)) {
                    $event->stopPropagation(true);
                    return new \User\V1\Service\Exception\RuntimeException('There are no QR Code stock left');
                }

                //Set new qrcode
                $qrCodeOwner = ["qrCode" => $qrCodeObj];

                $qrCodeOwnerResult = $this->getQRCodeOwnerHydrator()->hydrate($qrCodeOwner, $qRCodeOwnerEntity);
                $this ->getQRCodeOwnerMapper()->save($qrCodeOwnerResult);

                //Update isAvailable to 0
                $qrCodeUpdate = ["isAvailable" => 0];
                $qrCodeResult = $this->getQRCodeHydrator()->hydrate($qrCodeUpdate, $qrCodeObj);
                $this->getQRCodeMapper()->save($qrCodeResult);
            }
            $qrCodeUuid = $qRCodeOwnerEntity->getQrCode()->getUuid();
            $url = $this->getConfig()[qr_code_url]. '/' .$qrCodeUuid. '.png';
            $link = ["qrCode" => $url];
            return $event->setQrCodeUrl($link);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} UserProfile {userProfileUuid} had renew QR Code with uuid {qrCodeUuid}",
                [
                    "function" => __FUNCTION__,
                    "userProfileUuid"  => $qrCodeOwnerResult->getUserProfile()->getUuid(),
                    "qrCodeUuid"      => $qrCodeOwnerResult->getQRCode()->getUuid()
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {data} {message}",
                [
                    "data" => json_encode($qrCodeResult),
                    "message"  => $e->getMessage(),
                    "function" => __FUNCTION__,
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    /**
     * Get the value of qrCodeOwnerHydrator
     *
     * @return  \DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    public function getQRCodeOwnerHydrator()
    {
        return $this->qrCodeOwnerHydrator;
    }

    /**
     * Set the value of qrCodeOwnerHydrator
     *
     * @param  \DoctrineModule\Stdlib\Hydrator\DoctrineObject  $qrCodeOwnerHydrator
     *
     * @return  self
     */
    public function setQRCodeOwnerHydrator($qrCodeOwnerHydrator)
    {
        $this->qrCodeOwnerHydrator = $qrCodeOwnerHydrator;

        return $this;
    }

    /**
     * Get the value of qrCodeHydrator
     *
     * @return  \DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    public function getQRCodeHydrator()
    {
        return $this->qrCodeHydrator;
    }

    /**
     * Set the value of qrCodeHydrator
     *
     * @param  \DoctrineModule\Stdlib\Hydrator\DoctrineObject  $qrCodeHydrator
     *
     * @return  self
     */
    public function setQRCodeHydrator($qrCodeHydrator)
    {
        $this->qrCodeHydrator = $qrCodeHydrator;

        return $this;
    }

    /**
     * Get the value of config
     *
     * @return  array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @param  array  $config
     *
     * @return  self
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }
}
