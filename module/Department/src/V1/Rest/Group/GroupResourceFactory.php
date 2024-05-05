<?php
namespace Department\V1\Rest\Group;

class GroupResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $groupMapper  = $services->get(\Department\Mapper\Group::class);
        $groupService = $services->get(\Department\V1\Service\Group::class);
        $resource = new GroupResource(
            $userProfileMapper,
            $groupMapper
        );
        $resource->setGroupService($groupService);
        return $resource;
    }
}
