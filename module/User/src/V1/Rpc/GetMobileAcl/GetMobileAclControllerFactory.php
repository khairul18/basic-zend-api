<?php
namespace User\V1\Rpc\GetMobileAcl;

class GetMobileAclControllerFactory
{
    public function __invoke($controllers)
    {
        $userProfileMapper = $controllers->get(\User\Mapper\UserProfile::class);
        $hardcodedUtils = new MobileAclHardcoded();

        return new GetMobileAclController(
            $userProfileMapper,
            $hardcodedUtils
        );
    }
}
