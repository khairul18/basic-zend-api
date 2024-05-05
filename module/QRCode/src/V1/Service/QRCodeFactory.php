<?php
namespace QRCode\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class QRCodeFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $qrCodeMapper = $container->get(\QRCode\Mapper\QRCode::class);
        $accountMapper  = $container->get(\User\Mapper\Account::class);
        $qrCodeService = new QRCode($qrCodeMapper, $accountMapper);
        $qrCodeService->setLogger($container->get("logger_default"));
        return $qrCodeService;
    }
}
