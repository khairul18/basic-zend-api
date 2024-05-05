<?php
namespace Xtend\Email\Console;

use ZF\Console\Route;
use Zend\Console\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareTrait;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Message as MailMessage;

class Notification
{
    use LoggerAwareTrait;

    protected $container;

    protected $logger;

    public function __invoke(Route $route, AdapterInterface $console, ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->setLogger($container->get("logger_default"));
        $mailTransport = $container->get('Aqilix\Service\Mail');
        $viewRenderer  = $container->get('ViewRenderer');
        $config = $container->get('Config');
        $to = $route->getMatchedParam('to', null);
        $message = $route->getMatchedParam('message', null);
        $mailNotificationConfig = $config['mail']['notification'];

        // trim data from cli
        $trimMessage = trim(stripslashes($message), '"');
        $message = json_decode($trimMessage, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {to} {message}",
                [
                    "to" => $to,
                    "function" => __CLASS__ . '\\' . __FUNCTION__,
                    "message"  => json_last_error_msg(),
                ]
            );
            return;
        }

        if (! isset($message['template'])) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {to} {message}",
                [
                    "to" => $to,
                    "function" => __CLASS__ . '\\' . __FUNCTION__,
                    "message"  => "Email template not set",
                ]
            );
            return;
        }

        $view = new ViewModel($message['data']);
        $view->setTemplate($message['template']);
        $html = $viewRenderer->render($view);
        $htmlMimePart = new MimePart($html);
        $htmlMimePart->setType('text/html');
        $mimeMessage  = new MimeMessage();
        $mimeMessage->addPart($htmlMimePart);

        if (! isset($message['title'])) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {to} {message}",
                [
                    "to" => $to,
                    "function" => __CLASS__ . '\\' . __FUNCTION__,
                    "message"  => 'Mail subject not set',
                ]
            );
            return;
        }

        $mailMessage = new Message();
        $mailMessage->addFrom(
            $mailNotificationConfig['sender']['from'],
            $mailNotificationConfig['sender']['name']
        )->setSubject($message['title']);
        $mailMessage->addTo($to);
        $mailMessage->setBody($mimeMessage);
        try {
            $mailTransport->send($mailMessage);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {to} {subject}",
                [
                    "function" => __CLASS__ . '\\' . __FUNCTION__,
                    "subject"  => $message['title'],
                    "to" => $to,
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message}",
                [
                    "function" => __CLASS__ . '\\' . __FUNCTION__,
                    "message" => $e->getMessage(),
                ]
            );
        }
    }

    /**
     * Get Container
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set Container
     *
     * @param ContainerInterface $container
     * @return \Ticket\V1\Console\Assigning\Worker
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
        return $this;
    }
}
