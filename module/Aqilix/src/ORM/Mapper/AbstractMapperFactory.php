<?php
namespace Aqilix\ORM\Mapper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Abstract Mapper Factory
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class AbstractMapperFactory implements AbstractFactoryInterface
{
    /**
     * @var array
     */
    protected $mappers = [];

    /**
     * @var string
     */
    protected $mapperPrefix = 'Aqilix\\ORM\\Mapper\\';

    /**
     * Authorize can create.
     *
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  string  $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (strpos($requestedName, $this->mapperPrefix) !== false) {
            return true;
        }

        return false;
    }

    /**
     * Authorize can create service with name.
     *
     * @param  \Zend\ServiceManager\ServiceLocatorInterface  $services
     * @param  string  $name
     * @param  string  $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        return $this->canCreate($services, $requestedName);
    }

    /**
     * Invoke the class.
     *
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  string  $requestedName
     * @param  array  $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (isset($this->mappers[$requestedName])) {
            return $this->mappers[$requestedName];
        }

        $className = '\\' . ucfirst($requestedName);
        $mapper = new $className;
        $mapper->setEntityManager($container->get('doctrine.entitymanager.orm_default'));
        $this->mappers[$requestedName] = $mapper;
        return $mapper;
    }

    /**
     * Create service with name.
     *
     * @param  \Zend\ServiceManager\ServiceLocatorInterface  $services
     * @param  string  $name
     * @param  string  $requestedName
     * @return object
     */
    public function createServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        return $this($services, $requestedName);
    }
}
