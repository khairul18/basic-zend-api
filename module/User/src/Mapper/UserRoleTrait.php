<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserRole Trait
 */
trait UserRoleTrait
{
    /**
     * @var \User\Mapper\UserRole
     */
    protected $userRoleMapper;


    /**
     * Get the value of userRoleMapper
     *
     * @return  \User\Mapper\UserRole
     */ 
    public function getUserRoleMapper()
    {
        return $this->userRoleMapper;
    }

    /**
     * Set the value of userRoleMapper
     *
     * @param  \User\Mapper\UserRole  $userRoleMapper
     *
     * @return  self
     */ 
    public function setUserRoleMapper(\User\Mapper\UserRole $userRoleMapper)
    {
        $this->userRoleMapper = $userRoleMapper;

        return $this;
    }
}
