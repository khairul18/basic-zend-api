<?php
namespace User\V1\Service;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\UserDocumentEvent;
use User\Entity\UserDocument as UserDocumentEntity;

class UserDocument
{
    use EventManagerAwareTrait;

    protected $userDocumentEvent;

    protected $config;

    public function save(ZendInputFilter $inputFilter)
    {
        $userDocumentEvent = new UserDocumentEvent();
        $userDocumentEvent->setInputFilter($inputFilter);
        $userDocumentEvent->setName(UserDocumentEvent::EVENT_CREATE_USER_DOCUMENT);
        $create = $this->getEventManager()->triggerEvent($userDocumentEvent);
        if ($create->stopped()) {
            $userDocumentEvent->setName(UserDocumentEvent::EVENT_CREATE_USER_DOCUMENT_ERROR);
            $userDocumentEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userDocumentEvent);
            throw $userDocumentEvent->getException();
        } else {
            $userDocumentEvent->setName(UserDocumentEvent::EVENT_CREATE_USER_DOCUMENT_SUCCESS);
            $this->getEventManager()->triggerEvent($userDocumentEvent);
            return $userDocumentEvent->getUserDocumentEntity();
        }
    }

    public function update(UserDocumentEntity $userDocumentEntity, ZendInputFilter $newData)
    {
        $userDocumentEvent = new UserDocumentEvent();
        $userDocumentEvent->setInputFilter($newData);
        $userDocumentEvent->setUserDocumentEntity($userDocumentEntity);
        $userDocumentEvent->setName(UserDocumentEvent::EVENT_UPDATE_USER_DOCUMENT);
        $create = $this->getEventManager()->triggerEvent($userDocumentEvent);
        if ($create->stopped()) {
            $userDocumentEvent->setName(UserDocumentEvent::EVENT_UPDATE_USER_DOCUMENT_ERROR);
            $userDocumentEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($userDocumentEvent);
            throw $userDocumentEvent->getException();
        } else {
            $userDocumentEvent->setName(UserDocumentEvent::EVENT_UPDATE_USER_DOCUMENT_SUCCESS);
            $this->getEventManager()->triggerEvent($userDocumentEvent);
            return $userDocumentEvent->getUserDocumentEntity();
        }
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

    /**
     * Get the value of userDocumentEvent
     */
    public function getUserDocumentEvent()
    {
        if ($this->userDocumentEvent == null) {
            $this->userDocumentEvent = new UserDocumentEvent();
        }

        return $this->userDocumentEvent;
    }

    /**
     * Set the value of userDocumentEvent
     *
     * @return  self
     */
    public function setUserDocumentEvent($userDocumentEvent)
    {
        $this->userDocumentEvent = $userDocumentEvent;

        return $this;
    }
}
