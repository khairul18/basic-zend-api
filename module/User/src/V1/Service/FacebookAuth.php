<?php
namespace User\V1\Service;

use User\V1\FacebookAuthEvent;
use Zend\EventManager\EventManagerAwareTrait;
use User\Mapper\UserFacebookAuth as UserFacebookAuthMapper;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class FacebookAuth
{
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\FacebookAuthEvent
     */
    protected $facebookAuthEvent;

    public function __construct()
    {
    }

    /**
     * @return \User\V1\FacebookAuthEvent
     */
    public function getFacebookAuthEvent()
    {
        if ($this->facebookAuthEvent == null) {
            $this->facebookAuthEvent = new FacebookAuthEvent();
        }

        return $this->facebookAuthEvent;
    }

    /**
     * @param FacebookAuthEvent $signupEvent
     */
    public function setFacebookAuthEvent(FacebookAuthEvent $facebookAuthEvent)
    {
        $this->facebookAuthEvent = $facebookAuthEvent;
    }

    public function auth($userEmail)
    {
        $userEvent = $this->getFacebookAuthEvent();
        $userEvent->setUserEmail($userEmail);
        $userEvent->setName(FacebookAuthEvent::EVENT_FACEBOOK_AUTH);
        $create = $this->getEventManager()->triggerEvent($userEvent);
        if ($create->stopped()) {
            $userEvent->setName(FacebookAuthEvent::EVENT_FACEBOOK_AUTH_ERROR);
            $userEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userEvent);
            throw $userEvent->getException();
        } else {
            $userEvent->setName(FacebookAuthEvent::EVENT_FACEBOOK_AUTH_SUCCESS);
            $this->getEventManager()->triggerEvent($userEvent);
            return $userEvent->getAccessTokenResponse();
        }
    }
}
