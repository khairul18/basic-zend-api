<?php
namespace User\V1\Rpc\UserAclUpdate;

class UserAclUpdateControllerFactory
{
    public function __invoke($controllers)
    {
        $userAclMapper  = $controllers->get(\User\Mapper\UserAcl::class);
        $userAclService = $controllers->get(\User\V1\Service\UserAcl::class);
        $userProfileMapper   = $controllers->get(\User\Mapper\UserProfile::class);
        $userAccessMapper   = $controllers->get(\User\Mapper\UserAccess::class);
        $authentication = $controllers->get('authentication');
        $username    = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $userProfileMapper->fetchOneBy(['username' => $username]);
        return new UserAclUpdateController(
            $userProfile, 
            $userProfileMapper,
            $userAccessMapper,
            $userAclMapper,
            $userAclService
        );
    }
}
