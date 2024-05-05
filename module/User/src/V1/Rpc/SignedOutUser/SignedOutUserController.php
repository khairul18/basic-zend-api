<?php
namespace User\V1\Rpc\SignedOutUser;

use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Zend\Mvc\Controller\AbstractActionController;
use Psr\Log\LoggerAwareTrait;

class SignedOutUserController extends AbstractActionController
{
    use LoggerAwareTrait;

    protected $signedOutUserService;

    public function __construct($userProfile)
    {
        $this->userProfile = $userProfile;
    }

    public function signedOutUserAction()
    {
        // $userProfile = $this->userProfile;

        try {
            $userProfile = $this->userProfile;
            // var_dump(get_class_methods($this->signedOutUserService()));exit;
            $this->getSignedOutUserService()->signedOutUser($this->userProfile);
            return new HalJsonModel([]);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e));
        }
    }

    public function setSignedOutUserService(\User\V1\Service\Signout $signedOutUserService)
    {
        $this->signedOutUserService = $signedOutUserService;
        return $this;
    }

    public function getSignedOutUserService()
    {
        return $this->signedOutUserService;
    }
}
