<?php

namespace User\V1\Rpc\Me;

use Attendance\V1\Hydrator\AttendanceHydratorFactory;

class MeControllerFactory
{
    public function __invoke($controllers)
    {
        $authentication = $controllers->get('authentication');
        $username    = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        $userAclMapper = $controllers->get(\User\Mapper\UserAcl::class);
        $userRoleMapper = $controllers->get(\User\Mapper\UserRole::class);
        $userAccessMapper = $controllers->get(\User\Mapper\UserAccess::class);
        // $attendanceMapper = $controllers->get(\Attendance\Mapper\Attendance::class);
        // $attendanceHydrator = (new AttendanceHydratorFactory())($controllers, 'attendance');

        return new MeController(
            $userProfile,
            $userAclMapper,
            $userRoleMapper,
            $userAccessMapper
            // $attendanceMapper,
            // $attendanceHydrator
        );
    }
}
