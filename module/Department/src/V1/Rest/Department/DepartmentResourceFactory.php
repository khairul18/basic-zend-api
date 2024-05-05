<?php
namespace Department\V1\Rest\Department;

class DepartmentResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $departmentMapper  = $services->get(\Department\Mapper\Department::class);
        $userAccessMapper  = $services->get(\User\Mapper\UserAccess::class);
        $departmentService = $services->get(\Department\V1\Service\Department::class);
        $resource = new DepartmentResource(
            $userProfileMapper,
            $departmentMapper,
            $userAccessMapper
        );
        $resource->setDepartmentService($departmentService);
        return $resource;
    }
}
