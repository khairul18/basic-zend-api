<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class TaxValueEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $taxValueMapper = $container->get(\User\Mapper\TaxValue::class);
        $taxValueHydrator = $container->get('HydratorManager')->get('User\Hydrator\TaxValue');
        $taxValueEventListener = new TaxValueEventListener(
            $taxValueMapper,
            $accountMapper
        );
        $taxValueEventListener->setLogger($container->get("logger_default"));
        $taxValueEventListener->setTaxValueHydrator($taxValueHydrator);
        return $taxValueEventListener;
    }
}
