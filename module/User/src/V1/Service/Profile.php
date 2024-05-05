<?php

namespace User\V1\Service;

use User\V1\ProfileEvent;
use Zend\EventManager\EventManagerAwareTrait;
use User\Mapper\UserProfile as UserProfileMapper;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\Entity\UserProfile as UserProfileEntity;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class Profile
{
    use EventManagerAwareTrait;
    protected $config;

    /**
     * @var \User\V1\ProfileEvent
     */
    protected $profileEvent;

    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    public function __construct(
        UserProfileMapper $userProfileMapper
    ) {

        $this->setUserProfileMapper($userProfileMapper);
    }

    /**
     * @return \User\V1\ProfileEvent
     */
    public function getProfileEvent()
    {
        if ($this->profileEvent == null) {
            $this->profileEvent = new ProfileEvent();
        }

        return $this->profileEvent;
    }

    /**
     * @param ProfileEvent $signupEvent
     */
    public function setProfileEvent(ProfileEvent $profileEvent)
    {
        $this->profileEvent = $profileEvent;
    }

    /**
     * @return the $userProfileMapper
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * @param UserProfileMapper $userProfileMapper
     */
    public function setUserProfileMapper(UserProfileMapper $userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    public function renewQrCode($userProfile)
    {
        $tenantEvent = $this->getProfileEvent();
        $tenantEvent->setUserProfileEntity($userProfile);
        $tenantEvent->setName(ProfileEvent::EVENT_RENEW_QR_CODE);
        $create = $this->getEventManager()->triggerEvent($tenantEvent);
        if ($create->stopped()) {
            $tenantEvent->setName(ProfileEvent::EVENT_RENEW_QR_CODE_ERROR);
            $tenantEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($tenantEvent);
            throw $tenantEvent->getException();
        } else {
            $tenantEvent->setName(ProfileEvent::EVENT_RENEW_QR_CODE_SUCCESS);
            $this->getEventManager()->triggerEvent($tenantEvent);
            return $tenantEvent->getQrCodeUrl();
        }
    }

    public function create($userProfile, ZendInputFilter $userData, $optionFields = [])
    {
        $userEvent = $this->getProfileEvent();
        $userEvent->setInputFilter($userData);
        $userEvent->setOptionFields($optionFields);
        $userEvent->setName(ProfileEvent::EVENT_CREATE_PROFILE);
        $create = $this->getEventManager()->triggerEvent($userEvent);
        if ($create->stopped()) {
            $userEvent->setName(ProfileEvent::EVENT_CREATE_PROFILE_ERROR);
            $userEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userEvent);
            throw $userEvent->getException();
        } else {
            $userEvent->setName(ProfileEvent::EVENT_CREATE_PROFILE_SUCCESS);
            $this->getEventManager()->triggerEvent($userEvent);
            return $userEvent->getUserProfileEntity();
        }
    }

    /**
     * Update User Profile
     *
     * @param \User\Entity\UserProfile  $userProfile
     * @param array                     $updateData
     */
    public function update($userProfile, ZendInputFilter $inputFilter, $optionFields = [])
    {
        $profileEvent = $this->getProfileEvent();
        $profileEvent->setUserProfileEntity($userProfile);
        $profileEvent->setUpdateData($inputFilter->getValues());
        $profileEvent->setInputFilter($inputFilter);

        // $profileEvent->setOptionFields($optionFields);
        $profileEvent->setName(ProfileEvent::EVENT_UPDATE_PROFILE);
        $update = $this->getEventManager()->triggerEvent($profileEvent);
        if ($update->stopped()) {
            $profileEvent->setName(ProfileEvent::EVENT_UPDATE_PROFILE_ERROR);
            $profileEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($profileEvent);
            throw $profileEvent->getException();
        } else {
            $profileEvent->setName(ProfileEvent::EVENT_UPDATE_PROFILE_SUCCESS);
            $this->getEventManager()->triggerEvent($profileEvent);
        }
    }

    public function deleteProfile($userProfile, $id)
    {
        $profileData = [
            "userProfile" => $userProfile,
            "uuid" => $id
        ];

        $profileEvent = $this->getProfileEvent();
        $profileEvent->setDeleteProfile($profileData);
        $profileEvent->setName(ProfileEvent::EVENT_DELETE_PROFILE);
        $delete = $this->getEventManager()->triggerEvent($profileEvent);
        if ($delete->stopped()) {
            $profileEvent->setName(ProfileEvent::EVENT_DELETE_PROFILE_ERROR);
            $profileEvent->setException($delete->last());
            $this->getEventManager()->triggerEvent($profileEvent);
            throw $profileEvent->getException();
        } else {
            $profileEvent->setName(ProfileEvent::EVENT_DELETE_PROFILE_SUCCESS);
            $this->getEventManager()->triggerEvent($profileEvent);
            return true;
        }
    }

    /**
     * Get the value of config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @return  self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }
}
