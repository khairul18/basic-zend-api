<?php

namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class CustomerEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project']['files'];
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $customerMapper = $container->get(\User\Mapper\Customer::class);
        $customerCompanyMapper = $container->get(\User\Mapper\CustomerCompany::class);
        $companyMapper = $container->get(\User\Mapper\Company::class);
        $branchMapper = $container->get(\User\Mapper\Branch::class);
        $qrCodeMapper   = $container->get(\QRCode\Mapper\QRCode::class);
        $customerHydrator = $container->get('HydratorManager')->get('User\Hydrator\Customer');
        $qrCodeHydrator = $container->get('HydratorManager')->get('QRCode\\Hydrator\\QRCode');
        $customerEventListener = new CustomerEventListener(
            $customerMapper,
            $accountMapper,
            $qrCodeMapper,
            $customerCompanyMapper,
            $companyMapper,
            $branchMapper
        );
        $customerEventListener->setLogger($container->get("logger_default"));
        $customerEventListener->setConfig($fileConfig);
        $customerEventListener->setCustomerHydrator($customerHydrator);
        $customerEventListener->setQrCodeHydrator($qrCodeHydrator);
        return $customerEventListener;
    }
}
