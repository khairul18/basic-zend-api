<?php

namespace Department\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Group User Trait
 */
trait GroupUserTrait
{
    /**
     * @var \Department\Mapper\GroupUser
     */
    protected $groupUserMapper;


    /**
     * Get the value of groupUserMapper
     *
     * @return  \Department\Mapper\GroupUser
     */ 
    public function getGroupUserMapper()
    {
        return $this->groupUserMapper;
    }

    /**
     * Set the value of groupUserMapper
     *
     * @param  \Department\Mapper\GroupUser  $groupUserMapper
     *
     * @return  self
     */ 
    public function setGroupUserMapper(\Department\Mapper\GroupUser $groupUserMapper)
    {
        $this->groupUserMapper = $groupUserMapper;

        return $this;
    }
}
