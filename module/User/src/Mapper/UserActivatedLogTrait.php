<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserProfile Trait
 */
trait UserActivatedLogTrait
{
    /**
     * @var User\Mapper\UserActivatedLog
     */
    protected $userActivatedLogMapper;

    /**
     * Get the value of userActivatedLogMapper
     *
     * @return  User\Mapper\UserActivatedLog
     */
    public function getUserActivatedLogMapper()
    {
        return $this->userActivatedLogMapper;
    }

    /**
     * Set the value of userActivatedLogMapper
     *
     * @param  User\Mapper\UserActivatedLog  $userActivatedLogMapper
     *
     * @return  self
     */
    public function setUserActivatedLogMapper(\User\Mapper\UserActivatedLog $userActivatedLogMapper)
    {
        $this->userActivatedLogMapper = $userActivatedLogMapper;

        return $this;
    }
}
