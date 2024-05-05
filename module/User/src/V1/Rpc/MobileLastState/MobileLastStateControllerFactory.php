<?php
namespace User\V1\Rpc\MobileLastState;

class MobileLastStateControllerFactory
{
    public function __invoke($controllers)
    {
        $mobilleStateService  = $controllers->get('user.mobilestate');
        $userProfileMapper    = $controllers->get(\User\Mapper\UserProfile::class);

        $authentication = $controllers->get('authentication');
        $username    = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        return new MobileLastStateController($mobilleStateService, $userProfileMapper, $userProfile);
    }
}
