<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class TaxCategoryEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $taxCategoryMapper = $container->get(\User\Mapper\TaxCategory::class);
        $taxCategoryHydrator = $container->get('HydratorManager')->get('User\Hydrator\TaxCategory');
        $taxCategoryEventListener = new TaxCategoryEventListener(
            $taxCategoryMapper,
            $accountMapper
        );
        $taxCategoryEventListener->setLogger($container->get("logger_default"));
        $taxCategoryEventListener->setTaxCategoryHydrator($taxCategoryHydrator);
        return $taxCategoryEventListener;
    }
}
