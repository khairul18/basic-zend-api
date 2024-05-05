<?php
namespace Notification\V1\Rest\NotificationLog;

class NotificationLogResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $notificationLogMapper   = $services->get(\Notification\Mapper\NotificationLog::class);
        return new NotificationLogResource(
            $userProfileMapper,
            $notificationLogMapper
        );
    }
}
