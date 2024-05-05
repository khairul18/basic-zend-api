<?php
namespace Department\V1\Rest\Company;

class CompanyResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $companyMapper  = $services->get(\Department\Mapper\Company::class);
        $companyService = $services->get(\Department\V1\Service\Company::class);
        $resource = new CompanyResource(
            $userProfileMapper,
            $companyMapper
        );
        $resource->setCompanyService($companyService);
        return $resource;
    }
}
