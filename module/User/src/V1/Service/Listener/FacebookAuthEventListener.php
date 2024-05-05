<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Entity\UserProfile as UserProfileEntity;
use Psr\Log\LoggerAwareTrait;
use User\V1\FacebookAuthEvent;
use ZF\ApiProblem\ApiProblem;
use Aqilix\OAuth2\Mapper\OauthUsers as UserMapper;
use Aqilix\OAuth2\Mapper\OauthAccessTokens as AccessTokenMapper;
use Aqilix\OAuth2\Mapper\OauthRefreshTokens as RefreshTokenMapper;
use Aqilix\OAuth2\ResponseType\AccessToken as OAuth2AccessToken;

class FacebookAuthEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $userProfileMapper;
    protected $userProfileHydrator;

    public function __construct(
        OAuth2AccessToken $oauth2AccessToken,
        UserMapper $userMapper,
        UserProfileMapper $userProfileMapper,
        AccessTokenMapper $accessTokenMapper,
        RefreshTokenMapper $refreshTokenMapper,
        array $config = []
    ) {
        $this->userMapper   = $userMapper;
        $this->oauth2AccessToken  = $oauth2AccessToken;
        $this->accessTokenMapper  = $accessTokenMapper;
        $this->userProfileMapper  = $userProfileMapper;
        $this->refreshTokenMapper   = $refreshTokenMapper;
        $this->config = $config;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            FacebookAuthEvent::EVENT_FACEBOOK_AUTH,
            [$this, 'saveFacebookAuth'],
            499
        );
    }

    public function saveFacebookAuth(FacebookAuthEvent $event)
    {
        $clientId = $this->getConfig()['client_id'];
        $userId   = $event->getUserEmail();
        $now = new \DateTime('now');
        $accessTokensExpires = new \DateTime();
        $accessTokensExpires->setTimestamp($now->getTimestamp() + $this->getConfig()['expires_in']);
        // @todo retrieve expired from config
        $refreshTokenExpires = new \DateTime('now');
        $refreshTokenExpires->add(new \DateInterval('P14D'));

        try {
            // insert access_token
            $accessTokens = new \Aqilix\OAuth2\Entity\OauthAccessTokens();
            $accessTokens->setClientId($clientId)
                ->setAccessToken($this->getOauth2AccessToken()->generateToken())
                ->setExpires($accessTokensExpires)
                ->setUserId($userId);
            $this->getAccessTokenMapper()->save($accessTokens);

            // insert refresh_token
            $refreshTokens = new \Aqilix\OAuth2\Entity\OauthRefreshTokens();
            $refreshTokens->setClientId($clientId)
                ->setRefreshToken($this->getOauth2AccessToken()->generateToken())
                ->setExpires($refreshTokenExpires)
                ->setUserId($userId);
            $this->getRefreshTokenMapper()->save($refreshTokens);
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }

        // set accessToken response
        $accessTokensResponse = [
            'access_token'  => $accessTokens->getAccessToken(),
            'expires_in' => $this->getConfig()['expires_in'],
            'token_type' => $this->getConfig()['token_type'],
            'scope' => $this->getConfig()['scope'],
            'refresh_token' => $refreshTokens->getRefreshToken()
        ];
        $event->setAccessTokenResponse($accessTokensResponse);
        $this->logger->log(
            \Psr\Log\LogLevel::INFO,
            "{function} {username} {accessToken}",
            [
                "function" => __FUNCTION__,
                "username" => $userId,
                "accessToken" => $accessTokens->getAccessToken()
            ]
        );
    }

    /**
     * Get AccessTokenMapper
     *
     * @return AccessTokenMapper
     */
    public function getAccessTokenMapper()
    {
        return $this->accessTokenMapper;
    }

    /**
     * Set AccessTokenMapper
     *
     * @param AccessTokenMapper $accessTokenMapper
     */
    public function setAccessTokenMapper(AccessTokenMapper $accessTokenMapper)
    {
        $this->accessTokenMapper = $accessTokenMapper;
    }

    /**
     * @return the $refreshTokenMapper
     */
    public function getRefreshTokenMapper()
    {
        return $this->refreshTokenMapper;
    }

    /**
     * @param RefreshTokenMapper $refreshTokenMapper
     */
    public function setRefreshTokenMapper(RefreshTokenMapper $refreshTokenMapper)
    {
        $this->refreshTokenMapper = $refreshTokenMapper;
    }

    /**
     * @return the $oauth2AccessToken
     */
    public function getOauth2AccessToken()
    {
        return $this->oauth2AccessToken;
    }

    /**
     * @param OAuth2AccessToken $oauth2AccessToken
     */
    public function setOauth2AccessToken(OAuth2AccessToken $oauth2AccessToken)
    {
        $this->oauth2AccessToken = $oauth2AccessToken;
    }

    /**
     * Get the value of config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @return  self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }
}
