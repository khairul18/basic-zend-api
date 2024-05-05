<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserProfile Trait
 */
trait UserProfileTrait
{
    /**
     * @var User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * Set UserProfile Mapper
     *
     * @param \User\Mapper\UserProfile $userProfileMapper
     */
    public function setUserProfileMapper($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * Get UserProfile Mapper
     *
     * @return \User\Mapper\UserProfile
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }
}
