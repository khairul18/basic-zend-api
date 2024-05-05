<?php

namespace Xtend\Firebase\Message;

class Data
{
    /**
     * @var string
     **/
    public $title;

    /**
     * @var string
     **/
    public $body;

    /**
     * @var string
     **/
    public $type;

    /**
     * @var string
     **/
    public $uuid;

    /**
     * @var string
     **/
    public $notificationUuid;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getNotificationUuid()
    {
        return $this->notificationUuid;
    }

    public function setNotificationUuid($notificationUuid)
    {
        $this->notificationUuid = $notificationUuid;

        return $this;
    }

    /**
     * Get json string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}
