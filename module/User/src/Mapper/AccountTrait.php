<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Account Trait
 */
trait AccountTrait
{
    /**
     * @var \User\Mapper\Account
     */
    protected $accountMapper;

    /**
     * Get Account Mapper
     *
     * @return \User\Mapper\Account
     */
    public function getAccountMapper()
    {
        return $this->accountMapper;
    }

    /**
     * Set AccountMapper
     *
     * @param User\Mapper\Account $accountMapper
     */
    public function setAccountMapper(\User\Mapper\Account $accountMapper)
    {
        $this->accountMapper = $accountMapper;
    }
}
