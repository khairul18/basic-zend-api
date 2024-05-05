<?php
namespace User\Service\Listener;

use ZF\MvcAuth\MvcAuthEvent;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\UserProfile as UserProfileMapper;

class AuthenticationTimezoneListener
{
    use LoggerAwareTrait;

    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * Check activated
     *
     * @param  MvcAuthEvent
     */
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $username    = $mvcAuthEvent->getIdentity()->getAuthenticationIdentity();
        $userProfile = $this->getUserProfileMapper()->fetchOneBy(['username' => $username]);
        if (! is_string($username)) {
            return;
        }

        if (is_null($userProfile)) {
            return;
        }
        if (date_default_timezone_set($userProfile->getTimezone())) {
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{class} {uuid} set timezone {timezone}",
                [
                    "class" => __CLASS__,
                    "uuid"  => $userProfile->getUuid(),
                    "timezone" => $userProfile->getTimezone()
                ]
            );
        } else {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{class} {uuid} set timezone {timezone}",
                [
                    "class" => __CLASS__,
                    "uuid"  => $userProfile->getUuid(),
                    "timezone" => $userProfile->getTimezone()
                ]
            );
        }

        return;
    }

    /**
     * @return \User\Mapper\UserProfile
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * Set UserProfile Mapper
     *
     * @param UserProfileMapper $userProfileMapper
     */
    public function setUserProfileMapper(UserProfileMapper $userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }
}
