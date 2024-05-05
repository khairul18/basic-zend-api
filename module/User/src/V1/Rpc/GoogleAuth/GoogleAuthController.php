<?php
namespace User\V1\Rpc\GoogleAuth;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\View\HalJsonModel;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;

class GoogleAuthController extends AbstractActionController
{
    use UserProfileMapperTrait;

    protected $config;
    protected $googleAuthService;

    public function __construct(
        UserProfileMapper $userProfileMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
    }

    public function googleAuthAction()
    {
        try {
            $config   = $this->getConfig()['google_api_client'];
            $clientId = $config['client_id'];
            $googleClient = new \Google_Client();
            $googleClient->setApplicationName("Google Client Auth");
            $googleClient->setDeveloperKey($clientId);

            $event  = $this->getEvent();
            $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');
            $idToken = $inputFilter->getValues()['idToken'];
            $payload = $googleClient->verifyIdToken($idToken);
            $email   = $payload['email'];
            $userEntity = $this->getUserProfileMapper()->fetchOneBy([
                "username" => $email
            ]);

            if ($payload) {
                if (is_null($userEntity)) {
                    return new ApiProblemResponse(new ApiProblem(401, "User not Registered"));
                }

                $googleAuth = $this->getGoogleAuthService()->auth($email);
                return new HalJsonModel($googleAuth);
            } else {
                return new ApiProblemResponse(new ApiProblem(422, "ID Token Invalid"));
            }
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
    }

    /**
     * Get the value of config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @return  self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the value of googleAuthService
     */
    public function getGoogleAuthService()
    {
        return $this->googleAuthService;
    }

    /**
     * Set the value of googleAuthService
     *
     * @return  self
     */
    public function setGoogleAuthService($googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;

        return $this;
    }
}
