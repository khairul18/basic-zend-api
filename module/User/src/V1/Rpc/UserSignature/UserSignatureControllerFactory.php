<?php

namespace User\V1\Rpc\UserSignature;

use OAuth2\Request as OAuth2Request;

class UserSignatureControllerFactory
{
    public function __invoke($controllers)
    {
        $userProfileMapper = $controllers->get(\User\Mapper\UserProfile::class);
        $profileService = $controllers->get(\User\V1\Service\Profile::class);
        $oauth2Server = $controllers->get('ZF\OAuth2\Service\OAuth2Server');
        $oauth2Request = OAuth2Request::createFromGlobals();
        $userProfileHydrator = $controllers->get('HydratorManager')->get('User\Hydrator\UserProfile');


        $controller = new UserSignatureController(
            $userProfileMapper,
            $profileService,
            $oauth2Server(),
            $oauth2Request,
            $userProfileHydrator
        );

        return $controller;
    }
}
