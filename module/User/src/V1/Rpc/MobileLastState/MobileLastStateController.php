<?php
namespace User\V1\Rpc\MobileLastState;

use ZF\Hal\View\HalJsonModel;
use Zend\Mvc\Controller\AbstractActionController;
use User\V1\Service\MobileState as MobileStateService;
use User\Mapper\UserProfile as userProfileMapper;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Zend\Json\Json;
use User\Mapper\UserProfileTrait as UserProfileTrait;

class MobileLastStateController extends AbstractActionController
{
    use UserProfileTrait;

    protected $mobileStateService;
    protected $userProfileMapper;
    protected $userProfile;

    public function __construct(
        \User\V1\Service\MobileState $mobileStateService,
        \User\Mapper\UserProfile $userProfileMapper,
        $userProfile
    ) {
        $this->setuserProfileMapper($userProfileMapper);
        $this->setMobileStateService($mobileStateService);
        $this->userProfile = $userProfile;
    }

    public function mobileLastStateAction()
    {
        $event  = $this->getEvent();
        $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');

        try {
            $mobileState = $this->getMobileStateService()->saveMobileState($this->userProfile, $inputFilter);
            return new HalJsonModel(["save" => $mobileState]);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, "Cannot save state!"));
        }
    }

    public function getMobileStateService()
    {
        return $this->mobileStateService;
    }

    public function setMobileStateService(\User\V1\Service\MobileState $mobileStateService)
    {
        $this->mobileStateService = $mobileStateService;
        return $this;
    }
}
