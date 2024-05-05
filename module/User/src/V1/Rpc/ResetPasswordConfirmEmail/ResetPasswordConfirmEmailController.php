<?php
namespace User\V1\Rpc\ResetPasswordConfirmEmail;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Json;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\View\HalJsonModel;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;

class ResetPasswordConfirmEmailController extends AbstractActionController
{
    use UserProfileMapperTrait;

    protected $confirmEmailValidator;
    protected $resetPasswordService;

    public function __construct(
        $confirmEmailValidator,
        UserProfileMapper $userProfileMapper
    ) {

        $this->setConfirmEmailValidator($confirmEmailValidator);
        $this->setUserProfileMapper($userProfileMapper);
    }

    public function resetPasswordConfirmEmailAction()
    {
        try {
            $event  = $this->getEvent();
            $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');

            $resetPassword = $this->getResetPasswordService();
            $resetPassword->create($inputFilter->getValues());
            return $this->getResponse()->setStatusCode(\Zend\Http\Response::STATUS_CODE_204);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(
                422,
                "Failed Validation",
                null,
                null,
                ['validation_messages' => ['phone' => [$e->getMessage()]]]
            ));
        }
    }

    /**
     * @return $confirmEmailValidator
     */
    public function getConfirmEmailValidator()
    {
        return $this->confirmEmailValidator;
    }

    /**
     * @param field_type $confirmEmailValidator
     */
    public function setConfirmEmailValidator($confirmEmailValidator)
    {
        $this->confirmEmailValidator = $confirmEmailValidator;
    }

    /**
     * @return the $resetPasswordService
     */
    public function getResetPasswordService()
    {
        return $this->resetPasswordService;
    }

    /**
     * @param field_type $resetPasswordService
     */
    public function setResetPasswordService($resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }
}
