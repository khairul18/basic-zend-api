<?php
namespace User\V1\Rest\UserModule;

class UserModuleResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $userModuleMapper  = $services->get(\User\Mapper\UserModule::class);
        $userModuleService = $services->get(\User\V1\Service\UserModule::class);
        $resource = new UserModuleResource(
            $userProfileMapper,
            $userModuleMapper
        );
        $resource->setUserModuleService($userModuleService);
        return $resource;
    }
}
