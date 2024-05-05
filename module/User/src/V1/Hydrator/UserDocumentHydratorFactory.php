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
class UserDocumentHydratorFactory implements FactoryInterface
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
        $hydrator->addStrategy('user', new Strategy\UserProfileObjectStrategy);
        $hydrator->addStrategy('path', new Strategy\DocUrlStrategy($url));
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
