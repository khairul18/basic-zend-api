<?php
namespace Xtend\Export\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class CsvExportFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $csvService = new CsvExport;
        return $csvService;
    }
}
