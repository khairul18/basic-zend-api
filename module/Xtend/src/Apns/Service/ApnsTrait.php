<?php

namespace Xtend\Apns\Service;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Apns Trait
 */
trait ApnsTrait
{
    /**
     * @var Xtend\Apns\Service\apns
     */
    protected $apnsService;

    /**
     * Get apns Service
     *
     * @var Xtend\apns\Service\apns
     */
    public function getApnsService()
    {
        return $this->apnsService;
    }

    /**
     * Set apns Service
     *
     * @var Xtend\apns\Service\apns $apnsService
     */
    public function setApnsService($apnsService)
    {
        $this->apnsService = $apnsService;
        return $this;
    }
}
