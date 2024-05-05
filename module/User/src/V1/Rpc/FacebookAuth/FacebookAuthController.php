<?php
namespace User\V1\Rpc\FacebookAuth;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\View\HalJsonModel;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;

class FacebookAuthController extends AbstractActionController
{
    use UserProfileMapperTrait;

    protected $config;
    protected $facebookAuthService;

    public function __construct(
        UserProfileMapper $userProfileMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
    }

    public function facebookAuthAction()
    {
        $config = $this->getConfig()['facebook_xtend_test'];
        $event  = $this->getEvent();
        $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');
        $accessToken = $inputFilter->getValues()['accessToken'];
        $fb = new \Facebook\Facebook($config);
        if (is_null($accessToken)) {
            return new ApiProblemResponse(new ApiProblem(422, "ID Token Invalid"));
        }
        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        if ($tokenMetadata->isError()) {
            return new ApiProblemResponse(new ApiProblem(500, $tokenMetadata->getErrorMessage()));
        }
        $fb->setDefaultAccessToken($accessToken);
        $response = $fb->get('/me?fields=id,name,email', $accessToken);
        if ($response) {
            $graphUser = $response->getGraphUser();
            $email = $graphUser['email'];
            if (is_null($email)) {
                return new ApiProblemResponse(new ApiProblem(500, "Your email has not been set on Facebook"));
            }

            $userEntity = $this->getUserProfileMapper()->fetchOneBy([
                "username" => $email
            ]);

            if (is_null($userEntity)) {
                return new ApiProblemResponse(new ApiProblem(401, "User not Registered"));
            }

            $facebookAuth = $this->getFacebookAuthService()->auth($email);
            return new HalJsonModel($facebookAuth);
        } else {
            return new ApiProblemResponse(new ApiProblem(422, "ID Token Invalid"));
        }
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     *
     * @return self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFacebookAuthService()
    {
        return $this->facebookAuthService;
    }

    /**
     * @param mixed $facebookAuthService
     *
     * @return self
     */
    public function setFacebookAuthService($facebookAuthService)
    {
        $this->facebookAuthService = $facebookAuthService;

        return $this;
    }
}
