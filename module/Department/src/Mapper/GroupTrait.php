<?php

namespace Department\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Group Trait
 */
trait GroupTrait
{
    /**
     * @var \Department\Mapper\Group
     */
    protected $groupMapper;


    /**
     * Get the value of groupMapper
     *
     * @return  \Department\Mapper\Group
     */ 
    public function getGroupMapper()
    {
        return $this->groupMapper;
    }

    /**
     * Set the value of groupMapper
     *
     * @param  \Department\Mapper\Group  $groupMapper
     *
     * @return  self
     */ 
    public function setGroupMapper(\Department\Mapper\Group $groupMapper)
    {
        $this->groupMapper = $groupMapper;

        return $this;
    }
}
