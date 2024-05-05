<?php

namespace Xtend\Firebase;

class Message
{
    /**
     * @var string
     **/
    public $to;

    /**
     * @var Message\Data
     **/
    public $data;

    /**
     * @var Message\Notification
     **/
    public $notification;

    /**
     * @var Messsage\Android
     **/
    public $android;

    /**
     * @param string $to
     * Set to
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Get to
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set data
     *
     * @param Message\Data $data
     */
    public function setData(Message\Data $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get data
     *
     * @return Message\Data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get notification
     *
     * @return Message\Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set notification
     *
     * @param Message\Notification $notification
     */
    public function setNotification(Message\Notification $notification)
    {
        $this->notification = $notification;
        return $this;
    }

    /**
     * Set to
     *
     * @param Messsage\Android $android
     */
    public function setAndroid(\stdClass $android)
    {
        $this->android = $android;
        return $this;
    }

    /**
     * Get android
     *
     * @return Messsage\Android
     */
    public function getAndroid()
    {
        return $this->android;
    }

    /**
     * Get string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}
