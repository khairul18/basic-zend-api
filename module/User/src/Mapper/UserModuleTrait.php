<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserModule Trait
 */
trait UserModuleTrait
{
    /**
     * @var \User\Mapper\UserModule
     */
    protected $userModuleMapper;


    /**
     * Get the value of userModuleMapper
     *
     * @return  \User\Mapper\UserModule
     */
    public function getUserModuleMapper()
    {
        return $this->userModuleMapper;
    }

    /**
     * Set the value of userModuleMapper
     *
     * @param  \User\Mapper\UserModule  $userModuleMapper
     *
     * @return  self
     */
    public function setUserModuleMapper(\User\Mapper\UserModule $userModuleMapper)
    {
        $this->userModuleMapper = $userModuleMapper;

        return $this;
    }
}
