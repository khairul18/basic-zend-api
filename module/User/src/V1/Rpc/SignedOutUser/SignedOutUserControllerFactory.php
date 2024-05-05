<?php
namespace User\V1\Rpc\SignedOutUser;

class SignedOutUserControllerFactory
{
    public function __invoke($controllers)
    {
        $authentication = $controllers->get('authentication');
        $username    = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        $signoutService = $controllers->get('user.signout');
        $signedOutUser  = new SignedOutUserController($userProfile);
        $signedOutUser->setSignedOutUserService($signoutService);
        $signedOutUser->setLogger($controllers->get("logger_default"));
        return $signedOutUser;
    }
}
