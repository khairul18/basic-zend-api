<?php

namespace User\V1;

use Zend\EventManager\Event;
use User\Entity\UserProfile;

class FacebookAuthEvent extends Event
{
    const EVENT_FACEBOOK_AUTH         = 'save.google.auth';
    const EVENT_FACEBOOK_AUTH_SUCCESS = 'save.google.auth.success';
    const EVENT_FACEBOOK_AUTH_ERROR   = 'save.google.auth.error';

    protected $userEmail;
    protected $userEntity;
    protected $googleAuthData;
    protected $exception;

    /**
     * @var array
     */
    protected $accessTokenResponse;

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
     * @return the $googleAuthData
     */
    public function getFacebookAuthData()
    {
        return $this->googleAuthData;
    }

    /**
     * @param Array $googleAuthData
     */
    public function setFacebookAuthData(array $googleAuthData)
    {
        $this->googleAuthData = $googleAuthData;
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

    /**
     * Get the value of accessTokenResponse
     *
     * @return  array
     */
    public function getAccessTokenResponse()
    {
        return $this->accessTokenResponse;
    }

    /**
     * Set the value of accessTokenResponse
     *
     * @param  array  $accessTokenResponse
     *
     * @return  self
     */
    public function setAccessTokenResponse(array $accessTokenResponse)
    {
        $this->accessTokenResponse = $accessTokenResponse;

        return $this;
    }

    /**
     * Get the value of userEmail
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set the value of userEmail
     *
     * @return  self
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }
}
