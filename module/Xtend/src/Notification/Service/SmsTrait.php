<?php

namespace Xtend\Notification\Service;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Sms Trait
 */
trait SmsTrait
{
    /**
     * @var Xtend\Notification\Service\Sms
     */
    protected $smsService;

    /**
     * Get the value of smsService
     *
     * @return  \Xtend\Notification\Service\SmsInterface
     */
    public function getSmsService()
    {
        return $this->smsService;
    }

    /**
     * Set the value of smsService
     *
     * @param  Xtend\Notification\Service\SmsInterface  $smsService
     *
     * @return  self
     */
    public function setSmsService(\Xtend\Notification\Service\SmsInterface $smsService)
    {
        $this->smsService = $smsService;

        return $this;
    }
}
