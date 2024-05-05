<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\ORM\Entity\EntityInterface;

class SignoutEvent extends Event
{
    /**#@+
     * Signout events triggered by eventmanager
     */
    const EVENT_SIGNOUT_USER = 'signout.user';
    const EVENT_SIGNOUT_USER_SUCCESS = 'signout.user.success';
    const EVENT_SIGNOUT_USER_ERROR   = 'signout.user.error';
    const EVENT_SIGNEDOUT_USER = 'signedout.user';
    const EVENT_SIGNEDOUT_USER_SUCCESS = 'signedout.user.success';
    const EVENT_SIGNEDOUT_USER_ERROR   = 'signedout.user.error';
    /**#@-*/

    /**
     * @var \User\Entity\UserProfile
     */
    protected $userProfileEntity;

    /**
     * @var \Exception
     */
    protected $exception;

    public function getUserProfileEntity()
    {
        return $this->userProfileEntity;
    }

    public function setUserProfileEntity(\User\Entity\UserProfile $userProfileEntity)
    {
        $this->userProfileEntity = $userProfileEntity;
        return $this;
    }

    /**
     * @return the $exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }
}
