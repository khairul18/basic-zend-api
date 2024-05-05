<?php
namespace User\V1\Service;

use User\V1\MobileStateEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\Entity\UserProfile as UserProfileEntity;
use User\Mapper\UserProfile as UserProfileMapper;

class MobileState
{
    use EventManagerAwareTrait;

    /**
     * @var \User\V1\MobileStateEvent
     */
    protected $mobileStateEvent;

    public function __construct()
    {
    }

    /**
     * @return $mobileStateEvent
     */
    public function getMobileStateEvent()
    {
        if ($this->mobileStateEvent == null) {
            $this->mobileStateEvent = new MobileStateEvent();
        }

        return $this->mobileStateEvent;
    }

    /**
     * @param MobileStateEvent $mobileStateEvent
     */
    public function setMobileStateEvent(MobileStateEvent $mobileStateEvent)
    {
        $this->mobileStateEvent = $mobileStateEvent;
    }

    public function saveMobileState(UserProfileEntity $user, ZendInputFilter $inputFilter)
    {
        $dataState        = $inputFilter->getValues();
        $mobileStateEvent = $this->getMobileStateEvent();
        foreach ($dataState as $key => $state) {
            if (is_null($dataState[$key])) {
                unset($dataState[$key]);
            }
        }

        if (isset($dataState['androidLastParam'])) {
            $dataState['androidLastParam'] = json_encode($dataState['androidLastParam'], true);
        }

        $mobileStateEvent->setUserEntity($user);
        $mobileStateEvent->setMobileStateData($dataState);
        $mobileStateEvent->setName(MobileStateEvent::EVENT_SAVE_MOBILE_STATE);
        $update = $this->getEventManager()->triggerEvent($mobileStateEvent);
        if ($update->stopped()) {
            $mobileStateEvent->setException($update->last());
            $mobileStateEvent->setName(MobileStateEvent::EVENT_SAVE_MOBILE_STATE_ERROR);
            $update = $this->getEventManager()->triggerEvent($mobileStateEvent);
            throw $this->getMobileStateEvent()->getException();
        } else {
            $mobileStateEvent->setName(MobileStateEvent::EVENT_SAVE_MOBILE_STATE_SUCCESS);
            $this->getEventManager()->triggerEvent($mobileStateEvent);
            return true;
        }
    }
}
