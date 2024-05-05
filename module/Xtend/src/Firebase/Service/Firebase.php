<?php

namespace Xtend\Firebase\Service;

class Firebase
{
    /**
     * Sender adapter
     *
     * @var \Xtend\Firebase\Adapter\AdapterInterface
     */
    private $adapter = null;

    /**
     * Send Firebase Push Notification
     *
     * @param string $firebaseId
     * @param \Xtend\Notification\Message $message
     */
    public function send($firebaseId, \Xtend\Notification\Message $message)
    {
        if ($this->getAdapter() === null) {
            throw new \RuntimeException('Firebase adapter not set');
        }

        $this->getAdapter()->send($firebaseId, $message);
    }

    /**
     * Get Sender Adapter
     *
     * @return \Xtend\Firebase\Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set Adapter
     *
     * @param  \Xtend\Firebase\Adapter\AdapterInterface $adapter
     * @return \Xtend\Firebase\Service\Firebase
     */
    public function setAdapter(\Xtend\Firebase\Adapter\AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }
}
