<?php
namespace User\V1\Rest\BusinessSector;

class BusinessSectorResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $businessSectorMapper  = $services->get(\User\Mapper\BusinessSector::class);
        $businessSectorService = $services->get(\User\V1\Service\BusinessSector::class);
        $resource = new BusinessSectorResource(
            $userProfileMapper,
            $businessSectorMapper
        );
        $resource->setBusinessSectorService($businessSectorService);
        return $resource;
    }
}
