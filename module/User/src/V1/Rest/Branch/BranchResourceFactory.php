<?php

namespace User\V1\Rest\Branch;

class BranchResourceFactory
{
    public function __invoke($services)
    {
        $accountMapper = $services->get(\User\Mapper\Account::class);
        $userProfileMapper = $services->get(\User\Mapper\UserProfile::class);
        $branchMapper  = $services->get(\User\Mapper\Branch::class);
        $userAccessMapper  = $services->get(\User\Mapper\UserAccess::class);
        $branchService = $services->get(\User\V1\Service\Branch::class);
        $resource = new BranchResource($accountMapper, $branchMapper, $userProfileMapper, $userAccessMapper);
        $resource->setBranchService($branchService);
        return $resource;
    }
}
