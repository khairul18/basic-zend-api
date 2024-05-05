<?php
namespace Xtend\Firebase\Console\Controller;

use RuntimeException;
use Zend\Mvc\Console\Controller\AbstractConsoleController;
use Zend\Console\Request as ConsoleRequest;
use Psr\Log\LoggerAwareTrait;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class NotificationController extends AbstractConsoleController
{
    use LoggerAwareTrait;

    /**
     * @var array
     */
    protected $configs;

    /**
     * @var array
     */
    protected $httpHeaders = [];

    /**
     * @var GuzzleHttp\Client
     */
    protected $httpClient;

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

    public function getHttpClient()
    {
        if ($this->httpClient === null) {
            $requestOptions = [
                'base_uri' => $this->getConfigs()['base_uri'],
                'verify'   => $this->getConfigs()['ssl_verify']
            ];

            $this->httpClient = new HttpClient($requestOptions);
        }

        return $this->httpClient;
    }

    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * Get HTTP Headers
     *
     * @return array
     */
    public function getHttpHeaders()
    {
        if (empty($this->httpHeaders)) {
            $this->httpHeaders = [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ];
        }

        return $this->httpHeaders;
    }

    /**
     * Set HTTP Headers
     *
     * @param array $httpHeaders
     * @return
     */
    public function setHttpHeaders(array $httpHeaders)
    {
        $this->httpHeaders = $httpHeaders;
        return $this;
    }

    public function sendNotificationAction()
    {
        $request = $this->getRequest();
        if (! $request instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this action from a console!');
        }

        $firebaseId = $request->getParam('firebaseId');
        $data = $request->getParam('message');
        if (is_null($firebaseId) || is_null($data)) {
            return;
        }

        // trim data from cli
        $trimData = trim(stripslashes($data), '"');
        $trimDataObj = json_decode($trimData);
        $body = new \stdClass();
        $body->data = $trimDataObj;
        $body->to   = $firebaseId;

        $notificationBody = new \stdClass();
        $notificationBody->title = $trimDataObj->title;
        $notificationBody->body  = $trimDataObj->body;
        $notificationBody->click_action  = $this->getConfigs()['click_action'];
        $notificationBody->sound = $this->getConfigs()['sound'];

        $body->notification = $notificationBody;
        try {
            $bodyResponse = $this->send($body);
            if (! is_null($bodyResponse)) {
                $this->logResponse(__FUNCTION__, $bodyResponse, $firebaseId, $data);
            }
        } catch (\RuntimeException $e) {
            return;
        }
    }

//     /**
//      * Log Firebase Response
//      *
//      * @param string $name
//      * @param array  $bodyResponse
//      * @param string $firebaseId
//      * @param array  $data
//      */
    protected function logResponse($name, $bodyResponse, $firebaseId, $data)
    {
        // fcm failed
        if (isset($bodyResponse['failure']) && $bodyResponse['failure'] == true) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "firebase {firebaseId} {errors} {data}",
                [
                    "errors"     => json_encode($bodyResponse['results']),
                    "firebaseId" => $firebaseId,
                    "data" => $data
                ]
            );
        }

        // fcm success
        if (isset($bodyResponse['success']) && $bodyResponse['success'] == true) {
            $responseId = isset($bodyResponse['multicast_id']) ? $bodyResponse['multicast_id'] : null;
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "firebase {responseId} {firebaseId} {data}",
                [
                    "firebaseId" => $firebaseId,
                    "responseId" => $responseId,
                    "data" => $data
                ]
            );
        }

        $messageId = isset($bodyResponse['message_id']) ? $bodyResponse['message_id'] : null;
        if (! is_null($messageId)) {
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "firebase {messageId} {firebaseId} {data}",
                [
                    "firebaseId" => $firebaseId,
                    "messageId" => $messageId,
                    "data" => $data
                ]
            );
        }
    }

    /**
     * Update Server Key
     *
     * @param string $serverKey
     */
    protected function putServerKey($serverKey)
    {
        $httpHeaders = $this->getHttpHeaders();
        $httpHeaders['Authorization'] = 'key=' . $serverKey;
        $this->setHttpHeaders($httpHeaders);
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
        // set server key
        if (isset($this->getConfigs()['server_key']) &&
            ! empty($this->getConfigs()['server_key'])) {
                $this->putServerKey($this->getConfigs()['server_key']);
        }

        $url = $this->getConfigs()['base_uri'] . '/fcm/send';
        $bodyResponse = null;
        $jsonBodyRequest = json_encode($bodyRequest);
        $this->logger->log(
            \Psr\Log\LogLevel::DEBUG,
            "firebase {message}",
            ["message"  => $jsonBodyRequest]
        );
        try {
            $request  = new Request('POST', $url, $this->getHttpHeaders(), $jsonBodyRequest);
            $response = $this->getHttpClient()->send($request);
            $bodyResponse = json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "firebase {message}",
                ["function" => __FUNCTION__, "message"  => $e->getMessage()]
            );

            throw new \RuntimeException($e->getMessage());
        }

        return $bodyResponse;
    }
}
