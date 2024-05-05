<?php
namespace User\V1\Rpc\RenewQRCode;

class RenewQRCodeControllerFactory
{
    public function __invoke($controllers)
    {
        $authentication = $controllers->get('authentication');
        $username    = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        $userProfileMapper  = $controllers->get('User\Mapper\UserProfile');
        $userProfileService = $controllers->get('user.profile');
        $controller = new RenewQRCodeController($userProfile, $userProfileMapper);
        $controller->setUserProfileService($userProfileService);
        return $controller;
    }
}
