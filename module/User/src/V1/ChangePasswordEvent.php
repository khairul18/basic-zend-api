<?php

namespace User\V1;

use Zend\EventManager\Event;
use Aqilix\OAuth2\Entity\OauthUsers as User;

class ChangePasswordEvent extends Event
{
    /**#@+
     * Signup events triggered by eventmanager
     */
    const EVENT_CHANGE_PASSWORD = 'change.password';
    const EVENT_CHANGE_PASSWORD_SUCCESS = 'change.password.success';
    const EVENT_CHANGE_PASSWORD_ERROR   = 'change.password.error';
    /**#@-*/

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUsers
     */
    protected $userEntity;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @var array
     */
    protected $changePasswordData;


    /**
     * @return \Aqilix\OAuth2\Entity\OauthUsers
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * @param \Aqilix\OAuth2\Entity\OauthUsers $userEntity
     */
    public function setUserEntity(User $userEntity)
    {
        $this->userEntity = $userEntity;
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
     * Get the value of ChangePassword
     *
     * @return  array
     */
    public function getChangePasswordData()
    {
        return $this->changePasswordData;
    }

    /**
     * Set the value of ChangePassword
     *
     * @param  array  $changePassword
     *
     * @return  self
     */
    public function setChangePasswordData(array $changePasswordData)
    {
        $this->changePasswordData = $changePasswordData;

        return $this;
    }
}
