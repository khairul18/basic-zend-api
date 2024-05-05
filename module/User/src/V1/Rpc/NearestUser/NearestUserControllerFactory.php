<?php
namespace User\V1\Rpc\NearestUser;

class NearestUserControllerFactory
{
    public function __invoke($controllers)
    {
        $config = $controllers->get('Config')['project']['nearest_users'];
        $authentication = $controllers->get('authentication');
        $username       = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfileMapper = $controllers->get('User\Mapper\UserProfile');
        $userProfileEntity = $userProfileMapper->fetchOneBy(['username' => $username]);
        $controller = new NearestUserController(
            $userProfileEntity,
            $userProfileMapper
        );
        $controller->setConfig($config);
        return $controller;
    }
}
