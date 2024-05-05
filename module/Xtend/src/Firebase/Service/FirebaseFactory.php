<?php
namespace Xtend\Firebase\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class FirebaseFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $firebaseService = new Firebase;
        return $firebaseService;
    }
}
