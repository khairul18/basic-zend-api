<?php
namespace QRCode\V1\Rest\QRCode;

class QRCodeResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get('User\Mapper\UserProfile');
        $qRCodeMapper   = $services->get(\QRCode\Mapper\QRCode::class);
        $userAccessMapper   = $services->get(\User\Mapper\UserAccess::class);
        $qRCodeService  = $services->get(\QRCode\V1\Service\QRCode::class);
        $qrCodeResource = new QRCodeResource(
            $qRCodeMapper, 
            $userProfileMapper,
            $userAccessMapper
        );
        $qrCodeResource->setQrCodeService($qRCodeService);
        return $qrCodeResource;
    }
}
