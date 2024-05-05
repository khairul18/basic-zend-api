<?php

namespace Xtend\Notification\Adapter;

interface AdapterInterface
{
    public function send($targetId, \Xtend\Notification\MessageInterface $data);
}
