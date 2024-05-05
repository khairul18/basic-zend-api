<?php
namespace Xtend\GoSms\Console;

use ZF\Console\Route;
use Zend\Console\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareTrait;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Order\Entity\OrderSmsLog;

class Sms
{
    use LoggerAwareTrait;

    protected $container;
    protected $logger;
    protected $orderMapper;
    protected $orderSmsLogMapper;

    /**
     * @var array
     */
    protected $configs;

    /**
     * @var GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * Response Code
     */
    const RESPONSE_CODE_SUCCESS = '1701';

    const RESPONSE_CODE_INVALID_USER = '1702';

    const RESPONSE_CODE_INVALID_SERVER_ERROR = '1703';

    const RESPONSE_CODE_DATA_NOT_FOUND = '1704';

    const RESPONSE_CODE_DATA_FAILED = '1705';

    const RESPONSE_CODE_INVALID_MESSAGE = '1706';

    const RESPONSE_CODE_INVALID_NUMBER  = '1707';

    const RESPONSE_CODE_INSUFFICIENT_CREDIT = '1708';

    const RESPONSE_CODE_GROUP_EMPTY = '1709';

    public function __invoke(Route $route, AdapterInterface $console, ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->setLogger($container->get("gosms_logger"));
        $this->setOrderMapper($container->get(\Order\Mapper\Order::class));
        $this->setOrderSmsLogMapper($container->get(\Order\Mapper\OrderSmsLog::class));

        // get configuration
        $config = $container->get('Config');
        $gosmsConfig = $config['gosms'];
        $this->setConfigs($gosmsConfig);

        $to   = $route->getMatchedParam('to', null);
        $data = $route->getMatchedParam('message', null);
        $trimData = trim(stripslashes($data), '"');
        $message  = json_decode($trimData);

        if ($message === null) {
            $console->writeLine('Wrong json format');
            return;
        }

        //$message = $msgObj->content;
        $order = $message->order;
        // trim data from cli
        // $trimMessage = trim(stripslashes($message->content), '"');
        $url = $this->buildUrl($gosmsConfig['username'], $gosmsConfig['password'], $to, $message->content);
        $bodyResponse = $this->send($url);
        $this->saveResponse($bodyResponse, $to, $message->content, $order);
        // $this->logResponse(__FUNCTION__, $bodyResponse, $to, $message->content, $order);
    }

    /**
     * Build
     *
     * @param string username
     * @param string password
     * @param string mobile
     * @param string message
     */
    protected function buildUrl($username, $password, $mobile, $message)
    {
        $type    = 0;
        $trxid   = (string) microtime(true);
        $auth    = md5($username . $password . $mobile);
        $baseUrl = $this->getConfigs()['base_uri'] . '/masking/api/sendsms.php';
        $params  = compact(['username', 'mobile', 'message', 'trxid', 'auth', 'type']);
        return $baseUrl . '?' . http_build_query($params);
    }

