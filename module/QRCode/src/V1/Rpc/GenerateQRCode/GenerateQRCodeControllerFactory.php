<?php
namespace QRCode\V1\Rpc\GenerateQRCode;

class GenerateQRCodeControllerFactory
{
    public function __invoke($controllers)
    {
        $qrCodeMapper   = $controllers->get(\QRCode\Mapper\QRCode::class);
        $userAccessMapper   = $controllers->get(\User\Mapper\UserAccess::class);
        $qrCodeService  = $controllers->get(\QRCode\V1\Service\QRCode::class);

        $authentication = $controllers->get('authentication');
        $username    = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        // var_dump($userProfile->getAccount()->getUuid());exit;

        $qrCodeResource = new GenerateQRCodeController($qrCodeMapper, $userProfile, $userAccessMapper);
        $qrCodeResource->setQrCodeService($qrCodeService);
        return $qrCodeResource;
    }
}
