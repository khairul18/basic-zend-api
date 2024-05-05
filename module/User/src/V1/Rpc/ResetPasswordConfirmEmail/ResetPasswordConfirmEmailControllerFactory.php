<?php
namespace User\V1\Rpc\ResetPasswordConfirmEmail;

class ResetPasswordConfirmEmailControllerFactory
{
    public function __invoke($controllers)
    {
        $confirmEmailValidator = $controllers->get('InputFilterManager')
                                    ->get('User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Validator');
        $resetPasswordService  = $controllers->get('user.resetpassword');
        $userProfileMapper = $controllers->get(\User\Mapper\UserProfile::class);
        $controller = new ResetPasswordConfirmEmailController(
            $confirmEmailValidator,
            $userProfileMapper
        );
        $controller->setResetPasswordService($resetPasswordService);
        return $controller;
    }
}
