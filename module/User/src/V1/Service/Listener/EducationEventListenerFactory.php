<?php
namespace User\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class EducationEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accountMapper = $container->get(\User\Mapper\Account::class);
        $educationMapper = $container->get(\User\Mapper\Education::class);
        $educationHydrator = $container->get('HydratorManager')->get('User\Hydrator\Education');
        $educationEventListener = new EducationEventListener(
            $educationMapper,
            $accountMapper
        );
        $educationEventListener->setLogger($container->get("logger_default"));
        $educationEventListener->setEducationHydrator($educationHydrator);
        return $educationEventListener;
    }
}
