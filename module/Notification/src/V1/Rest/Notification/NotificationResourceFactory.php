<?php
namespace Notification\V1\Rest\Notification;

class NotificationResourceFactory
{
    public function __invoke($services)
    {
        $notificationMapper  = $services->get(\Notification\Mapper\Notification::class);
        $notificationService = $services->get(\Notification\V1\Service\Notification::class);
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $notificationResource = new NotificationResource($notificationMapper, $userProfileMapper);
        $notificationResource->setNotificationService($notificationService);
        return $notificationResource;
    }
}
