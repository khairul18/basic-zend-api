<?php
namespace User\V1\Service;

use User\V1\ChangePasswordEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Aqilix\OAuth2\Mapper\OauthUsers as UserMapper;
use Gedmo\Exception\RuntimeException;

class ChangePassword
{
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\ChangePasswordEvent
     */
    protected $changePasswordEvent;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthUsers
     */
    protected $userMapper;

    public function __construct(
        UserMapper $userMapper
    ) {
        $this->setUserMapper($userMapper);
    }

    /**
     * @return the $userMapper
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }

    /**
     * @param \Aqilix\OAuth2\Mapper\OauthUsers $userMapper
     */
    public function setUserMapper(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    /**
     * Change Password User
     *
     * @param array $changeData
     */
    public function change($changeData, $userProfile)
    {
        $username = $userProfile->getUsername();
        $currentPasswordUserProfile = $this->getUserMapper()->fetchOneBy(['username' => $username])->getPassword();
        $validationPassword   = $this->getUserMapper()->verifyPassword($changeData['currentPassword'], $currentPasswordUserProfile);
        if ($validationPassword == false) {
            throw new \RuntimeException('Current Password Is Wrong !!!');
        }
        $event = $this->getChangePasswordEvent();
        $event->setName(ChangePasswordEvent::EVENT_CHANGE_PASSWORD);
        $event->setChangePasswordData($changeData);
        $changePassword = $this->getEventManager()->triggerEvent($event);
        if ($changePassword->stopped()) {
            $event->setException($changePassword->last());
            $event->setName(ChangePasswordEvent::EVENT_CHANGE_PASSWORD_ERROR);
            $changePassword = $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ChangePasswordEvent::EVENT_CHANGE_PASSWORD_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
        }
    }

    /**
     * Get ChangePasswordEvent
     *
     * @return the $changePasswordEvent
     */
    public function getChangePasswordEvent()
    {
        if ($this->changePasswordEvent == null) {
            $this->changePasswordEvent = new ChangePasswordEvent();
        }

        return $this->changePasswordEvent;
    }

    public function setChangePasswordEvent(ChangePasswordEvent $changePasswordEvent)
    {
        $this->changePasswordEvent = $changePasswordEvent;

        return $this;
    }
}
