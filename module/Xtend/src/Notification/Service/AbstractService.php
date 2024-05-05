<?php

namespace Xtend\Notification\Service;

abstract class AbstractService
{
    /**
     * Sender adapter
     *
     * @var \Xtend\Notification\Adapter\AdapterInterface
     */
    private $adapter = null;

    /**
     * Send Notification
     *
     * @param string $targetId
     * @param \Xtend\Notification\Message $message
     */
    public function send($targetId, \Xtend\Notification\MessageInterface $message)
    {
        if ($this->getAdapter() === null) {
            throw new \RuntimeException('Adapter not set');
        }

        $this->getAdapter()->send($targetId, $message);
    }

    /**
     * Get Sender Adapter
     *
     * @return \Xtend\Notification\Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set Adapter
     *
     * @param  \Xtend\Notification\Adapter\AdapterInterface $adapter
     * @return
     */
    public function setAdapter(\Xtend\Notification\Adapter\AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }
}
