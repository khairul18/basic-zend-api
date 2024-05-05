<?php
namespace QRCode\V1\Rpc\QRCodeValidator;

use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use Zend\Mvc\Controller\AbstractActionController;
use QRCode\Mapper\QRCodeTrait as QRCodeMapperTrait;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use User\V1\Role as Role;

class QRCodeValidatorController extends AbstractActionController
{
    use QRCodeMapperTrait;
    use UserProfileMapperTrait;

    /**
     * @var User\Entity\UserProfile
     */
    protected $userProfile;

    /**
     * @var Zend\InputFilter\InputFilter
     */
    protected $uuidValidator;

    public function __construct(
        \QRCode\Mapper\QRCode $qrCodeMapper,
        $userProfile,
        \User\Mapper\UserProfile $userProfileMapper
    ) {
        $this->setQRCodeMapper($qrCodeMapper);
        $this->userProfile = $userProfile;
        $this->setUserProfileMapper($userProfileMapper);
    }

    public function qRCodeValidatorAction()
    {
        $event = $this->getEvent();
        $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');
        $value = $inputFilter->getValues()['qrCode'];

        $qrCOdeObj = $this->getQRCodeMapper()->fetchOneBy(['value' => $value]);
        if (is_null($qrCOdeObj)) {
            return new ApiProblemResponse(new ApiProblem(404, "QRCode data not found!"));
        }

        $customerUuid = $qrCOdeObj->getCustomer();
        if (is_null($customerUuid)) {
            return new ApiProblemResponse(new ApiProblem(404, "QRCode not yet used has no data"));
        }

        $customerObj = $this->getCustomerMapper()->fetchOneBy(['uuid' => $customerUuid]);
        if (is_null($customerObj)) {
            return new ApiProblemResponse(new ApiProblem(404, "Customer data not found!"));
        }

        $response = [
            "customerId" => $customerObj->getCustomerId(),
            "businessSector" => ! is_null($customerObj->getBusinessSector()) ? $customerObj->getBusinessSector()->getName() : '-',
            "marketSegment" => $customerObj->getMarketSegment(),
            "type" => $customerObj->getType(),
            "name" => $customerObj->getName(),
            "gender" => $customerObj->getGender(),
            "status" => $customerObj->getStatus(),
            "phone" => $customerObj->getPhone(),
            "fax" => $customerObj->getFax(),
            "website" => $customerObj->getWebsite(),
            "email" => $customerObj->getEmail(),
            "address" => $customerObj->getAddress(),
            "city" => $customerObj->getCity(),
            "state" => $customerObj->getState(),
            "postalCode" => $customerObj->getPostalCode(),
            "taxId" => $customerObj->getTaxId(),
            "taxCategory" => ! is_null($customerObj->getTaxCategory()) ? $customerObj->getTaxCategory()->getName() : '-',
            "picName" => $customerObj->getPicName(),
            "division" => ! is_null($customerObj->getDivisionCustomer()) ? $customerObj->getDivisionCustomer()->getName() : '-',
            "position" => ! is_null($customerObj->getPositionCustomer()) ? $customerObj->getPositionCustomer()->getName() : '-',
            "workphone" => $customerObj->getWorkphone(),
            "workemail" => $customerObj->getWorkemail(),
            "whatsapp" => $customerObj->getWhatsapp(),
            "description" => $customerObj->getDescription(),
            "uuid" => $customerObj->getUuid(),
            "company" => [
                "uuid" => '-',
                "name" => '-'
            ],
            "branch" => [
                "uuid" => '-',
                "name" => '-'
            ]
        ];

        return new HalJsonModel($response);
    }
}
