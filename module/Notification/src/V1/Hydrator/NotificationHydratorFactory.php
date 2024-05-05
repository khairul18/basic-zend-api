<?php
namespace Notification\V1\Hydrator;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Hydrator\Strategy\DateTimeFormatterStrategy;
use Zend\Hydrator\Filter\FilterComposite;

/**
 * Hydrator for Doctrine Entity
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class NotificationHydratorFactory implements FactoryInterface
{
    /**
     * Create a service for DoctrineObject Hydrator
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $hydrator = new DoctrineObject($entityManager);
        // $hydrator->addStrategy('pilgrim', new \User\V1\Hydrator\Strategy\PilgrimStrategy);
        // $hydrator->addStrategy('registrar', new \User\V1\Hydrator\Strategy\RegistrarStrategy);
        $hydrator->addStrategy('account', new \User\V1\Hydrator\Strategy\AccountStrategy);
        $hydrator->addStrategy('userProfile', new \User\V1\Hydrator\Strategy\UserProfileObjectStrategy);
        // $hydrator->addStrategy('vehicleRequest', new \Vehicle\V1\Hydrator\Strategy\VehicleRequestStrategy);
        // $hydrator->addStrategy('leave', new \Leave\V1\Hydrator\Strategy\LeaveStrategy);
        // $hydrator->addStrategy('purchaseRequisition', new \Item\V1\Hydrator\Strategy\PurchaseRequisitionStrategy);
        // $hydrator->addStrategy('overtime', new \Overtime\V1\Hydrator\Strategy\OvertimeStrategy);
        // $hydrator->addStrategy('reimburse', new \Reimbursement\V1\Hydrator\Strategy\ReimbursementStrategy);
        // $hydrator->addStrategy('salesOrder', new \Item\V1\Hydrator\Strategy\SalesOrderStrategy);
        $hydrator->addStrategy('createdAt', new DateTimeFormatterStrategy('c'));
        $hydrator->addStrategy('updatedAt', new DateTimeFormatterStrategy('c'));
        $hydrator->addFilter('exclude', function ($property) {
            if (in_array($property, ['deletedAt'])) {
                return false;
            }

            return true;
        }, FilterComposite::CONDITION_AND);
        return $hydrator;
    }
}
