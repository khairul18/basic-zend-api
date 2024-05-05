<?php
namespace User\V1\Rpc\AuthRevoke;

use ZF\OAuth2\Controller\AuthController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use User\V1\Service\Signout;
use Psr\Log\LoggerAwareTrait;

class AuthRevokeController extends AuthController
{
    use LoggerAwareTrait;

    /**
     * @var \User\V1\Service\Signout
     */
    protected $signoutService;

    public function __construct($serverFactory)
    {
        $this->serverFactory  = $serverFactory;
    }

    public function authRevokeAction()
    {
        $oauthServer   = call_user_func($this->serverFactory, 'oauth');
        $oauth2Request = $this->getOAuth2Request();
        $oauth2Request->headers['Authorization'] = 'Bearer ' . $oauth2Request->request('token');
        $accessToken   = $oauthServer->getAccessTokenData($oauth2Request);
        $response = $oauthServer->handleRevokeRequest($oauth2Request);
        if ($response->isClientError()) {
            return $this->getErrorResponse($response);
        }

        try {
            $this->getSignoutService()->signout($accessToken['user_id']);
            $httpResponse = $this->getResponse();
            $httpResponse->setStatusCode($response->getStatusCode());
            $httpResponse->setContent($response->getResponseBody());
            return $httpResponse;
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
    }

    /**
     * Get Signout Service
     *
     * @return \User\V1\Service\Signout
     */
    public function getSignoutService()
    {
        return $this->signoutService;
    }

    /**
     * Set Signout Service
     * @param  \User\V1\Service\Signout $signoutService
     * @return \User\V1\Rpc\AuthRevoke\AuthRevokeController
     */
    public function setSignoutService(\User\V1\Service\Signout $signoutService)
    {
        $this->signoutService = $signoutService;
        return $this;
    }
}
