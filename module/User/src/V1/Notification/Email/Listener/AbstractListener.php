<?php
/**
 * Abstract listener
 *
 * @link
 * @copyright Copyright (c) 2016
 */

namespace User\V1\Notification\Email\Listener;

use Aqilix\Notification\AbstractNotification;

class AbstractListener extends AbstractNotification
{
    protected $viewRenderer;

    protected $mailTransport;

    /**
     * @return the $viewRenderer
     */
    public function getViewRenderer()
    {
        return $this->viewRenderer;
    }

    /**
     * @param field_type $viewRenderer
     */
    public function setViewRenderer($viewRenderer)
    {
        $this->viewRenderer = $viewRenderer;
    }

    /**
     * @return the $mailTransport
     */
    public function getMailTransport()
    {
        return $this->mailTransport;
    }

    /**
     * @param field_type $mailTransport
     */
    public function setMailTransport($mailTransport)
    {
        $this->mailTransport = $mailTransport;
    }
}
