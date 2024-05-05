<?php

namespace Notification\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Notification Trait
 */
trait NotificationLogTrait
{
    /**
     * @var Notification\Mapper\Notification
     */
    protected $notificationLogMapper;

    /**
     * Get NotificationLogMapper
     *
     * @return \Notification\Mapper\NotificationLog
     */
    public function getNotificationLogMapper()
    {
        return $this->notificationLogMapper;
    }

    /**
     * Set NotificationLogMapper
     *
     * @param  \Notification\Mapper\NotificationLog $notificationLogMapper
     */
    public function setNotificationLogMapper(\Notification\Mapper\NotificationLog $notificationLogMapper)
    {
        $this->notificationLogMapper = $notificationLogMapper;
    }
}