    /**
     * Send request
     *
     * @param string url
     */
    public function send($url)
    {
        try {
            $request  = new Request('GET', $url);
            $response = $this->getHttpClient()->send($request);
            if ($response->getStatusCode() === \Zend\Http\Response::STATUS_CODE_200) {
                $bodyResponse = $response->getBody()->getContents();
                return $bodyResponse;
            }
        } catch (RequestException $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "GoSMS Request Error! {message}",
                ["function" => __FUNCTION__, "message"  => $e->getMessage()]
            );

            throw new \RuntimeException($e->getMessage());
        }
    }

    protected function saveResponse($bodyResponse, $mobile, $message, $order)
    {
        if ($bodyResponse == self::RESPONSE_CODE_SUCCESS) {
            // check status message
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "GoSMS Success! Sent to {mobile} {orderid} {message}",
                ["function" => __FUNCTION__, "message"  => $message, "mobile" => $mobile, "orderid" => $order]
            );
        } else {
            switch ($bodyResponse) {
                case self::RESPONSE_CODE_INVALID_USER:
                    $this->logger->log(
                        \Psr\Log\LogLevel::ERROR,
                        "GoSMS Error! {message}",
                        ["function" => __FUNCTION__, "message"  => "Invalid user"]
                    );
                    break;
                case self::RESPONSE_CODE_INVALID_SERVER_ERROR:
                    $this->logger->log(
                        \Psr\Log\LogLevel::ERROR,
                        "GoSMS Error! {message}",
                        ["function" => __FUNCTION__, "message"  => "Invalid server error"]
                    );
                    break;
                case self::RESPONSE_CODE_DATA_NOT_FOUND:
                    $this->logger->log(
                        \Psr\Log\LogLevel::ERROR,
                        "GoSMS Error! {message}",
                        ["function" => __FUNCTION__, "message"  => "Data not found"]
                    );
                    break;
                case self::RESPONSE_CODE_DATA_FAILED:
                    $this->logger->log(
                        \Psr\Log\LogLevel::ERROR,
                        "GoSMS Error! {message}",
                        ["function" => __FUNCTION__, "message"  => "Data failed"]
                    );
                    break;
                case self::RESPONSE_CODE_INVALID_MESSAGE:
                    $this->logger->log(
                        \Psr\Log\LogLevel::ERROR,
                        "GoSMS Error! {message}",
                        ["function" => __FUNCTION__, "message"  => "Invalid message"]
                    );
                    break;
                case self::RESPONSE_CODE_INVALID_NUMBER:
                    $this->logger->log(
                        \Psr\Log\LogLevel::ERROR,
                        "GoSMS Error! {message}",
                        ["function" => __FUNCTION__, "message"  => "Invalid number"]
                    );
                    break;
                case self::RESPONSE_CODE_INSUFFICIENT_CREDIT:
                    $this->logger->log(
                        \Psr\Log\LogLevel::ERROR,
                        "GoSMS Error! {message}",
                        ["function" => __FUNCTION__, "message"  => "Insufficient credit"]
                    );
                    break;
                case self::RESPONSE_CODE_GROUP_EMPTY:
                    $this->logger->log(
                        \Psr\Log\LogLevel::ERROR,
                        "GoSMS Error! {message}",
                        ["function" => __FUNCTION__, "message"  => "Group empty"]
                    );
                    break;
                default:
                    break;
            }
            return;
        }

        try {
            $smsLogEntity = new OrderSmsLog;
            $orderObject  = $this->getOrderMapper()->fetchOneBy(["uuid" => $order]);
            $smsLogEntity->setOrder($orderObject);
            // $smsLogEntity->setMessageId($messageId);
            $smsLogEntity->setTo($mobile);
            $smsLogEntity->setDescription($message);
            $logResult = $this->getOrderSmsLogMapper()->save($smsLogEntity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "GoSMS {function} {uuid}: Order SMS Log Saved",
                [
                    'uuid' => $logResult->getUuid(),
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "GoSMS {function}: Order SMS Log cannot be saved! {error}",
                ["function" => __FUNCTION__, "error" => $e->getMessage()]
            );
        }
    }

    public function getHttpClient()
    {
        if ($this->httpClient === null) {
            $requestOptions = [
                'base_uri' => $this->getConfigs()['base_uri'],
                'verify'   => false
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
     * @return
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Get configs
     *
     * @return array
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * Set configs
     *
     * @param  array configs
     * @return
     */
    public function setConfigs(array $configs)
    {
        $this->configs = $configs;
        return $this;
    }

    /**
     * Get the value of orderMapper
     */
    public function getOrderMapper()
    {
        return $this->orderMapper;
    }

    /**
     * Set the value of orderMapper
     *
     * @return  self
     */
    public function setOrderMapper($orderMapper)
    {
        $this->orderMapper = $orderMapper;

        return $this;
    }

    /**
     * Get the value of orderSmsLogMapper
     */
    public function getOrderSmsLogMapper()
    {
        return $this->orderSmsLogMapper;
    }

    /**
     * Set the value of orderSmsLogMapper
     *
     * @return  self
     */
    public function setOrderSmsLogMapper($orderSmsLogMapper)
    {
        $this->orderSmsLogMapper = $orderSmsLogMapper;

        return $this;
    }
}
