<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use User\Mapper\UserProfileTrait;
use User\V1\SignoutEvent;
use Psr\Log\LoggerAwareTrait;

class Signout
{
    use EventManagerAwareTrait;

    use UserProfileTrait;

    use LoggerAwareTrait;

    /**
     * @var \User\V1\SignoutEvent
     */
    protected $signoutEvent;

    public function __construct(\User\Mapper\UserProfile $userProfileMapper)
    {
        $this->setUserProfileMapper($userProfileMapper);
    }

    /**
     * @return $signoutEvent
     */
    public function getSignoutEvent()
    {
        if ($this->signoutEvent == null) {
            $this->signoutEvent = new SignoutEvent();
        }

        return $this->signoutEvent;
    }

    /**
     * @param SignoutEvent $signoutEvent
     */
    public function setSignoutEvent(SignoutEvent $signoutEvent)
    {
        $this->signoutEvent = $signoutEvent;
    }

    /**
     * Register new user
     *
     * @param  string $userEntity
     * @throw  \RuntimeException
     * @return void
     */
    public function signout($username)
    {
        $userProfile = $this->getUserProfileMapper()->fetchOneBy(['username' => $username]);

        if ($userProfile === null) {
            throw new \RuntimeException('User not found');
        }

        $signoutEvent = $this->getSignoutEvent();
        $signoutEvent->setUserProfileEntity($userProfile);
        $signoutEvent->setName(SignoutEvent::EVENT_SIGNOUT_USER);
        $insert = $this->getEventManager()->triggerEvent($signoutEvent);
        if ($insert->stopped()) {
            $signoutEvent->setException($insert->last());
            $signoutEvent->setName(SignoutEvent::EVENT_SIGNOUT_USER_ERROR);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username} Failed",
                ["function" => __FUNCTION__, "username" => $userProfile->getUsername()->getUsername()]
            );
            $insert = $this->getEventManager()->triggerEvent($signoutEvent);
            throw $this->getSignoutEvent()->getException();
        } else {
            $signoutEvent->setName(SignoutEvent::EVENT_SIGNOUT_USER_SUCCESS);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username} OK",
                ["function" => __FUNCTION__, "username" => $userProfile->getUsername()->getUsername()]
            );
            $this->getEventManager()->triggerEvent($signoutEvent);
        }
    }

    public function signedOutUser($userProfile)
    {
        $signedoutEvent = $this->getSignoutEvent();
        $signedoutEvent->setUserProfileEntity($userProfile);
        $signedoutEvent->setName(SignoutEvent::EVENT_SIGNEDOUT_USER);
        $insert = $this->getEventManager()->triggerEvent($signedoutEvent);
        if ($insert->stopped()) {
            $signedoutEvent->setException($insert->last());
            $signedoutEvent->setName(SignoutEvent::EVENT_SIGNEDOUT_USER_ERROR);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username} Failed",
                ["function" => __FUNCTION__, "username" => $userProfile->getUsername()->getUsername()]
            );
            $insert = $this->getEventManager()->triggerEvent($signedoutEvent);
            throw $this->getSignoutEvent()->getException();
        } else {
            $signedoutEvent->setName(SignoutEvent::EVENT_SIGNEDOUT_USER_SUCCESS);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username} OK",
                ["function" => __FUNCTION__, "username" => $userProfile->getUsername()->getUsername()]
            );
            $this->getEventManager()->triggerEvent($signedoutEvent);
        }
    }
}
