<?php
namespace User\V1\Service;

use User\V1\GoogleAuthEvent;
use Zend\EventManager\EventManagerAwareTrait;
use User\Mapper\UserGoogleAuth as UserGoogleAuthMapper;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class GoogleAuth
{
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\GoogleAuthEvent
     */
    protected $googleAuthEvent;

    public function __construct()
    {
    }

    /**
     * @return \User\V1\GoogleAuthEvent
     */
    public function getGoogleAuthEvent()
    {
        if ($this->googleAuthEvent == null) {
            $this->googleAuthEvent = new GoogleAuthEvent();
        }

        return $this->googleAuthEvent;
    }

    /**
     * @param GoogleAuthEvent $signupEvent
     */
    public function setGoogleAuthEvent(GoogleAuthEvent $googleAuthEvent)
    {
        $this->googleAuthEvent = $googleAuthEvent;
    }

    public function auth($userEmail)
    {
        $userEvent = $this->getGoogleAuthEvent();
        $userEvent->setUserEmail($userEmail);
        $userEvent->setName(GoogleAuthEvent::EVENT_GOOGLE_AUTH);
        $create = $this->getEventManager()->triggerEvent($userEvent);
        if ($create->stopped()) {
            $userEvent->setName(GoogleAuthEvent::EVENT_GOOGLE_AUTH_ERROR);
            $userEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userEvent);
            throw $userEvent->getException();
        } else {
            $userEvent->setName(GoogleAuthEvent::EVENT_GOOGLE_AUTH_SUCCESS);
            $this->getEventManager()->triggerEvent($userEvent);
            return $userEvent->getAccessTokenResponse();
        }
    }
}
