<?php
namespace Notification\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;
use User\V1\UserActivatedEvent;
use Xtend\Email\Service\EmailTrait;
use Xtend\Email\Message;

class EmailNotificationEventListener extends AbstractListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    use EmailTrait;

    protected $config;

    public function __construct()
    {
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserActivatedEvent::EVENT_USER_ACTIVATED_SUCCESS,
            [$this, 'sendEmailNotificationWhenUserActivated'],
            493
        );

        $this->listeners[] = $events->attach(
            UserActivatedEvent::EVENT_USER_DEACTIVATED_SUCCESS,
            [$this, 'sendEmailNotificationWhenUserDeactivated'],
            493
        );
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config
     *
     * @param array $config
     * @return
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function sendEmailNotificationWhenUserDeactivated(UserActivatedEvent $event)
    {
        try {
            $changedBy = $event->getChangedBy();
            $userProfile = $event->getUserProfile();
            $userActivatedData = $event->getUserActivatedData();

            $emailAddress = $userProfile->getEmail();

            $message = new Message;
            $data = new \stdClass;
            $data->name = $userProfile->getFirstName();
            $message->setTitle($this->getConfig()['subject_deactivated']);
            $message->setTemplate($this->getConfig()['template_deactivated']);
            $message->setData($data);


            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {json}",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Send To " . $emailAddress,
                    "json" => $message->__toString()
                ]
            );


            $this->getEmailService()->send($emailAddress, $message);
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function sendEmailNotificationWhenUserActivated(UserActivatedEvent $event)
    {
        try {
            $changedBy = $event->getChangedBy();
            $userProfile = $event->getUserProfile();
            $userActivatedData = $event->getUserActivatedData();

            $emailAddress = $userProfile->getEmail();

            $message = new Message;
            $data = new \stdClass;
            $data->name = $userProfile->getFirstName();
            $message->setTitle($this->getConfig()['subject_activated']);
            $message->setTemplate($this->getConfig()['template_activated']);
            $message->setData($data);


            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {json}",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Send To " . $emailAddress,
                    "json" => $message->__toString()
                ]
            );


            $this->getEmailService()->send($emailAddress, $message);
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }
}
