<?php

namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\CompanyTrait as CompanyMapperTrait;
use User\Mapper\BranchTrait as BranchMapperTrait;
use QRCode\Mapper\QRCodeTrait as QrCodeMapperTrait;
use User\Entity\Customer as CustomerEntity;
use QRCode\Entity\QRCode as QrCodeEntity;
use User\Entity\CustomerCompany as CustomerCompanyEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\CustomerEvent;
use Zend\Log\Exception\RuntimeException;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use Doctrine\Common\Collections\ArrayCollection;

class CustomerEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use AccountMapperTrait;
    use QrCodeMapperTrait;
    use CompanyMapperTrait;
    use BranchMapperTrait;

    protected $config;
    protected $customerEvent;
    protected $customerHydrator;
    protected $qrCodeHydrator;

    public function __construct(
        \User\Mapper\Account $accountMapper,
        \QRCode\Mapper\QRCode $qrCodeMapper,
        \User\Mapper\Company $companyMapper,
        \User\Mapper\Branch $branchMapper
    ) {
        $this->setAccountMapper($accountMapper);
        $this->setQRCodeMapper($qrCodeMapper);
        $this->setCompanyMapper($companyMapper);
        $this->setBranchMapper($branchMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        // $this->listeners[] = $events->attach(
        //     CustomerEvent::EVENT_CREATE_CUSTOMER,
        //     [$this, 'createCustomer'],
        //     500
        // );

        // $this->listeners[] = $events->attach(
        //     CustomerEvent::EVENT_CREATE_CUSTOMER,
        //     [$this, 'saveOptionFields'],
        //     499
        // );

        $this->listeners[] = $events->attach(
            CustomerEvent::EVENT_CREATE_CUSTOMER_SUCCESS,
            [$this, 'createQRCode'],
            500
        );

        $this->listeners[] = $events->attach(
            CustomerEvent::EVENT_UPDATE_CUSTOMER,
            [$this, 'updateCustomer'],
            500
        );

        // $this->listeners[] = $events->attach(
        //     CustomerEvent::EVENT_UPDATE_CUSTOMER,
        //     [$this, 'updateOptionFields'],
        //     499
        // );

        $this->listeners[] = $events->attach(
            CustomerEvent::EVENT_DELETE_CUSTOMER,
            [$this, 'deleteCustomer'],
            500
        );
    }

    public function createCustomer(CustomerEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $customerEntity = new CustomerEntity;
            // unset($bodyRequest['customerCompany']);
            // unset($bodyRequest['socialMedia']);
            $socialMediaArr = $event->$bodyRequest['socialMedia'];
            $socialMediaStr = implode('|', $socialMediaArr);
            $bodyRequest['socialMedia']->$socialMediaStr;
            $hydrateEntity  = $this->getCustomerHydrator()->hydrate($bodyRequest, $customerEntity);
            $entityResult   = $this->getCustomerMapper()->save($hydrateEntity);
            $event->setCustomerEntity($entityResult);
            $uuid = $entityResult->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Customer {uuid} created successfully",
                [
                    "function" => __FUNCTION__,
                    "uuid" => $uuid
                ]
            );
        } catch (RuntimeException $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something Error! \nError_message: {message}",
                [
                    "message" => $e->getMessage(),
                    "function" => __FUNCTION__
                ]
            );
            return $e;
        }
    }

    // public function saveOptionFields(CustomerEvent $event)
    // {
    //     try {
    //         $bodyRequest = $event->getInputFilter()->getValues();
    //         $customerEntity = $event->getCustomerEntity();
    //         // $customerUuid = $customerEntity->getUuid();
    //         $optionFields = $event->getOptionFields();
    //         $this->logger->log(
    //             \Psr\Log\LogLevel::DEBUG,
    //             "{function}: (CustomerCompany SaveOptFields) data : {data}",
    //             [
    //                 "function" => __FUNCTION__,
    //                 "data" => json_encode($optionFields)
    //             ]
    //         );
    //         foreach ($optionFields as $option) {
    //             $companyUuid = $option->companyId;
    //             $branchUuid = $option->branchId;

    //             $companyEntity = $this->getCompanyMapper()->fetchOneBy([
    //                 'uuid' => $companyUuid
    //             ]);

    //             $branchEntity = $this->getBranchMapper()->fetchOneBy([
    //                 'uuid' => $branchUuid
    //             ]);
    //             // we can do checking if wont store same/ redudant data to tables

    //             $customerCompanyEntity = new CustomerCompanyEntity;
    //             $customerCompanyEntity->setCompany($companyEntity);
    //             $customerCompanyEntity->setBranch($branchEntity);
    //             $customerCompanyEntity->setCustomer($customerEntity);

    //             $saveOptionFields = $this->getCustomerCompanyMapper()->save($customerCompanyEntity);
    //             $optArray[] = $saveOptionFields;

    //             $this->logger->log(
    //                 \Psr\Log\LogLevel::INFO,
    //                 "{function}: (Customer Company) Fields uuid saved => {uuid}",
    //                 [
    //                     "function" => __FUNCTION__,
    //                     "uuid" => $saveOptionFields->getUuid()
    //                 ]
    //             );
    //         }

    //         if (!is_null($optArray) || count($optArray) > 0) {
    //             $optArrayCollection = new ArrayCollection($optArray);
    //             $customerEntity->setCustomerCompany($optArrayCollection);
    //             $this->getCustomerMapper()->save($customerEntity);
    //         }
    //     } catch (RuntimeException $e) {
    //         $event->stopPropagation(true);
    //         $this->logger->log(
    //             \Psr\Log\LogLevel::ERROR,
    //             "{function} : Something Error! \nError_message: {message}",
    //             [
    //                 "message" => $e->getMessage(),
    //                 "function" => __FUNCTION__
    //             ]
    //         );
    //         return $e;
    //     }
    // }

    /**
     * Update Customer
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateCustomer(CustomerEvent $event)
    {
        try {
            $customerEntity = $event->getCustomerEntity();
            $customerEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();

            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            // unset($updateData['customerCompany']);
            // unset($updateData['socialMedia']);
            $socialMediaArr = $event->$updateData['socialMedia'];
            $socialMediaStr = implode('|', $socialMediaArr);
            $updateData['socialMedia'] = $socialMediaStr;

            $hydrateEntity = $this->getCustomerHydrator()->hydrate($updateData, $customerEntity);
            $entityResult  = $this->getCustomerMapper()->save($hydrateEntity);
            $uuid = $entityResult->getUuid();
            $event->setCustomerEntity($entityResult);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Customer {uuid} updated successfully",
                [
                    "function" => __FUNCTION__,
                    "uuid" => $uuid
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something Error! \nError_message: {message}",
                [
                    "message" => $e->getMessage(),
                    "function" => __FUNCTION__
                ]
            );
            return $e;
        }
    }

    // public function updateOptionFields(CustomerEvent $event)
    // {
    //     try {
    //         $bodyRequest = $event->getInputFilter()->getValues();
    //         $customerEntity = $event->getCustomerEntity();
    //         $optionFields = $event->getOptionFields();
    //         $counter = 0;
    //         foreach ($optionFields as $option) {
    //             $customerCompanyEntity  = $this->getCustomerCompanyMapper()->fetchOneBy([
    //                 'uuid' => $option->uuid
    //             ]);

    //             if (!is_null($customerCompanyEntity)) {
    //                 if ($option->delete == "1") {
    //                     $this->getCustomerCompanyMapper()->delete($customerCompanyEntity);
    //                     $uuid = $customerCompanyEntity->getUuid();

    //                     $this->logger->log(
    //                         \Psr\Log\LogLevel::INFO,
    //                         "{function} (DELETED) Customer Company: {uuid}: Data deleted successfully",
    //                         [
    //                             'uuid' => $uuid,
    //                             "function" => __FUNCTION__
    //                         ]
    //                     );
    //                     continue;
    //                 }
    //             } else {
    //                 $customerCompanyEntity = new CustomerCompanyEntity;
    //             }

    //             $companyUuid = $option->companyId;
    //             $branchUuid = $option->branchId;

    //             $companyEntity = $this->getCompanyMapper()->fetchOneBy([
    //                 'uuid' => $companyUuid
    //             ]);

    //             $branchEntity = $this->getBranchMapper()->fetchOneBy([
    //                 'uuid' => $branchUuid
    //             ]);

    //             $customerCompanyEntity->setCompany($companyEntity);
    //             $customerCompanyEntity->setBranch($branchEntity);
    //             $customerCompanyEntity->setCustomer($customerEntity);

    //             $saveOption = $this->getCustomerCompanyMapper()->save($customerCompanyEntity);
    //             $counter += 1;
    //             $optArray[] = $saveOption;

    //             $this->logger->log(
    //                 \Psr\Log\LogLevel::INFO,
    //                 "{function}: {uuid} Customer Company Fields updated successfully",
    //                 [
    //                     "function" => __FUNCTION__,
    //                     "uuid"  => $saveOption->getUuid()
    //                 ]
    //             );
    //         }
    //         // uncomment this for check the return of optArray
    //         if (!is_null($optArray) || count($optArray) > 0) {
    //             $optArrayCollection = new ArrayCollection($optArray);
    //             $customerEntity->setCustomerCompany($optArrayCollection);
    //             $this->getCustomerMapper()->save($customerEntity);
    //         }

    //         $this->logger->log(
    //             \Psr\Log\LogLevel::INFO,
    //             "{function}: {counter} Data Customer Company Fields updated",
    //             [
    //                 "function" => __FUNCTION__,
    //                 "counter"  => $counter
    //             ]
    //         );
    //     } catch (RuntimeException $e) {
    //         $event->stopPropagation(true);
    //         $this->logger->log(
    //             \Psr\Log\LogLevel::ERROR,
    //             "{function} : Something Error! \nError_message: {message}",
    //             [
    //                 "message" => $e->getMessage(),
    //                 "function" => __FUNCTION__
    //             ]
    //         );
    //         return $e;
    //     }
    // }

    public function deleteCustomer(CustomerEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this->getCustomerMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data Customer deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: " . $e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function createQRCode(CustomerEvent $event)
    {
        $customer  = $event->getCustomerEntity()->getuuid();
        //Lookup table qr_code
        $qrCodeObj = $this->getQRCodeMapper()->fetchOneBy([
            // 'account' => $account,
            'isAvailable' => '1'
        ]);
        if (!is_null($qrCodeObj)) {
            $qrCodeCollection = [
                "customer" => $customer,
                "isAvailable" => '0'
            ];
            $qrCodeData = $this->getQrCodeHydrator()->hydrate($qrCodeCollection, $qrCodeObj);
            $this->getQRCodeMapper()->save($qrCodeData);
        } else {
            try {
                $qrcodeResult = $this->QRCodeGenerator($customer);
                $event->setQrCodeEntity($qrcodeResult);
                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function} {message} {uuid} for customer: {customer} ",
                    [
                        "function" => __FUNCTION__,
                        "message"  => "QR Code Generated Successfully",
                        "customer"  => $customer,
                        'uuid' => $event->getQrCodeEntity()->getUuid()
                    ]
                );
            } catch (\Exception $e) {
                $this->logger->log(
                    \Psr\Log\LogLevel::ERROR,
                    "{function} {message} custome: {customer} ",
                    [
                        "function" => __FUNCTION__,
                        "message"  => $e->getMessage(),
                        "customer"  => $customer,
                    ]
                );
                $event->stopPropagation(true);
                return $e;
            }
        }
    }

    public function QRCodeGenerator($customer)
    {
        // available status
        // 1 -> already used by customer
        // 0 -> no one use the qrCode
        $qrCodeEntity = new QRCodeEntity;
        $qrCodeCollection = [];
        $stringQR  = bin2hex(random_bytes(10));
        $qrCodeCollection = [
            "value" => $stringQR,
            "customer" => $customer,
            "isAvailable" => '0'
        ];

        $qrCodeData = $this->getQrCodeHydrator()->hydrate($qrCodeCollection, $qrCodeEntity);
        $this->getQRCodeMapper()->save($qrCodeData);
        $qrcode = new BaconQrCodeGenerator;
        $path   = $this->getConfig()['img_dir'] . '/' . $qrCodeData->getuuid() . '.png';
        $newPath = str_replace('data/', '', $path);
        $qrCodeData->setPath($newPath);
        $qrcodeimg = $qrcode->format('png')->size(500)
            ->merge('data/logo/MyXtendLogo.png')
            ->errorCorrection('H')
            ->generate($stringQR, $path);

        $this->getQRCodeMapper()->save($qrCodeData);
        return $qrCodeData;
    }

    /**
     * Get the value of customerHydrator
     */
    public function getCustomerHydrator()
    {
        return $this->customerHydrator;
    }

    /**
     * Set the value of customerHydrator
     *
     * @return  self
     */
    public function setCustomerHydrator($customerHydrator)
    {
        $this->customerHydrator = $customerHydrator;

        return $this;
    }

    /**
     * Get the value of config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @return  self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the value of qrCodeHydrator
     */
    public function getQrCodeHydrator()
    {
        return $this->qrCodeHydrator;
    }

    /**
     * Set the value of qrCodeHydrator
     *
     * @return  self
     */
    public function setQrCodeHydrator($qrCodeHydrator)
    {
        $this->qrCodeHydrator = $qrCodeHydrator;

        return $this;
    }
}
