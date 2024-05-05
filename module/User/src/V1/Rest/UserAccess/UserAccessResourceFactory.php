<?php
namespace User\V1\Rest\UserAccess;

class UserAccessResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $userRoleMapper = $services->get(\User\Mapper\UserRole::class);
        $userAccessMapper = $services->get(\User\Mapper\UserAccess::class);
        $userAccessService = $services->get(\User\V1\Service\UserAccess::class);
        $resource = new UserAccessResource(
            $userProfileMapper,
            $userRoleMapper,
            $userAccessMapper
        );
        $resource->setUserAccessService($userAccessService);
        return $resource;
    }
}
