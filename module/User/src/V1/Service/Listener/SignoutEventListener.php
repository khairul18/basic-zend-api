<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use User\V1\SignoutEvent;

class SignoutEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use UserProfileMapperTrait;

    use LoggerAwareTrait;

    /**
     * Constructor
     *
     * @param \User\Mapper\UserProfile $userProfileMapper
     * @param array $config
     */
    public function __construct(\User\Mapper\UserProfile $userProfileMapper)
    {
        $this->userProfileMapper  = $userProfileMapper;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            SignoutEvent::EVENT_SIGNOUT_USER,
            [$this, 'clearUserProfileAttribute'],
            497
        );
    }

    /**
     * Create User Profile
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function clearUserProfileAttribute(SignoutEvent $event)
    {
        try {
            $userProfile = $event->getUserProfileEntity();
            $userProfile->setFirebaseId(null);
            $userProfile->setIosDeviceToken(null);
            $userProfile->setAndroidDeviceId(null);
            $userProfile->setAndroidLastState(null);
            $this->getUserProfileMapper()->save($userProfile);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username}",
                ["function" => __FUNCTION__, "username" => $userProfile->getUsername()->getUsername()]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }
}
