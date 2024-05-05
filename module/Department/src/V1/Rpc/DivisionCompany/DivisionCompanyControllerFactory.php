<?php

namespace Department\V1\Rpc\DivisionCompany;

class DivisionCompanyControllerFactory
{
    public function __invoke($controllers)
    {
        $companyService  = $controllers->get(\Department\V1\Service\Company::class);
        $branchService  = $controllers->get(\User\V1\Service\Branch::class);
        $departmentService  = $controllers->get(\Department\V1\Service\Department::class);
        $companyMapper   = $controllers->get(\Department\Mapper\Company::class);
        $branchMapper   = $controllers->get(\User\Mapper\Branch::class);
        $departmentMapper   = $controllers->get(\Department\Mapper\Department::class);

        $userProfileMapper   = $controllers->get(\User\Mapper\UserProfile::class);
        $userAccessMapper   = $controllers->get(\User\Mapper\UserAccess::class);
        $authentication = $controllers->get('authentication');
        $username    = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $userProfileMapper->fetchOneBy(['username' => $username]);
        return new DivisionCompanyController(
            $companyService,
            $companyMapper,
            $branchService,
            $branchMapper,
            $departmentService,
            $departmentMapper,
            $userProfile,
            $userProfileMapper,
            $userAccessMapper
        );
    }
}
