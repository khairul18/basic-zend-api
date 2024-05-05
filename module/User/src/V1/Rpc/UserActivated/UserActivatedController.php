<?php
namespace User\V1\Rpc\UserActivated;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Json;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\View\HalJsonModel;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;

class UserActivatedController extends AbstractActionController
{
    use UserProfileMapperTrait;
    use UserAccessMapperTrait;

    protected $userProfile;
    protected $userActivatedValidator;
    protected $userActivatedService;

    public function __construct(
        $userProfile, 
        $userActivatedValidator, 
        $userActivatedService, 
        $userProfileMapper,
        \User\Mapper\UserAccess $userAccessMapper
    )
    {
        $this->userProfile = $userProfile;
        $this->setUserActivatedValidator($userActivatedValidator);
        $this->setUserActivatedService($userActivatedService);
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserAccessMapper($userAccessMapper);
    }

    public function userActivatedAction()
    {
        $this->getUserActivatedValidator()->setData(Json::decode($this->getRequest()->getContent(), true));
        $userProfile = $this->userProfile;

        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];

        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (! is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role === \User\V1\Role::ADMIN) {
            $inputFilter = $this->getUserActivatedValidator()->getValues();
            $uuid = $inputFilter['uuid'];
            $isActive = $inputFilter['isActive'];
            if ($isActive > 1) {
                return new ApiProblemResponse(new ApiProblem(
                    422,
                    "Failed Validation",
                    null,
                    null,
                    ['validation_messages' => ['Check Your isActive' => "Is Active Only Numbers 1 or 0"]]
                ));
            }
            $userProfileObj  = $this->getUserProfileMapper()->fetchOneBy([
                'uuid' => $uuid
            ]);
            if (is_null($userProfileObj)) {
                return new ApiProblemResponse(new ApiProblem(404, "User Profile Not Found"));
            }
            $userActivated = $this->getUserActivatedService()
                                   ->update($inputFilter, $userProfileObj, $userProfile);
            return new HalJsonModel($userActivated);
        } else {
            return new ApiProblemResponse(new ApiProblem(403, "please use the admin user to access this page!!!"));
        }
    }

    /**
     * @return the $userActivatedValidator
     */
    public function getUserActivatedValidator()
    {
        return $this->userActivatedValidator;
    }

    /**
     * @param field_type $userActivatedValidator
     */
    public function setUserActivatedValidator($userActivatedValidator)
    {
        $this->userActivatedValidator = $userActivatedValidator;
    }

    /**
     * @return the $userActivatedService
     */
    public function getUserActivatedService()
    {
        return $this->userActivatedService;
    }

    /**
     * @param field_type $userActivatedService
     */
    public function setUserActivatedService($userActivatedService)
    {
        $this->userActivatedService = $userActivatedService;
    }
}
