<?php

namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class QuotationEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requstedName, array $options = null)
    {
        $fileConfig  = $container->get('Config')['project'];
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $quotationMapper = $container->get(\User\Mapper\Quotation::class);
        $quotationItemMapper = $container->get(\Item\Mapper\QuotationItem::class);
        $quotationHistoryStatusMapper = $container->get(\Item\Mapper\QuotationHistoryStatus::class);
        $termConditionMapper = $container->get(\Item\Mapper\TermCondition::class);
        $itemListMapper = $container->get(\Item\Mapper\ItemList::class);
        $customerMapper = $container->get(\User\Mapper\Customer::class);
        $taxValueMapper = $container->get(\User\Mapper\TaxValue::class);
        $quotationHydrator = $container->get('HydratorManager')->get('User\Hydrator\Quotation');
        $termConditionHydrator = $container->get('HydratorManager')->get('Item\Hydrator\TermCondition');

        $quotationEventListener = new QuotationEventListener(
            $quotationMapper,
            $quotationItemMapper,
            $accountMapper,
            $itemListMapper,
            $customerMapper,
            $taxValueMapper,
            $quotationHistoryStatusMapper,
            $termConditionMapper
        );
        $quotationEventListener->setLogger($container->get("logger_default"));
        $quotationEventListener->setQuotationHydrator($quotationHydrator);
        $quotationEventListener->setTermConditionHydrator($termConditionHydrator);
        $quotationEventListener->setFileConfig($fileConfig);
        return $quotationEventListener;
    }
}
