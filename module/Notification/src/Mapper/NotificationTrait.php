<?php

namespace Notification\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Notification Trait
 */
trait NotificationTrait
{
    /**
     * @var Notification\Mapper\Notification
     */
    protected $notificationMapper;

    /**
     * Get NotificationMapper
     *
     * @return \Notification\Mapper\Notification
     */
    public function getNotificationMapper()
    {
        return $this->notificationMapper;
    }

    /**
     * Set NotificationMapper
     *
     * @param  \Notification\Mapper\Notification $notificationMapper
     */
    public function setNotificationMapper(\Notification\Mapper\Notification $notificationMapper)
    {
        $this->notificationMapper = $notificationMapper;
    }
}
