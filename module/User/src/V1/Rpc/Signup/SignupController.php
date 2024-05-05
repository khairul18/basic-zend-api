<?php
namespace User\V1\Rpc\Signup;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Zend\Json\Json;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;

class SignupController extends AbstractActionController
{
    use UserProfileMapperTrait;

    protected $signupValidator;
    protected $signupService;

    public function __construct(
        $userProfile,
        $signupService,
        $signupValidator,
        UserProfileMapper $userProfileMapper
    ) {

        $this->userProfile = $userProfile;
        $this->signupValidator = $signupValidator;
        $this->signupService   = $signupService;
        $this->setUserProfileMapper($userProfileMapper);
    }

    /**
     * Handle /api/signup
     *
     * @return \ZF\ApiProblem\ApiProblemResponse|\ZF\Hal\View\HalJsonModel
     */
    public function signupAction()
    {
        $bodyRequest = Json::decode($this->getRequest()->getContent(), true);
        $icNumber = $bodyRequest['icNumber'];
        $email    = $bodyRequest['email'];
        $state    = $bodyRequest['state'];
        $district = $bodyRequest['district'];
        $this->signupValidator->setData($bodyRequest);

        $userEmailEntity = $this->getUserProfileMapper()->fetchOneBy([
            "username" => $email
        ]);
        if (! is_null($userEmailEntity)) {
            return new ApiProblemResponse(new ApiProblem(
                422,
                "User with Username ".$email." already registerd"
            ));
        }

        $userICNumberEntity = $this->getUserProfileMapper()->fetchOneBy([
            "icNumber" => $icNumber
        ]);
        if (! is_null($userICNumberEntity)) {
            return new ApiProblemResponse(new ApiProblem(
                422,
                "User with IC Number ".$icNumber." already registerd"
            ));
        }

        try {
            $this->signupValidator->add(['name' => 'role']);
            $this->signupValidator->get('role')->setValue("user");

            $this->signupService->register($this->signupValidator->getValues());
            return new HalJsonModel($this->signupService->getSignupEvent()->getAccessTokenResponse());
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
    }
}
