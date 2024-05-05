<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class GoogleAuthEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userMapper = $container->get('Aqilix\OAuth2\Mapper\OauthUsers');
        $userProfileMapper = $container->get('User\Mapper\UserProfile');
        $accessTokensMapper  = $container->get('Aqilix\OAuth2\Mapper\OauthAccessTokens');
        $refreshTokensMapper = $container->get('Aqilix\OAuth2\Mapper\OauthRefreshTokens');
        $oauth2AccessToken   = $container->get('oauth2.accessToken');
        $config = $container->get('Config');
        $eventConfig = [
            'expires_in' => $config['zf-oauth2']['access_lifetime'],
            'client_id'  => 'iqs-mobile-app',
            'token_type' => 'Bearer',
            'scope' => null
        ];
        $googleAuthEventListener = new GoogleAuthEventListener(
            $oauth2AccessToken,
            $userMapper,
            $userProfileMapper,
            $accessTokensMapper,
            $refreshTokensMapper,
            $eventConfig
        );
        $googleAuthEventListener->setLogger($container->get("logger_default"));
        return $googleAuthEventListener;
    }
}
