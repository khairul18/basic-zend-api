<?php
namespace User\V1\Rest\Education;

class EducationResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $educationMapper  = $services->get(\User\Mapper\Education::class);
        $educationService = $services->get(\User\V1\Service\Education::class);
        $resource = new EducationResource(
            $userProfileMapper,
            $educationMapper
        );
        $resource->setEducationService($educationService);
        return $resource;
    }
}
