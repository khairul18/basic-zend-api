<?php

namespace Xtend\Email\Service;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Email Trait
 */
trait EmailTrait
{
    /**
     * @var Xtend\Email\Service\Email
     */
    protected $emailService;

    /**
     * Get Email Service
     *
     * @var Xtend\Email\Service\Email
     */
    public function getEmailService()
    {
        return $this->emailService;
    }

    /**
     * Set Email Service
     *
     * @var Xtend\Email\Service\Email $emailService
     */
    public function setEmailService($emailService)
    {
        $this->emailService = $emailService;
        return $this;
    }
}
