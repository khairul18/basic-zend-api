<?php

namespace Xtend\Firebase\Adapter;

interface AdapterInterface
{
    public function send($firebaseId, \Xtend\Notification\MessageInterface $message);
}
