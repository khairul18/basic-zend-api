<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserAccess Trait
 */
trait UserAccessTrait
{
    /**
     * @var \User\Mapper\UserAccess
     */
    protected $userAccessMapper;

    /**
     * Get the value of userAccessMapper
     *
     * @return  \User\Mapper\UserAccess
     */ 
    public function getUserAccessMapper()
    {
        return $this->userAccessMapper;
    }

    /**
     * Set the value of userAccessMapper
     *
     * @param  \User\Mapper\UserAccess  $userAccessMapper
     *
     * @return  self
     */ 
    public function setUserAccessMapper(\User\Mapper\UserAccess $userAccessMapper)
    {
        $this->userAccessMapper = $userAccessMapper;

        return $this;
    }
}
