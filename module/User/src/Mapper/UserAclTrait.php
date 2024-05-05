<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserAcl Trait
 */
trait UserAclTrait
{
    /**
     * @var \User\Mapper\UserAcl
     */
    protected $userAclMapper;

    /**
     * Get the value of userAclMapper
     *
     * @return  \User\Mapper\UserAcl
     */
    public function getUserAclMapper()
    {
        return $this->userAclMapper;
    }

    /**
     * Set the value of userAclMapper
     *
     * @param  \User\Mapper\UserAcl  $userAclMapper
     *
     * @return  self
     */
    public function setUserAclMapper(\User\Mapper\UserAcl $userAclMapper)
    {
        $this->userAclMapper = $userAclMapper;

        return $this;
    }
}
