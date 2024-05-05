<?php
namespace Notification\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;
use Xtend\Firebase\Service\FirebaseTrait;
use Notification\Mapper\NotificationLog as NotificationLogMapper;
use Notification\Mapper\NotificationLogTrait as NotificationLogMapperTrait;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileTraitMapper;

class NotificationLogEventListener extends AbstractListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    use FirebaseTrait;

    use NotificationLogMapperTrait;

    use UserProfileTraitMapper;

    protected $config;
    protected $notificationLogHydrator;

    public function __construct(
        $userProfileMapper,
        $notificationLogMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setNotificationLogMapper($notificationLogMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        // $this->listeners[] = $events->attach(
        //     PanicAlertEvent::EVENT_CREATE_PANIC_ALERT_SUCCESS,
        //     [$this, 'insertNotificationPanicAlertToNotificationLog'],
        //     493
        // );
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

    /**
     * Get the value of notificationLogHydrator
     */
    public function getNotificationLogHydrator()
    {
        return $this->notificationLogHydrator;
    }

    /**
     * Set the value of notificationLogHydrator
     *
     * @return  self
     */
    public function setNotificationLogHydrator($notificationLogHydrator)
    {
        $this->notificationLogHydrator = $notificationLogHydrator;

        return $this;
    }
}
