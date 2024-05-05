<?php
namespace Department\V1\Rest\GroupUser;

class GroupUserResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $groupUserMapper  = $services->get(\Department\Mapper\GroupUser::class);
        $groupUserService = $services->get(\Department\V1\Service\GroupUser::class);
        $resource = new GroupUserResource(
            $userProfileMapper,
            $groupUserMapper
        );
        $resource->setGroupUserService($groupUserService);
        return $resource;
    }
}