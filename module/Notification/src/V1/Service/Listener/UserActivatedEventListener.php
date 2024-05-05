<?php
namespace Notification\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;
use User\V1\UserActivatedEvent;
use Xtend\Firebase\Service\FirebaseTrait;
use Xtend\Apns\Service\ApnsTrait;
use Notification\Mapper\Notification as NotificationMapper;
use Notification\Mapper\NotificationTrait as NotificationMapperTrait;

class UserActivatedEventListener extends AbstractListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    use FirebaseTrait;

    use ApnsTrait;

    use NotificationMapperTrait;

    protected $config;
    protected $userActivatedHydrator;

    public function __construct(
        $notificationMapper
    ) {
        $this->setNotificationMapper($notificationMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserActivatedEvent::EVENT_USER_ACTIVATED_SUCCESS,
            [$this, 'createdStatusLog'],
            496
        );

        $this->listeners[] = $events->attach(
            UserActivatedEvent::EVENT_USER_DEACTIVATED_SUCCESS,
            [$this, 'createdStatusLog'],
            496
        );

        $this->listeners[] = $events->attach(
            UserActivatedEvent::EVENT_USER_DEACTIVATED_SUCCESS,
            [$this, 'sendFirebaseNotification'],
            495
        );

        $this->listeners[] = $events->attach(
            UserActivatedEvent::EVENT_USER_DEACTIVATED_SUCCESS,
            [$this, 'sendApnsNotification'],
            495
        );
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config
     *
     * @param array $config
     * @return
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function createdStatusLog(UserActivatedEvent $event)
    {
        try {
            $changedBy = $event->getChangedBy();
            $userProfile = $event->getUserProfile();
            $userActivatedData = $event->getUserActivatedData();

            $requestedUser = $event->getUserActivatedEntity();
            if (! $requestedUser instanceof \User\Entity\UserProfile) {
                return;
            }

            $userActivatedCollection = [
                "userProfile" => $userProfile,
                "changedBy" => $changedBy,
                "note" => $userActivatedData['note'],
                "isActive" => $requestedUser->getIsActive()
            ];

            $userActivatedEntity = new \User\Entity\UserActivatedLog;
            $userActivated = $this->getUserActivatedHydrator()->hydrate($userActivatedCollection, $userActivatedEntity);
            $result = $this->getNotificationMapper()->save($userActivated);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid} {data}",
                [
                    "uuid" => $result->getUuid(),
                    "data" => json_encode($userActivatedCollection),
                    "function" => __FUNCTION__,
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    /**
     * Run Console to Send Firebase Notification
     *
     * @param  EventInterface $event
     * @return int
     */
    public function sendFirebaseNotification(UserActivatedEvent $event)
    {
        // look up firebase id
        $requestedUser = $event->getUserActivatedEntity();
        if (! $requestedUser instanceof \User\Entity\UserProfile) {
            return;
        }

        $firebaseId = $requestedUser->getFirebaseId();
        $notificationMessage = $event->getNotificationMessage();
        // add title to notification
        $notificationMessage->setTitle($this->getConfig()['user_disabled_title']);
        $this->getFirebaseService()->send($firebaseId, $notificationMessage);
    }

    /**
     * Run Console to Send Apns Notification
     *
     * @param  EventInterface $event
     * @return int
     */
    public function sendApnsNotification(UserActivatedEvent $event)
    {
        // look up firebase id
        $requestedUser = $event->getUserActivatedEntity();
        if (! $requestedUser instanceof \User\Entity\UserProfile) {
            return;
        }

        $iosDeviceToken = $requestedUser->getIosDeviceToken();
        if (is_null($iosDeviceToken)) {
            $this->logger->log(
                \Psr\Log\LogLevel::WARNING,
                "{function} {uuid} {message}",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification not send caused by there is no tenant iOS Device Token",
                    "uuid" => $requestedUser->getUuid()
                ]
            );
            return;
        }

        $iosDeviceToken = $requestedUser->getIosDeviceToken();
        $notificationMessage = $event->getNotificationMessage();
        // add title to notification
        $notificationMessage->setTitle($this->getConfig()['user_disabled_title']);
        $this->getApnsService()->send($iosDeviceToken, $notificationMessage);
    }

    /**
     * Get the value of userActivatedHydrator
     */
    public function getUserActivatedHydrator()
    {
        return $this->userActivatedHydrator;
    }

    /**
     * Set the value of userActivatedHydrator
     *
     * @return  self
     */
    public function setUserActivatedHydrator($userActivatedHydrator)
    {
        $this->userActivatedHydrator = $userActivatedHydrator;

        return $this;
    }
}
