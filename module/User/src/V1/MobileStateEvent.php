<?php

namespace User\V1;

use Zend\EventManager\Event;
use User\Entity\UserProfile;

class MobileStateEvent extends Event
{


    const EVENT_SAVE_MOBILE_STATE         = 'save.mobile.state';
    const EVENT_SAVE_MOBILE_STATE_SUCCESS = 'save.mobile.state.success';
    const EVENT_SAVE_MOBILE_STATE_ERROR   = 'save.mobile.state.error';

    protected $userEntity;
    protected $mobileStateData;
    protected $exception;

    /**
     * @return the $user
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * @param Aqilix\ORM\Entity\EntityInterface $user
     */
    public function setUserEntity(UserProfile $user)
    {
        $this->userEntity = $user;
    }

    /**
     * @return the $mobileStateData
     */
    public function getMobileStateData()
    {
        return $this->mobileStateData;
    }

    /**
     * @param Array $mobileStateData
     */
    public function setMobileStateData(array $mobileStateData)
    {
        $this->mobileStateData = $mobileStateData;
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
