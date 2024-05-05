<?php
namespace QRCode\V1\Rpc\GenerateQRCode;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Hal\View\HalJsonModel;
use Zend\Mvc\Controller\AbstractActionController;
use QRCode\Mapper\QRCode as QRCodeMapper;
use QRCode\Mapper\QRCodeTrait as QRCodeMapperTrait;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;
use Zend\Paginator\Paginator as ZendPaginator;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserProfile as UserProfileMapper;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class GenerateQRCodeController extends AbstractActionController
{
    use QRCodeMapperTrait;
    use UserAccessMapperTrait;

    protected $qrCodeService;

    public function __construct(QRCodeMapper $qrCodeMapper, $userProfile)
    {
        $this->setQRCodeMapper($qrCodeMapper);
        $this->userProfile = $userProfile;
    }

    public function generateQRCodeAction()
    {
        $userProfile = $this->userProfile;
        if ($userProfile === null) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $userProfileUuid = $userProfile->getUuid();
        $queryParamUserAccess = [
            'userProfile' => $userProfileUuid
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (! is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role !== \User\V1\Role::ADMIN) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        try {
            $event  = $this->getEvent();
            $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');
            $units = $inputFilter->getValues()['units'];
            $userProfile = $this->userProfile;
            $qrCode = $this->getQRCodeService()->createMassQRCode($userProfile, $units);
            return new HalJsonModel([]);
        } catch (\RuntimeException $e) {
            return new ApiProblem(500, 'Cannot create QR Code');
        }
    }

    /**
     * Get the value of qrCodeService
     */
    public function getQrCodeService()
    {
        return $this->qrCodeService;
    }

    /**
     * Set the value of qrCodeService
     *
     * @return  self
     */
    public function setQrCodeService($qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;

        return $this;
    }
}
