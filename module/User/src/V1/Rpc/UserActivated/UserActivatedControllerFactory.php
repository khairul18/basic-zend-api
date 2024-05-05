<?php
namespace User\V1\Rpc\UserActivated;

class UserActivatedControllerFactory
{
    public function __invoke($controllers)
    {
        $authentication = $controllers->get('authentication');
        $username     = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        $userActivatedValidator = $controllers->get('InputFilterManager')->get('User\\V1\\Rpc\\UserActivated\\Validator');
        $userActivatedService  = $controllers->get('user.activated');
        $userProfileMapper = $controllers->get('User\Mapper\UserProfile');
        $userAccessMapper = $controllers->get('User\Mapper\UserAccess');
        return new UserActivatedController($userProfile, $userActivatedValidator, $userActivatedService, $userProfileMapper, $userAccessMapper);
    }
}
