<?php
namespace User\V1\Rpc\RenewQRCode;

use ZF\Hal\View\HalJsonModel;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use User\Mapper\UserProfile as UserProfileMapper;

class RenewQRCodeController extends AbstractActionController
{
    protected $userProfileService;
    private $userProfile;
    private $userProfileMapper;

    public function __construct($userProfile, UserProfileMapper $userProfileMapper)
    {
        $this->userProfile = $userProfile;
        $this->setUserProfileMapper($userProfileMapper);
    }

    public function renewQRCodeAction()
    {
        $userProfile = $this->userProfile;
        if (! is_null($userProfile)) {
            try {
                $userProfile = $this->getUserProfileService()
                               ->renewQrCode($userProfile);
                return new HalJsonModel($userProfile);
            } catch (\User\V1\Service\Exception\RuntimeException $e) {
                return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
            }

            return $userProfile;
        }
        return new ApiProblemResponse(new ApiProblem(404, "User Identity not found"));
    }

    /**
     * Get the value of userProfileService
     */
    public function getUserProfileService()
    {
        return $this->userProfileService;
    }

    /**
     * Set the value of userProfileService
     *
     * @return  self
     */
    public function setUserProfileService($userProfileService)
    {
        $this->userProfileService = $userProfileService;

        return $this;
    }

    /**
     * Get the value of userProfileMapper
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * Set the value of userProfileMapper
     *
     * @return  self
     */
    public function setUserProfileMapper($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;

        return $this;
    }
}
