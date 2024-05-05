<?php
namespace User\V1\Rest\UserRole;

class UserRoleResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $userRoleMapper  = $services->get(\User\Mapper\UserRole::class);
        $userRoleService = $services->get(\User\V1\Service\UserRole::class);
        $resource = new UserRoleResource(
            $userProfileMapper,
            $userRoleMapper
        );
        $resource->setUserRoleService($userRoleService);
        return $resource;
    }
}
