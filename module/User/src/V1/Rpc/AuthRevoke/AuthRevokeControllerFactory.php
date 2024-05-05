<?php
namespace User\V1\Rpc\AuthRevoke;

class AuthRevokeControllerFactory
{
    public function __invoke($controllers)
    {
        $oauth2Server   = $controllers->get('ZF\OAuth2\Service\OAuth2Server');
        $signoutService = $controllers->get('user.signout');
        $authRevokeController = new AuthRevokeController($oauth2Server);
        $authRevokeController->setSignoutService($signoutService);
        $authRevokeController->setLogger($controllers->get("logger_default"));
        return $authRevokeController;
    }
}
