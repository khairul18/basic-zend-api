<?php
namespace Xtend\Apns\Console\Controller;

use \RuntimeException;
use Zend\Mvc\Console\Controller\AbstractConsoleController;
use Zend\Console\Request as ConsoleRequest;
use Psr\Log\LoggerAwareTrait;
use ZendService\Apple\Apns\Client\Message as Client;
use ZendService\Apple\Apns\Message;
use ZendService\Apple\Apns\Message\Alert;
use ZendService\Apple\Apns\Response\Message as Response;
use ZendService\Apple\Exception\RuntimeException as ApnsRuntimeException;

class NotificationController extends AbstractConsoleController
{
    use LoggerAwareTrait;

    /**
     * @var array
     */
    protected $configs;

    /**
     * @param array $configs
     */
    public function __construct(array $configs = [])
    {
        $this->setConfigs($configs);
    }

    /**
     * @return the $configs
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * @param field_type $configs
     */
    public function setConfigs(array $configs)
    {
        $this->configs = $configs;
    }


    public function sendNotificationAction()
    {
        $request = $this->getRequest();
        if (! $request instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this action from a console!');
        }

        $deviceToken = $request->getParam('deviceToken');
        $data = $request->getParam('payload');
        if (is_null($deviceToken) || is_null($data)) {
            return;
        }

        // trim data from cli
        $trimData = trim(stripslashes($data), '"');
        $payload  = json_decode($trimData);
        $client   = new Client();
        $message  = new Message();
        $client->open($this->getConfigs()['uri'], $this->getConfigs()['pem_file'], 'optionalPassPhrase');
        $message->setId(rand()); // need to change to $payload->notificationUuid
        $message->setToken($deviceToken);
//         $message->setBadge(10);
        $message->setSound($this->getConfigs()['sound']);
        $message->setCategory($payload->type);
        $message->setContentAvailable(1);
        $message->setCustom([
            'uuid' => $payload->uuid
        ]);

        $alert = new Alert();
        $alert->setTitle($payload->title);
        $alert->setBody($payload->body);
        $message->setAlert($alert);
        $response = null;
        try {
            $response = $client->send($message);
            $this->logResponse(__FUNCTION__, $response, $deviceToken, $data);
        } catch (ApnsRuntimeException $e) {
            $this->logResponse(__FUNCTION__, $response, $deviceToken, $data);
        }

        $client->close();
        return;
    }

    /**
     * Log Firebase Response
     *
     * @param string $name
     * @param array  $bodyResponse
     * @param string $firebaseId
     * @param array  $data
     */
    protected function logResponse($name, $bodyResponse, $deviceToken, $data)
    {
        if ($bodyResponse->getCode() === Response::RESULT_OK) {
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "apns {responseId} {deviceToken} {data}",
                [
                    "deviceToken"  => $deviceToken,
                    "responseId"   => $bodyResponse->getId(),
                    "data" => $data
                ]
            );
        }

        if ($bodyResponse === null) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERR,
                "apns {deviceToken} {data}",
                [
                    "deviceToken"  => $deviceToken,
                    "data" => $data
                ]
            );
        }
    }

    /**
     * Send
     *
     * @param  stdClass $bodyRequest
     * @throws \RuntimeException
     * @return null|string
     */
    protected function send($bodyRequest)
    {
    }
}
