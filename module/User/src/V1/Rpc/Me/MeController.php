<?php

namespace User\V1\Rpc\Me;

// use Attendance\Entity\Attendance as AttendanceEntity;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\View\HalJsonModel;
use User\Mapper\UserAclTrait as UserAclMapperTrait;
use User\Mapper\UserRoleTrait as UserRoleMapperTrait;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;
use ZF\Hal\Plugin\Hal;

class MeController extends AbstractActionController
{
    use UserAclMapperTrait;
    use UserRoleMapperTrait;
    use UserAccessMapperTrait;

    /**
     * @var  \User\Entity\UserProfile
     */
    private $userProfile;

    /**
    //  * @var \Attendance\Mapper\Attendance
    //  */
    // protected $attendanceMapper;

    /**
    //  * @var \Zend\Hydrator\AbstractHydrator
    //  */
    // protected $attendanceHydrator;

    /**
     * @param  \User\Entity\UserProfile  $userProfile
     * @param  \User\Mapper\UserAcl  $userAclMapper
     * @param  \User\Mapper\UserRole  $userRoleMapper
     * @param  \User\Mapper\UserAccess  $userAccessMapper
    //  * @param  \Attendance\Mapper\Attendance  $attendanceMapper
    //  * @param  \Zend\Hydrator\AbstractHydrator  $attendanceHydrator
     */
    // public function __construct($userProfile, $userAclMapper, $userRoleMapper, $userAccessMapper, $attendanceMapper, $attendanceHydrator)
    public function __construct($userProfile, $userAclMapper, $userRoleMapper, $userAccessMapper)
    {
        $this->userProfile = $userProfile;
        $this->setUserAclMapper($userAclMapper);
        $this->setUserRoleMapper($userRoleMapper);
        $this->setUserAccessMapper($userAccessMapper);
        // $this->attendanceMapper = $attendanceMapper;
        // $this->attendanceHydrator = $attendanceHydrator;
    }

    public function meAction()
    {
        $allowedModulesCollection = [];
        $rolesDownStreamCollection = [];
        if (!is_null($this->userProfile)) {
            $userProfile = $this->userProfile;
            $queryParamUserAccess = [
                'userProfile' => $userProfile->getUuid()
            ];
            $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
            // role user now is $roleUuid
            if (isset($userAccess)) {
                $roleUuid = $userAccess->getUserRole()->getUuid();
                $rolesDown = $this->getUserRoleMapper()->getRoleDownStream($roleUuid);

                if (!is_null($rolesDown)) {
                    foreach ($rolesDown as $roleDown) {
                        $queryParamUserRole = [
                            'name' => $roleDown,
                            'account' => $userProfile->getAccount()->getUuid()
                        ];
                        $rolesData = $this->getUserRoleMapper()->fetchOneBy($queryParamUserRole);
                        $roleDownEntity = [
                            "uuid" => $rolesData->getUuid(),
                            "role" => $rolesData->getName()
                        ];
                        array_push($rolesDownStreamCollection, $roleDownEntity);
                    }

                    $userProfile->setRoleDownStream($rolesDownStreamCollection);
                }

                // $androidLastParam = json_decode($userProfile->getAndroidLastParam(), true);
                // $userProfile->setAndroidLastParam($androidLastParam);

                if (!is_null($roleUuid)) {
                    $params = ["role" => $roleUuid];
                    $userAcls = $this->getUserAclMapper()->fetchAll($params);
                    foreach ($userAcls->getResult() as $userAcl) {
                        // $allowedModulesEntity = [
                        //     "uuid" => $userModule->getUuid(),
                        //     "module" => $userModule->getUserModule()->getName()
                        // ];

                        if (!is_null($userAcl->getUserModule())) {
                            array_push($allowedModulesCollection, $userAcl->getUserModule()->getName());
                        } else {
                            array_push($allowedModulesCollection, '');
                        }
                        //array_push($allowedModulesCollection, $userAcl->getUserModule()->getName());
                    }

                    // $hal = $this->getPluginManager()->get('Hal');
                    // $userProfileHalMetaData = $hal->getMetadataMap()->get(\User\V1\Rpc\Me\MeEntity::class);
                    // return new ViewModel([
                    //     'payload' => $hal->createEntityFromMetadata($userProfile, $userProfileHalMetaData)
                    // ]);

                    $userProfile->setAllowedModules($allowedModulesCollection);
                }
            }

            $hal = $this->getPluginManager()->get('Hal');
            if (!($hal instanceof Hal))
                return new ApiProblemResponse(new ApiProblem(500, "Hal plugin not found"));

            $userProfileHalMetaData = $hal->getMetadataMap()->get(\User\V1\Rpc\Me\MeEntity::class);
            $extracted = $userProfileHalMetaData->getHydrator()->extract($userProfile);

            // $latestAttendance = $this->attendanceMapper->fetchYesterdayNightShiftUser($userProfile);
            // $flag = true;
            // if($latestAttendance === null || $latestAttendance->getClockOutTime() !== null) {
            //     $latestAttendance = $this->attendanceMapper->fetchTodayUser($userProfile);
            //     if($latestAttendance === null) {
            //         $latestAttendance = new AttendanceEntity();
            //         $flag = false;
            //     }
            // }

            // $attendanceData = $this->attendanceHydrator->extract($latestAttendance);
            // $attendanceData['status'] = $this->getAttendanceStatus($flag, $latestAttendance);

            // unset($extracted['attendance']);
            // $extracted['attendance'] = $attendanceData;

            return new HalJsonModel($extracted);
        }

        return new ApiProblemResponse(new ApiProblem(404, "User Identity not found"));
    }

    // /**
    //  * @param  bool  $flag
    //  * @param  \Attendance\Entity\Attendance  $attendanceData
    //  * @return string
    //  */
    // protected function getAttendanceStatus($flag, $attendanceData)
    // {
    //     if(!$flag) {
    //         return 'NO_STATUS';
    //     } else {
    //         if($attendanceData->getClockOutTime() !== null) {
    //             return 'CLOCK_OUT';
    //         } else if($attendanceData->getBreakInTime() !== null && $attendanceData->getBreakOutTime() === null) {
    //             return 'BREAK';
    //         } else {
    //             return 'CLOCK_IN';
    //         }
    //     }
    // }
}
