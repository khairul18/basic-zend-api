<?php

namespace Xtend\GoSms\Service;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Sms Trait
 */
trait SmsTrait
{
    /**
     * @var \Xtend\GoSms\Service\Sms
     */
    protected $smsService;

    /**
     * Get the value of smsService
     *
     * @return  \Xtend\GoSms\Service\Sms
     */
    public function getSmsService()
    {
        return $this->smsService;
    }

    /**
     * Set the value of smsService
     *
     * @param  Xtend\GoSms\Service\Sms  $smsService
     *
     * @return  self
     */
    public function setSmsService(\Xtend\GoSms\Service\Sms $smsService)
    {
        $this->smsService = $smsService;

        return $this;
    }
}
