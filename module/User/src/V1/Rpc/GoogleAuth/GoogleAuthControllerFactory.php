<?php
namespace User\V1\Rpc\GoogleAuth;

class GoogleAuthControllerFactory
{
    public function __invoke($controllers)
    {
        $config     = $controllers->get('Config');
        $googleAuthService = $controllers->get('user.google.auth');
        $userProfileMapper = $controllers->get('User\Mapper\UserProfile');
        $controller = new GoogleAuthController($userProfileMapper);
        $controller->setConfig($config);
        $controller->setGoogleAuthService($googleAuthService);
        return $controller;
    }
}
