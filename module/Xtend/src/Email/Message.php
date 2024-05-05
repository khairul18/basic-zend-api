<?php
namespace Xtend\Email;

use Xtend\Notification\MessageInterface;

class Message implements MessageInterface
{
    public $title;

    public $template;

    public $data;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

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
        return json_encode($this);
    }
}
