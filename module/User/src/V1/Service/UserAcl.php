<?php
namespace User\V1\Service;

use User\Entity\UserAcl as UserAclEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\UserAclEvent;

class UserAcl
{
    use EventManagerAwareTrait;

    protected $userAclEvent;

    protected $config;

    public function action($optionFields = [])
    {
        $userAclEvent = new UserAclEvent();
        $userAclEvent->setOptionFields($optionFields);
        $userAclEvent->setName(UserAclEvent::EVENT_ACTION_USER_ACL);
        $create = $this->getEventManager()->triggerEvent($userAclEvent);
        if ($create->stopped()) {
            $userAclEvent->setName(UserAclEvent::EVENT_ACTION_USER_ACL_ERROR);
            $userAclEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userAclEvent);
            throw $userAclEvent->getException();
        } else {
            $userAclEvent->setName(UserAclEvent::EVENT_ACTION_USER_ACL_SUCCESS);
            $this->getEventManager()->triggerEvent($userAclEvent);
            return $userAclEvent->getUserAclEntity();
        }
    }

    public function getUserAclEvent()
    {
        if ($this->userAclEvent == null) {
            $this->userAclEvent = new UserAclEvent();
        }

        return $this->userAclEvent;
    }

    public function setUserAclEvent(UserAclEvent $userAclEvent)
    {
        $this->userAclEvent = $userAclEvent;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     *
     * @return self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }
}
