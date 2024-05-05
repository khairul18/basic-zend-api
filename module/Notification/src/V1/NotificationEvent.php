<?php

namespace Notification\V1;

use Zend\EventManager\Event;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class NotificationEvent extends Event
{
    const EVENT_UPDATE_NOTIFICATION           = 'update.notification';
    const EVENT_UPDATE_NOTIFICATION_SUCCESS   = 'update.notification.success';
    const EVENT_UPDATE_NOTIFICATION_ERROR     = 'update.notification.error';

    /**#@-*/

    /**
     * @var Notification\Entity\Notification
     */
    protected $notificationEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    protected $updateData;

    /**
     * @var \Exception
     */
    protected $exception;


    /**
     * Get the value of inputFilter
     *
     * @return  Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * Set the value of inputFilter
     *
     * @param  Zend\InputFilter\InputFilterInterface  $inputFilter
     *
     * @return  self
     */
    public function setInputFilter(Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;

        return $this;
    }

    /**
     * Get the value of updateData
     */
    public function getUpdateData()
    {
        return $this->updateData;
    }

    /**
     * Set the value of updateData
     *
     * @return  self
     */
    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;

        return $this;
    }

    /**
     * Get the value of exception
     *
     * @return  \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Set the value of exception
     *
     * @param  \Exception  $exception
     *
     * @return  self
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Get the value of notificationEntity
     *
     * @return  Notification\Entity\Notification
     */
    public function getNotificationEntity()
    {
        return $this->notificationEntity;
    }

    /**
     * Set the value of notificationEntity
     *
     * @param  Notification\Entity\Notification  $notificationEntity
     *
     * @return  self
     */
    public function setNotificationEntity($notificationEntity)
    {
        $this->notificationEntity = $notificationEntity;

        return $this;
    }
}
