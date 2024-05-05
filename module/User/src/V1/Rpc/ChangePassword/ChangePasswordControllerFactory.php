<?php
namespace User\V1\Rpc\ChangePassword;

class ChangePasswordControllerFactory
{
    public function __invoke($controllers)
    {
        $authentication = $controllers->get('authentication');
        $username     = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfile = $controllers->get('User\Mapper\UserProfile')->fetchOneBy(['username' => $username]);
        $newPasswordValidator = $controllers->get('InputFilterManager')->get('User\\V1\\Rpc\\ChangePassword\\Validator');
        $changePasswordService  = $controllers->get('user.changepassword');
        return new ChangePasswordController($newPasswordValidator, $changePasswordService, $userProfile);
    }
}
