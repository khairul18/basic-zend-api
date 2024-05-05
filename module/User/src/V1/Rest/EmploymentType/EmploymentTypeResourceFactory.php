<?php
namespace User\V1\Rest\EmploymentType;

class EmploymentTypeResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $employmentTypeMapper  = $services->get(\User\Mapper\EmploymentType::class);
        $employmentTypeService = $services->get(\User\V1\Service\EmploymentType::class);
        $resource = new EmploymentTypeResource(
            $userProfileMapper,
            $employmentTypeMapper
        );
        $resource->setEmploymentTypeService($employmentTypeService);
        return $resource;
    }
}
