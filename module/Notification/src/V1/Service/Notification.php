<?php
namespace Notification\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Psr\Log\LoggerAwareTrait;
use Notification\V1\NotificationEvent;
use User\Mapper\AccountTrait as AccountMapperTrait;
use Notification\Mapper\NotificationTrait as NotificationMapperTrait;
use SimpleSoftwareIO\Notification\BaconNotificationGenerator;

class Notification
{
    use EventManagerAwareTrait;

    use LoggerAwareTrait;

    use AccountMapperTrait;

    use NotificationMapperTrait;

    protected $notificationEvent;

    /**
     * Constructor
     *
     * @param Notification\Mapper\Notification
     */
    public function __construct(
        \Notification\Mapper\Notification $notificationMapper = null,
        \User\Mapper\Account $accountMapper = null
    ) {
        $this->setNotificationMapper($notificationMapper);
        $this->setAccountMapper($accountMapper);
    }


    /**
     * Get the value of notificationEvent
     */
    public function getNotificationEvent()
    {
        if ($this->notificationEvent == null) {
            $this->notificationEvent = new NotificationEvent();
        }
        return $this->notificationEvent;
    }

    /**
     * Set the value of notificationEvent
     *
     * @return  selfinsert
     */
    public function setNotificationEvent($notificationEvent)
    {
        $this->notificationEvent = $notificationEvent;

        return $this;
    }

    public function update($data, $oldData)
    {
        $data = $data->getValues();
        $notificationEvent = $this->getNotificationEvent();
        $notificationEvent->setUpdateData($data);
        $notificationEvent->setNotificationEntity($oldData);
        $notificationEvent->setName(NotificationEvent::EVENT_UPDATE_NOTIFICATION);
        $create = $this->getEventManager()->triggerEvent($notificationEvent);
        if ($create->stopped()) {
            $notificationEvent->setName(NotificationEvent::EVENT_UPDATE_NOTIFICATION_ERROR);
            $notificationEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($notificationEvent);
            throw $notificationEvent->getException();
        } else {
            $notificationEvent->setName(NotificationEvent::EVENT_UPDATE_NOTIFICATION_SUCCESS);
            $this->getEventManager()->triggerEvent($notificationEvent);
            return $notificationEvent->getNotificationEntity();
        }
    }
}
