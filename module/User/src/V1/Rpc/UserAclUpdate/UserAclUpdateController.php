<?php
namespace User\V1\Rpc\UserAclUpdate;

use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Zend\Mvc\Controller\AbstractActionController;
use User\Mapper\UserAclTrait as UserAclMapperTrait;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;
use User\V1\Role as Role;

class UserAclUpdateController extends AbstractActionController
{
    use UserProfileMapperTrait;
    use UserAccessMapperTrait;
    use UserAclMapperTrait;

    /**
     * @var User\V1\Service\UserAcl
     */
    protected $userAclService;

    /**
     * @var User\Entity\UserProfile
     */
    protected $userProfile;

    /**
     * @var Zend\InputFilter\InputFilter
     */
    protected $uuidValidator;

    public function __construct(
        $userProfile,
        \User\Mapper\UserProfile $userProfileMapper,
        \User\Mapper\UserAccess $userAccessMapper,
        \User\Mapper\UserAcl $userAclMapper,
        \User\V1\Service\UserAcl $userAclService
    ) {
        $this->userProfile = $userProfile;
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserAccessMapper($userAccessMapper);
        $this->setUserAclMapper($userAclMapper);
        $this->setUserAclService($userAclService);
    }

    public function userAclUpdateAction()
    {
        $event = $this->getEvent();
        $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');
        $optionFields = json_decode($inputFilter->getValue('dataAcl'));
        $userProfile = $this->getUserProfile();
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $allowedUsers = [
            Role::ADMIN,
            Role::MANAGER,
        ];

        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (! is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if (!in_array($role, $allowedUsers)) {
            return new ApiProblemResponse(new ApiProblem(403, "Your account type doesn't have privilege for accessing this system"));
        }

        try {
            $this->getUserAclService()->action($optionFields);

            // $hal = $this->getPluginManager()->get('Hal');
            // $reimbursementHalMetaData = $hal->getMetadataMap()->get(\Reimbursement\Entity\Reimburse::class);
            // $response = $hal->createEntityFromMetadata($dataAction, $reimbursementHalMetaData);

            // return new HalJsonModel(["payload" => $response]);
            return $this->getResponse()->setStatusCode(\Zend\Http\Response::STATUS_CODE_204);
        } catch (\Ticket\V1\Service\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
    }

    /**
     * Get the value of userAclService
     *
     * @return  User\V1\Service\UserAcl
     */ 
    public function getUserAclService()
    {
        return $this->userAclService;
    }

    /**
     * Set the value of userAclService
     *
     * @param  User\V1\Service\UserAcl  $userAclService
     *
     * @return  self
     */ 
    public function setUserAclService(\User\V1\Service\UserAcl $userAclService)
    {
        $this->userAclService = $userAclService;

        return $this;
    }

    /**
     * Get the value of userProfile
     *
     * @return  User\Entity\UserProfile
     */ 
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set the value of userProfile
     *
     * @param  User\Entity\UserProfile  $userProfile
     *
     * @return  self
     */ 
    public function setUserProfile(\User\Entity\UserProfile $userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get the value of uuidValidator
     *
     * @return  Zend\InputFilter\InputFilter
     */ 
    public function getUuidValidator()
    {
        return $this->uuidValidator;
    }

    /**
     * Set the value of uuidValidator
     *
     * @param  Zend\InputFilter\InputFilter  $uuidValidator
     *
     * @return  self
     */ 
    public function setUuidValidator(\Zend\InputFilter\InputFilter $uuidValidator)
    {
        $this->uuidValidator = $uuidValidator;

        return $this;
    }
}
