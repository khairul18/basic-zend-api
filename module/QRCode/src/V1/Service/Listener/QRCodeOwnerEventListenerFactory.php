<?php
namespace QRCode\V1\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class QRCodeOwnerEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $fileConfig = $config['project']['files'];
        $qrCodeOwnerMapper = $container->get('QRCode\Mapper\QRCodeOwner');
        $qrCodeOwnerHydrator = $container->get('HydratorManager')->get('QRCode\\Hydrator\\QRCodeOwner');
        $qRCodeOwnerTypeMapper = $container -> get(\QRCode\Mapper\QRCodeOwnerType::class);
        $qRCodeMapper = $container -> get(\QRCode\Mapper\QRCode::class);
        $qRCodeHydrator = $container -> get('HydratorManager') ->get('QRCode\Hydrator\QRCode');
        $qrCodeOwnerEventListener = new QRCodeOwnerEventListener($qrCodeOwnerMapper, $qRCodeOwnerTypeMapper, $qRCodeMapper);
        $qrCodeOwnerEventListener->setQRCodeOwnerHydrator($qrCodeOwnerHydrator);
        $qrCodeOwnerEventListener->setQRCodeHydrator($qRCodeHydrator);
        $qrCodeOwnerEventListener->setConfig($fileConfig);
        $qrCodeOwnerEventListener->setLogger($container->get("logger_default"));
        return $qrCodeOwnerEventListener;
    }
}
