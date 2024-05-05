<?php

namespace User\V1\Rpc\UserSignature;

use RuntimeException;
use User\V1\Rpc\AbstractAction;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class UserSignatureController extends AbstractAction
{
    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * @var \User\V1\Service\Profile
     */
    protected $profileService;

    /**
     * @var mixed
     */
    protected $oauth2Server;

    /**
     * @var \Oauth2\Request
     */
    protected $oauth2Request;

    /**
     * @var \Zend\Hydrator\HydratorInterface
     */
    protected $userProfileHydrator;

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @param  \User\V1\Service\Profile  $profileService
     * @param  mixed  $oauth2Server
     * @param  \Oauth2\Request  $oauth2Request
     * @param  \Zend\Hydrator\HydratorInterface  $userProfileHydrator
     */
    public function __construct(
        $userProfileMapper,
        $profileService,
        $oauth2Server,
        $oauth2Request,
        $userProfileHydrator
    ) {
        $this->userProfileMapper = $userProfileMapper;
        $this->profileService = $profileService;
        $this->oauth2Server = $oauth2Server;
        $this->oauth2Request = $oauth2Request;
        $this->userProfileHydrator = $userProfileHydrator;
    }

    /**
     * @return mixed
     */
    public function userSignatureAction()
    {

        $userProfile = $this->fetchUserProfile();
        $input = $this->getInputFilter()->getValues();
        if (!is_null($input['signature']) &&  $input['signature'] != '') {
            $input['signature'] = $input['signature']['tmp_name'];
            $signature = str_replace("data", "signature", $input);

            $userProfile->setSignature($signature);
            // var_dump($userProfile->getSignature());
            $userProfile = $this->userProfileHydrator->hydrate($input, $userProfile);
            $userProfile->setUpdatedAt(new \DateTime('now'));
        }
        try {
            $this->getUserProfileMapper()->save($userProfile);
            return $this->userProfileHydrator->extract($userProfile);
        } catch (RuntimeException $ex) {
            return new ApiProblemResponse(new ApiProblem(500, $ex->getMessage()));
        }
        exit;
    }
}
