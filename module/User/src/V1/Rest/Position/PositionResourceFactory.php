<?php
namespace User\V1\Rest\Position;

class PositionResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $positionMapper  = $services->get(\User\Mapper\Position::class);
        $positionService = $services->get(\User\V1\Service\Position::class);
        $resource = new PositionResource(
            $userProfileMapper,
            $positionMapper
        );
        $resource->setPositionService($positionService);
        return $resource;
    }
}
