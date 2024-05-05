<?php
namespace Xtend\GoSms;

use Xtend\Notification\MessageInterface;

class Message implements MessageInterface
{
    public $data;

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get json string
     */
    public function __toString()
    {
        return json_encode($this->data);
    }
}
