<?php
namespace User\V1\Rpc\ChangePassword;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Json;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\View\HalJsonModel;

class ChangePasswordController extends AbstractActionController
{
    protected $userProfile;
    protected $confirmPasswordValidator;
    protected $changePasswordService;

    public function __construct($confirmPasswordValidator, $changePasswordService, $userProfile)
    {
        $this->setConfirmPasswordValidator($confirmPasswordValidator);
        $this->setChangePasswordService($changePasswordService);
        $this->userProfile = $userProfile;
    }

    public function changePasswordAction()
    {
        $userProfile = $this->userProfile;
        $this->getConfirmPasswordValidator()->setData(Json::decode($this->getRequest()->getContent(), true));
        try {
            $this->getConfirmPasswordValidator()->add(['name'  => 'username']);
            $this->getConfirmPasswordValidator()->get('username')->setValue($userProfile->getUsername()->getUsername());
            $changeData = $this->getConfirmPasswordValidator()->getValues();
            $changePassword = $this->getChangePasswordService()
                                   ->change($changeData, $userProfile);
            return $this->getResponse()->setStatusCode(\Zend\Http\Response::STATUS_CODE_204);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(
                422,
                "Failed Validation",
                null,
                null,
                ['validation_messages' => ['Check Your Password' => [$e->getMessage()]]]
            ));
        }
    }

    /**
     * @return the $confirmPasswordValidator
     */
    public function getConfirmPasswordValidator()
    {
        return $this->confirmPasswordValidator;
    }

    /**
     * @param field_type $confirmPasswordValidator
     */
    public function setConfirmPasswordValidator($confirmPasswordValidator)
    {
        $this->confirmPasswordValidator = $confirmPasswordValidator;
    }

    /**
     * @return the $changePasswordService
     */
    public function getChangePasswordService()
    {
        return $this->changePasswordService;
    }

    /**
     * @param field_type $changePasswordService
     */
    public function setChangePasswordService($changePasswordService)
    {
        $this->changePasswordService = $changePasswordService;
    }
}
