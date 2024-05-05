<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class BankAccountEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $bankAccountMapper = $container->get(\User\Mapper\BankAccount::class);
        $bankAccountHydrator = $container->get('HydratorManager')->get('User\Hydrator\BankAccount');
        $bankAccountEventListener = new BankAccountEventListener(
            $bankAccountMapper,
            $accountMapper
        );
        $bankAccountEventListener->setLogger($container->get("logger_default"));
        $bankAccountEventListener->setBankAccountHydrator($bankAccountHydrator);
        return $bankAccountEventListener;
    }
}
