<?php

namespace Xtend\Firebase\Message;

class Android
{
    /**
     * @var string
     **/
    public $ttl;

    public function getTtl()
    {
        return $this->ttl;
    }

    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
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
