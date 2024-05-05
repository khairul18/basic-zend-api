<?php
namespace User\V1\Rest\UserAcl;

class UserAclResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $userAclMapper  = $services->get(\User\Mapper\UserAcl::class);
        $userAclService = $services->get(\User\V1\Service\UserAcl::class);
        $resource = new UserAclResource(
            $userProfileMapper,
            $userAclMapper
        );
        $resource->setUserAclService($userAclService);
        return $resource;
    }
}
