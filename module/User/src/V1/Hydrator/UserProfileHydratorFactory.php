<?php

namespace User\V1\Hydrator;

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
class UserProfileHydratorFactory implements FactoryInterface
{
    /**
     * Create a service for DoctrineObject Hydrator
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new \Zend\View\Helper\ServerUrl();
        $url = $helper->getScheme() . '://' . $helper->getHost();
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $hydrator = new DoctrineObject($entityManager);
        $hydrator->addStrategy('educations', new Strategy\EducationsStrategy);
        $hydrator->addStrategy('userDocument', new Strategy\DocStrategy($url));
        $hydrator->addStrategy('username', new Strategy\UsernameStrategy);
        $hydrator->addStrategy('position', new Strategy\PositionStrategy);
        $hydrator->addStrategy('parent', new Strategy\UserProfileObjectStrategy);
        $hydrator->addStrategy('employmentType', new Strategy\EmploymentTypeStrategy);
        $hydrator->addStrategy('department', new Strategy\DepartmentStrategy);
        $hydrator->addStrategy('drivingActivity', new Strategy\DrivingActivityStrategy);
        // $hydrator->addStrategy('jobActivity', new Strategy\JobActivityStrategy);
        $hydrator->addStrategy('company', new Strategy\CompanyStrategy);
        $hydrator->addStrategy('branch', new Strategy\BranchStrategy);
        $hydrator->addStrategy('account', new \User\V1\Hydrator\Strategy\AccountObjectStrategy);
        $hydrator->addStrategy('lastQuestionnaireAt', new DateTimeFormatterStrategy('Y-m-d'));
        $hydrator->addStrategy('dob', new DateTimeFormatterStrategy('Y-m-d'));
        $hydrator->addStrategy('firstDate', new DateTimeFormatterStrategy('Y-m-d'));
        $hydrator->addStrategy('createdAt', new DateTimeFormatterStrategy('c'));
        $hydrator->addStrategy('updatedAt', new DateTimeFormatterStrategy('c'));
        $hydrator->addStrategy('qrCode', new \User\V1\Hydrator\Strategy\QRCodeOwnerStrategy($url));
        $hydrator->addStrategy('signature', new Strategy\SignatureStrategy($url));

        // $hydrator->addStrategy('photo', $container->get('user.hydrator.photo.strategy'));
        $hydrator->addFilter('exclude', function ($property) {
            if (in_array($property, [
                'deletedAt',
                'userActivation',
                'exchangeId',
                'children',
                'notification',
                'facilityBooking',
                'complain',
                'visitor',
                'broadcastMessage',
                'complainResponse',
                'userActivatedLog',
                'securityCheckingStatusLog',
                'securityCheckingAuditLocation'
            ])) {
                return false;
            }

            return true;
        }, FilterComposite::CONDITION_AND);
        return $hydrator;
    }
}
