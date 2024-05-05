<?php
namespace Xtend\GoSms\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * PhpProcess Builder Factory
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class PhpProcessFactory implements FactoryInterface
{
    /**
     * Create service for PHP Process
     *
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\Factory\FactoryInterface::__invoke()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['sms']['notification']['sender']['php_process'];
        $builder = new ProcessBuilder();
        $builder->setPrefix([$config['php_binary'], $config['script']]);
        return $builder;
    }
}
