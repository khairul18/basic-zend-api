<?php
namespace QRCode\V1\Rpc\QRCodeValidator;

class QRCodeValidatorControllerFactory
{
    public function __invoke($controllers)
    {
        $qrCodeMapper   = $controllers->get(\QRCode\Mapper\QRCode::class);
        $userProfileMapper   = $controllers->get(\User\Mapper\UserProfile::class);
        $authentication = $controllers->get('authentication');
        $username    = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $userProfileMapper->fetchOneBy(['username' => $username]);
        return new QRCodeValidatorController(
            $qrCodeMapper,
            $userProfile,
            $userProfileMapper
        );
    }
}
