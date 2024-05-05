<?php

namespace User\V1\Rest\Company;

class CompanyResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $companyMapper  = $services->get(\User\Mapper\Company::class);
        $companyService = $services->get(\User\V1\Service\Company::class);
        $resource = new CompanyResource(
            $userProfileMapper,
            $companyMapper
        );
        $resource->setCompanyService($companyService);
        return $resource;
    }
}
