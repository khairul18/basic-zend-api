<?php
namespace User\V1\Service;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use User\V1\UserActivatedEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Gedmo\Exception\RuntimeException;

class UserActivated
{
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\UserActivatedEvent
     */
    protected $userActivatedEvent;

    /**
     * User Activated User
     *
     * @param array $inputFilter
     */
    public function update($inputFilter, $userProfile, $changedBy)
    {
        $event = $this->getUserActivatedEvent();
        $event->setName(UserActivatedEvent::EVENT_USER_ACTIVATED);
        $event->setUserActivatedData($inputFilter);
        $event->setUserProfile($userProfile);
        $event->setChangedBy($changedBy);
        $userActivated = $this->getEventManager()->triggerEvent($event);
        if ($userActivated->stopped()) {
            $event->setException($userActivated->last());
            $event->setName(UserActivatedEvent::EVENT_USER_ACTIVATED_ERROR);
            $userActivated = $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(UserActivatedEvent::EVENT_USER_ACTIVATED_SUCCESS);

            $userActivatedData = $event->getUserActivatedData();
            $deativated = $userActivatedData['isActive'] == 0 ? true : false;

            if ($deativated) {
                $event->setName(UserActivatedEvent::EVENT_USER_DEACTIVATED_SUCCESS);
                $message = new \Xtend\Notification\Message;
                $userActivated     = $event->getUserActivatedEntity();
                $notificationId    = $event->getNotificationId();
                $body = $userActivatedData['note'];
                $message->setType('UserDisabled');
                $message->setUuid($userActivated->getUuid());
                $message->setBody($body);
                $message->setNotificationUuid($notificationId);
                $event->setNotificationMessage($message);
            }

            $this->getEventManager()->triggerEvent($event);
        }
    }

    /**
     * Get UserActivatedEvent
     *
     * @return the $userActivatedEvent
     */
    public function getUserActivatedEvent()
    {
        if ($this->userActivatedEvent == null) {
            $this->userActivatedEvent = new UserActivatedEvent();
        }

        return $this->userActivatedEvent;
    }

    public function setUserActivatedEvent(UserActivatedEvent $userActivatedEvent)
    {
        $this->userActivatedEvent = $userActivatedEvent;

        return $this;
    }
}
