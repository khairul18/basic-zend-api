<?php
namespace User\Service\Listener;

use ZF\MvcAuth\MvcAuthEvent;
use Zend\Mvc\MvcEvent;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;

class ClientAuthorizationListener
{
    use LoggerAwareTrait;
    use UserAccessMapperTrait;

    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * @var array
     */
    protected $mobileConfig;

    /**
     * @var array
     */
    protected $webAppConfig;

    /**
     * Check activated
     *
     * @param  MvcAuthEvent
     */
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $isPatientRequest = '';
        $credentials = $mvcAuthEvent->getIdentity()->getAuthenticationIdentity();
        if (! is_string($credentials)) {
            return;
        }

        $isMobileAppRequest = false;
        $payloads    = json_decode($mvcAuthEvent->getMvcEvent()->getRequest()->getContent());
        $userProfile = $this->getUserProfileMapper()->fetchOneBy(['username' => $credentials]);
        $clientId    = $payloads->client_id;
        $mvcEvent    = $mvcAuthEvent->getMvcEvent();
        $request     = $mvcEvent->getRequest();
        $userAgent   = $request->getHeaders('USER-AGENT');
        $httpClient  = null;
        $webUsers    = [
            \User\V1\Role::ADMIN,
            \User\V1\Role::MANAGER,
            \User\V1\Role::TRANSPORTATION,
        ];
        // $mobileUsers = [
        //     \User\V1\Role::ADMIN,
        //     \User\V1\Role::USER,
        //     \User\V1\Role::SUPERVISOR,
        //     \User\V1\Role::MANAGER,
        //     \User\V1\Role::TRANSPORTATION,
        // ];

        $webAppConfig = $this->getWebAppConfig();
        $mobileConfig = $this->getMobileConfig();

        $isWebAppRequest = preg_match(
            '/(' . $webAppConfig['allowed_client_id'] . ')/',
            $clientId
        );
        $isMobileAppRequest = preg_match(
            '/(' . $mobileConfig['allowed_client_id']['patient'] . ')/',
            $clientId
        );

        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (! is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }
        
        if ((! $isWebAppRequest && ! $isMobileAppRequest) ||
            ($isWebAppRequest && ! in_array($role, $webUsers)) ||
            (! $isMobileAppRequest && ! in_array($role, $webUsers))) {
            $this->logger->log(
                \Psr\Log\LogLevel::WARNING,
                "{class} {noAuth} {uuid} {role} {userAgent}",
                [
                    "class"  => __CLASS__,
                    "noAuth" => "Not authorized",
                    "uuid" => $userProfile->getUuid(),
                    "role" => $role,
                    "userAgent" => $httpClient
                ]
            );
            $response = new ApiProblemResponse(
                new ApiProblem(
                    401,
                    "Your account type doesn't have privilege for accessing this system"
                )
            );
            $mvcEvent = $mvcAuthEvent->getMvcEvent();
            $mvcResponse = $mvcEvent->getResponse();
            $mvcResponse->setStatusCode($response->getStatusCode());
            $mvcResponse->setHeaders($response->getHeaders());
            $mvcResponse->setContent($response->getContent());
            $mvcResponse->setReasonPhrase('Unauthorized');
            $em = $mvcEvent->getApplication()->getEventManager();
            $mvcEvent->setName(MvcEvent::EVENT_FINISH);
            $em->triggerEvent($mvcEvent);
            $mvcAuthEvent->stopPropagation();
            return $mvcResponse;
        }

        // $role = strtolower($userProfile->getRole());

        // if ((! $isWebAppRequest && ! $isMobileAppRequest) ||
        //     ($isWebAppRequest && ! in_array($role, $webUsers)) ||
        //     ($isMobileAppRequest && ! in_array($role, $mobileUsers)) ||
        //     (! $isMobileAppRequest && ! in_array($role, $webUsers))) {
        //     $this->logger->log(
        //         \Psr\Log\LogLevel::WARNING,
        //         "{class} {noAuth} {uuid} {role} {userAgent}",
        //         [
        //             "class"  => __CLASS__,
        //             "noAuth" => "Not authorized",
        //             "uuid" => $userProfile->getUuid(),
        //             "role" => $userProfile->getRole(),
        //             "userAgent" => $httpClient
        //         ]
        //     );
        //     $response = new ApiProblemResponse(
        //         new ApiProblem(
        //             401,
        //             "Your account type doesn't have privilege for accessing this system"
        //         )
        //     );
        //     $mvcEvent = $mvcAuthEvent->getMvcEvent();
        //     $mvcResponse = $mvcEvent->getResponse();
        //     $mvcResponse->setStatusCode($response->getStatusCode());
        //     $mvcResponse->setHeaders($response->getHeaders());
        //     $mvcResponse->setContent($response->getContent());
        //     $mvcResponse->setReasonPhrase('Unauthorized');
        //     $em = $mvcEvent->getApplication()->getEventManager();
        //     $mvcEvent->setName(MvcEvent::EVENT_FINISH);
        //     $em->triggerEvent($mvcEvent);
        //     $mvcAuthEvent->stopPropagation();
        //     return $mvcResponse;
        // }

        return;
    }

    /**
     * @return \User\Mapper\UserProfile
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * Set UserProfile Mapper
     *
     * @param UserProfileMapper $userProfileMapper
     */
    public function setUserProfileMapper(UserProfileMapper $userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * Get Mobile Config
     */
    public function getMobileConfig()
    {
        return $this->mobileConfig;
    }

    /**
     * Set Mobile Config
     * @param array $mobileConfig
     * @return \User\Service\Listener\ClientAuthorizationListener
     */
    public function setMobileConfig(array $mobileConfig)
    {
        $this->mobileConfig = $mobileConfig;
        return $this;
    }

    /**
     * Get the value of webAppConfig
     *
     * @return  array
     */
    public function getWebAppConfig()
    {
        return $this->webAppConfig;
    }

    /**
     * Set the value of webAppConfig
     *
     * @param  array  $webAppConfig
     *
     * @return  self
     */
    public function setWebAppConfig(array $webAppConfig)
    {
        $this->webAppConfig = $webAppConfig;

        return $this;
    }
}
