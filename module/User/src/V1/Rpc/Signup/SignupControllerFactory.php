<?php
namespace User\V1\Rpc\Signup;

class SignupControllerFactory
{
    public function __invoke($controllers)
    {
        $authentication = $controllers->get('authentication');
        $username  = $authentication->getIdentity()->getAuthenticationIdentity()['user_id'];
        $userProfileMapper = $controllers->get('User\Mapper\UserProfile');
        $loggedInUser = $userProfileMapper->fetchOneBy(['username' => $username]);
        $signupValidator = $controllers->get('InputFilterManager')->get('User\\V1\\Rpc\\Signup\\Validator');
        $signup = $controllers->get('user.signup');
        return new SignupController($loggedInUser, $signup, $signupValidator, $userProfileMapper);
    }
}
