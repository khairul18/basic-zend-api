<?php

namespace User\V1;

use Zend\EventManager\Event;
use User\Entity\UserProfile as UserProfileEntity;

class UserActivatedEvent extends Event
{
    /**#@+
     * Signup events triggered by eventmanager
     */
    const EVENT_USER_ACTIVATED = 'user.activated';
    const EVENT_USER_ACTIVATED_SUCCESS = 'user.activated.success';
    const EVENT_USER_DEACTIVATED_SUCCESS = 'user.deactivated.success';
    const EVENT_USER_ACTIVATED_ERROR   = 'user.activated.error';
    /**#@-*/

    /**
     * @var string
     */
    protected $notificationId;

    /**
     * @var \Xtend\Notification\Message
     */
    protected $notificationMessage;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @var User\Entity\UserProfile
     */
    protected $userActivatedEntity;

    /**
     * @var User\Entity\UserProfile
     */
    protected $userProfile;

    /**
     * @var User\Entity\UserProfile
     */
    protected $changedBy;

    /**
     * @var array
     */
    protected $userActivatedData;

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
     * Get the value of UserActivated
     *
     * @return  array
     */
    public function getUserActivatedData()
    {
        return $this->userActivatedData;
    }

    /**
     * Set the value of userActivatedData
     *
     * @param  array  $userActivatedData
     *
     * @return  self
     */
    public function setUserActivatedData(array $userActivatedData)
    {
        $this->userActivatedData = $userActivatedData;

        return $this;
    }

    /**
     * @return the User\Entity\UserProfile
     */
    public function getUserActivatedEntity()
    {
        return $this->userActivatedEntity;
    }

    /**
     * @param User\Entity\UserProfile $userProfileEntity
     */
    public function setUserActivatedEntity(UserProfileEntity $userActivatedEntity)
    {
        $this->userActivatedEntity = $userActivatedEntity;
    }

    /**
     * Get the value of notificationId
     *
     * @return  string
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }

    /**
     * Set the value of notificationId
     *
     * @param  string  $notificationId
     *
     * @return  self
     */
    public function setNotificationId($notificationId)
    {
        $this->notificationId = $notificationId;

        return $this;
    }

    /**
     * Get the value of notificationMessage
     *
     * @return  \Xtend\Notification\Message
     */
    public function getNotificationMessage()
    {
        return $this->notificationMessage;
    }

    /**
     * Set the value of notificationMessage
     *
     * @param  \Xtend\Notification\Message  $notificationMessage
     *
     * @return  self
     */
    public function setNotificationMessage(\Xtend\Notification\Message $notificationMessage)
    {
        $this->notificationMessage = $notificationMessage;

        return $this;
    }

    /**
     * Get the value of userProfile
     *
     * @return  User\Entity\UserProfile
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set the value of userProfile
     *
     * @param  User\Entity\UserProfile  $userProfile
     *
     * @return  self
     */
    public function setUserProfile(UserProfileEntity $userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get the value of changedBy
     *
     * @return  User\Entity\UserProfile
     */
    public function getChangedBy()
    {
        return $this->changedBy;
    }

    /**
     * Set the value of changedBy
     *
     * @param  User\Entity\UserProfile  $changedBy
     *
     * @return  self
     */
    public function setChangedBy(UserProfileEntity $changedBy)
    {
        $this->changedBy = $changedBy;

        return $this;
    }
}
