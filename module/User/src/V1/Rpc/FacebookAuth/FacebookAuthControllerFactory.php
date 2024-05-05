<?php
namespace User\V1\Rpc\FacebookAuth;

class FacebookAuthControllerFactory
{
    public function __invoke($controllers)
    {
        $config     = $controllers->get('Config');
        $facebookAuthService = $controllers->get('user.facebook.auth');
        $userProfileMapper = $controllers->get('User\Mapper\UserProfile');
        $controller = new FacebookAuthController($userProfileMapper);
        $controller->setConfig($config);
        $controller->setFacebookAuthService($facebookAuthService);
        return $controller;
    }
}
