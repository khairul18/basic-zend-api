<?php

namespace User\V1\Rest\Profile;

class ProfileResourceFactory
{
    public function __invoke($services)
    {
        $authentication = $services->get('authentication');
        $username     = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $loggedInUser = $services->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $comapnyMapper        = $services->get('User\Mapper\Company');
        $branchMapper         = $services->get('User\Mapper\Branch');
        $departmentMapper     = $services->get('User\Mapper\Department');
        $userAccessMapper     = $services->get('User\Mapper\UserAccess');
        $userProfile = $services->get('user.profile');

        $profileResource = new ProfileResource(
            $loggedInUser,
            $userProfileMapper,
            $comapnyMapper,
            $branchMapper,
            $departmentMapper,
            $userAccessMapper
        );

        $profileResource->setUserProfileService($userProfile);
        $profileResource->setLogger($services->get("logger_default"));
        return $profileResource;
    }
}
