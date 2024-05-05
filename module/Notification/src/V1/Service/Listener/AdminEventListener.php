<?php
namespace Notification\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;
use Xtend\Firebase\Service\FirebaseTrait;
use Notification\Mapper\Notification as NotificationMapper;
use Notification\Mapper\NotificationTrait as NotificationMapperTrait;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileTraitMapper;

class AdminEventListener extends AbstractListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use LoggerAwareTrait;
    use FirebaseTrait;
    use NotificationMapperTrait;
    use UserProfileTraitMapper;

    protected $config;
    protected $notificationHydrator;

    public function __construct(
        $userProfileMapper,
        $notificationMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setNotificationMapper($notificationMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {

        // $this->listeners[] = $events->attach(
        //     PanicAlertEvent::EVENT_CREATE_PANIC_ALERT_SUCCESS,
        //     [$this, 'insertPanicAlertToNotificationBoardForAdmin'],
        //     499
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
     * Get the value of notificationHydrator
     */
    public function getNotificationHydrator()
    {
        return $this->notificationHydrator;
    }

    /**
     * Set the value of notificationHydrator
     *
     * @return  self
     */
    public function setNotificationHydrator($notificationHydrator)
    {
        $this->notificationHydrator = $notificationHydrator;

        return $this;
    }
}
