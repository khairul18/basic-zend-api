<?php
namespace QRCode\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class QRCodeEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $fileConfig     = $config['project']['files'];
        $qrCodeMapper   = $container->get(\QRCode\Mapper\QRCode::class);
        $accountMapper  = $container->get(\User\Mapper\Account::class);
        $qrCodeHydrator = $container->get('HydratorManager')->get('QRCode\\Hydrator\\QRCode');
        $qrCodeEventListener = new QRCodeEventListener($qrCodeMapper, $accountMapper);
        $qrCodeEventListener->setQRCodeHydrator($qrCodeHydrator);
        $qrCodeEventListener->setLogger($container->get("logger_default"));
        $qrCodeEventListener->setConfig($fileConfig);
        return $qrCodeEventListener;
    }
}
