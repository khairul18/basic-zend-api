<?php
namespace User\V1\Rest\UserActivatedLog;

class UserActivatedLogResourceFactory
{
    public function __invoke($services)
    {
        $authentication = $services->get('authentication');
        $username     = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $loggedInUser = $services->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        $UserActivatedLogMapper = $services->get('User\Mapper\UserActivatedLog');
        $userAccessMapper = $services->get('User\Mapper\UserAccess');
        $userActivatedLog = new UserActivatedLogResource($loggedInUser, $UserActivatedLogMapper, $userAccessMapper);
        return $userActivatedLog;
    }
}
