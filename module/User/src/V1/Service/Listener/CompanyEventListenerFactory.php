<?php

namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class CompanyEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project'];
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $companyMapper = $container->get(\User\Mapper\Company::class);
        $branchMapper = $container->get(\User\Mapper\Branch::class);
        $departmentMapper = $container->get(\User\Mapper\Department::class);
        $userProfileMapper = $container->get(\User\Mapper\UserProfile::class);
        $userProfileHydrator = $container->get('HydratorManager')->get('User\Hydrator\UserProfile');
        $companyHydrator = $container->get('HydratorManager')->get('User\Hydrator\Company');
        $branchHydrator = $container->get('HydratorManager')->get('User\Hydrator\Branch');
        $departmentHydrator = $container->get('HydratorManager')->get('User\Hydrator\Department');
        $companyEventListener = new CompanyEventListener(
            $companyMapper,
            $branchMapper,
            $departmentMapper,
            $accountMapper,
            $userProfileMapper
        );
        $companyEventListener->setLogger($container->get("logger_default"));
        $companyEventListener->setCompanyHydrator($companyHydrator);
        $companyEventListener->setBranchHydrator($branchHydrator);
        $companyEventListener->setDepartmentHydrator($departmentHydrator);
        $companyEventListener->setUserProfileHydrator($userProfileHydrator);
        $companyEventListener->setFileConfig($fileConfig);
        return $companyEventListener;
    }
}
