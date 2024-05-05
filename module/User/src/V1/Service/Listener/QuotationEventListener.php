<?php

namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\QuotationTrait as QuotationMapperTrait;
use User\Entity\Quotation as QuotationEntity;
use Item\Mapper\QuotationItemTrait as QuotationItemMapperTrait;
use Item\Mapper\ItemListTrait as ItemListMapperTrait;
use User\Mapper\CustomerTrait as CustomerMapperTrait;
use User\Mapper\TaxValueTrait as TaxValueMapperTrait;
use Item\Entity\QuotationItem as QuotationItemEntity;
use Item\Mapper\QuotationHistoryStatusTrait as QuotationHistoryStatusMapperTrait;
use Item\Entity\QuotationHistoryStatus as QuotationHistoryStatusEntity;
use Item\Mapper\TermConditionTrait as TermConditionMapperTrait;
use Item\Entity\TermCondition as TermConditionEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\QuotationEvent;
use Zend\Log\Exception\RuntimeException;
use Doctrine\Common\Collections\ArrayCollection;
use User\Mapper\CustomerTrait;
use User\V1\Rest\Customer\CustomerEntity;

class QuotationEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use QuotationMapperTrait;
    use QuotationItemMapperTrait;
    use AccountMapperTrait;
    use ItemListMapperTrait;
    use CustomerMapperTrait;
    use TaxValueMapperTrait;
    use QuotationHistoryStatusMapperTrait;
    use TermConditionMapperTrait;

    protected $fileConfig;
    protected $quotationEvent;
    protected $quotationHydrator;
    protected $termConditionHydrator;

    public function __construct(
        \User\Mapper\Quotation $quotationMapper,
        \Item\Mapper\QuotationItem $quotationItemMapper,
        \User\Mapper\Account $accountMapper,
        \Item\Mapper\ItemList $itemListMapper,
        \User\Mapper\Customer $customerMapper,
        \User\Mapper\TaxValue $taxValueMapper,
        \Item\Mapper\QuotationHistoryStatus $quotationHistoryStatus,
        \Item\Mapper\TermCondition $termConditionMapper
    ) {
        $this->setQuotationMapper($quotationMapper);
        $this->setQuotationItemMapper($quotationItemMapper);
        $this->setAccountMapper($accountMapper);
        $this->setItemListMapper($itemListMapper);
        $this->setCustomerMapper($customerMapper);
        $this->setTaxValueMapper($taxValueMapper);
        $this->setQuotationHistoryStatusMapper($quotationHistoryStatus);
        $this->setTermConditionMapper($termConditionMapper);
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            QuotationEvent::EVENT_CREATE_QUOTATION,
            [$this, 'createQuotation'],
            500
        );

        $this->listeners[] = $events->attach(
            QuotationEvent::EVENT_CREATE_QUOTATION,
            [$this, 'saveOptionFields'],
            499
        );

        $this->listeners[] = $events->attach(
            QuotationEvent::EVENT_CREATE_QUOTATION,
            [$this, 'createTermCondition'],
            498
        );

        // $this->listeners[] = $events->attach(
        //     QuotationEvent::EVENT_CREATE_QUOTATION_SUCCESS,
        //     [$this, 'saveQuotationHistoryStatus'],
        //     498
        // );

        $this->listeners[] = $events->attach(
            QuotationEvent::EVENT_UPDATE_QUOTATION,
            [$this, 'updateQuotation'],
            500
        );

        $this->listeners[] = $events->attach(
            QuotationEvent::EVENT_ACTION_QUOTATION,
            [$this, 'actionQuotation'],
            500
        );

        // $this->listeners[] = $events->attach(
        //     QuotationEvent::EVENT_ACTION_QUOTATION_SUCCESS,
        //     [$this, 'saveQuotationHistoryStatus'],
        //     499
        // );

        $this->listeners[] = $events->attach(
            QuotationEvent::EVENT_UPDATE_QUOTATION,
            [$this, 'updateOptionFields'],
            499
        );

        $this->listeners[] = $events->attach(
            QuotationEvent::EVENT_UPDATE_QUOTATION,
            [$this, 'updateTermCondition'],
            498
        );

        $this->listeners[] = $events->attach(
            QuotationEvent::EVENT_DELETE_QUOTATION,
            [$this, 'deleteQuotation'],
            498
        );
    }

    //untuk saat ini belum ada fitur status pada quotation

    // public function saveQuotationHistoryStatus(QuotationEvent $event)
    // {
    //     try {
    //         $quotationEntity = $event->getQuotationEntity();
    //         $quotationHistoryStatusEntity = new QuotationHistoryStatusEntity;

    //         $inputFilter = $event->getInputFilter()->getValues();
    //         $action = $inputFilter['action'];

    //         if ($action == "approve") {
    //             $status = "Approved";
    //         } elseif ($action == "reject") {
    //             $status = "Rejected";
    //         } else {
    //             $status = "-";
    //         }

    //         switch ($event->getName()) {
    //             case QuotationEvent::EVENT_CREATE_QUOTATION_SUCCESS:
    //                 $requestedBy = $quotationEntity->getRequestedBy();
    //                 $username = $requestedBy->getFirstName() . ' ' . $requestedBy->getLastName();
    //                 $quotationHistoryStatusEntity->setStatus("Issued");
    //                 break;
    //             case QuotationEvent::EVENT_ACTION_QUOTATION_SUCCESS:
    //                 if ($status == "Approved") {
    //                     $approvedBy = $quotationEntity->getApprovedBy();
    //                     $username   = $approvedBy->getFirstName() . ' ' . $approvedBy->getLastName();
    //                 } elseif ($status == "Rejected") {
    //                     $rejectedBy = $quotationEntity->getRejectedBy();
    //                     $username   = $rejectedBy->getFirstName() . ' ' . $rejectedBy->getLastName();
    //                 }

    //                 $quotationHistoryStatusEntity->setStatus($status);
    //                 $quotationHistoryStatusEntity->setNote($inputFilter['note']);
    //                 break;
    //             default:
    //                 break;
    //         }

    //         $quotationHistoryStatusEntity->setChangedBy($username);
    //         $quotationHistoryStatusEntity->setQuotation($quotationEntity);
    //         $this->getQuotationHistoryStatusMapper()->save($quotationHistoryStatusEntity);

    //         $this->logger->log(
    //             \Psr\Log\LogLevel::INFO,
    //             "{function}: Add Quotation History Status {uuid}",
    //             [
    //                 "function" => __FUNCTION__,
    //                 "uuid" => $quotationHistoryStatusEntity->getUuid()
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

    public function saveOptionFields(QuotationEvent $event)
    {
        try {
            $bodyRequest = $event->getInputFilter()->getValues();
            $quotationEntity = $event->getQuotationEntity();
            $optionFields = $event->getOptionFields();
            $this->logger->log(
                \Psr\Log\LogLevel::DEBUG,
                "{function}: (QT SaveOptFields) data : {data}",
                [
                    "function" => __FUNCTION__,
                    "data" => json_encode($optionFields)
                ]
            );
            foreach ($optionFields as $option) {
                $itemListUuid = $option->itemList;

                $itemListEntity  = $this->getItemListMapper()->fetchOneBy([
                    'uuid' => $itemListUuid
                ]);

                $customerUuid = $bodyRequest['customer']->getuuid();
                $customerEntity  = $this->getCustomerMapper()->fetchOneBy([
                    'uuid' => $customerUuid
                ]);

                $taxValueUuid = $bodyRequest['taxValue'];
                $taxValueEntity  = $this->getTaxValueMapper()->fetchOneBy([
                    'uuid' => $taxValueUuid
                ]);

                $discountValue = is_null($option->discount) || $option->discount == '' ? 0 : (int)$option->discount;

                if (is_null($itemListEntity) && $option->customItem == '') {
                    $this->logger->log(
                        \Psr\Log\LogLevel::WARNING,
                        "{function}: (Quotation Item) User try to input itemList with uuid => {uuid}",
                        [
                            "function" => __FUNCTION__,
                            "uuid" => $itemListUuid
                        ]
                    );
                    continue;
                } elseif ($option->customPrice > 0) {
                    $priceItem  = $option->customPrice; //User customprice when avaiable
                } elseif ($option->customPrice <= 0 && $customerEntity->getSalesType() == "Personal") {
                    $priceItem  = $itemListEntity->getNormalPrice(); //use Normal Price by Personal SalesType
                } elseif ($option->customPrice <= 0 && $customerEntity->getSalesType() == "Corporate") {
                    $priceItem  = $itemListEntity->getCorporatePrice(); //use Corporate Price by Corporate SalesType
                }

                $quantity    = $option->quantity;
                $taxValue    = $taxValueEntity->getValue();
                $quotationItemEntity = new QuotationItemEntity;
                $quotationItemEntity->setQuotation($quotationEntity);
                $quotationItemEntity->setItemList($itemListEntity);
                // $quotationItemEntity->setQtyIssue($option->qtyIssue);
                $quotationItemEntity->setQuantity($quantity);
                $quotationItemEntity->setCustomPrice($option->customPrice);
                $quotationItemEntity->setCustomItem($option->customItem);
                $quotationItemEntity->setIsChecked(1);
                $quotationItemEntity->setDiscount($discountValue);

                $subTotal = (int)$quantity * (float)$priceItem;
                $quotationItemEntity->setSubTotal($subTotal);

                $totalDiscount = ($discountValue / 100) * $subTotal;
                $quotationItemEntity->setTotalDiscount($totalDiscount);

                $totalPriceAfterDiscount = (float)$subTotal - (float)$totalDiscount;
                $quotationItemEntity->setTotalPriceAfterDiscount($totalPriceAfterDiscount);

                $totalTax = (float)$subTotal * ((int)$taxValue / 100);
                $totalPriceAfterTax = (float)$totalPriceAfterDiscount + (float)$totalTax;
                $quotationItemEntity->setTotalPriceAfterTax($totalPriceAfterTax);

                $finalPrice = round($totalPriceAfterDiscount, 2);
                $quotationItemEntity->setBalance($finalPrice);

                // $basePrice = (int)$quantity * (float)$priceItem;
                // $basePrice = (int)$quantity * (float)$priceItem;
                // $discount = ($discountValue / 100) * $basePrice;
                // $priceAfterDiscount = (float)$basePrice - (float)$discount;
                // $finalPrice = round($priceAfterDiscount, 2);
                // $quotationItemEntity->setBalance($finalPrice);
                $this->logger->log(
                    \Psr\Log\LogLevel::DEBUG,
                    "{function}: dc = {discount}   price = {price} -> {price2} -> {price3}  res = {res}",
                    [
                        "function" => __FUNCTION__,
                        "discount" => $discountValue,
                        "price"    => $priceItem,
                        "price2"   => $subTotal,
                        "price3"   => $totalPriceAfterDiscount,
                        "res"      => $finalPrice
                    ]
                );

                $saveOptionFields = $this->getQuotationItemMapper()->save($quotationItemEntity);
                $optArray[] = $saveOptionFields;

                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function}: (Quotation Item) Fields uuid saved => {uuid}",
                    [
                        "function" => __FUNCTION__,
                        "uuid" => $quotationItemEntity->getUuid()
                    ]
                );
            }

            if (!is_null($optArray) || count($optArray) > 0) {
                $optArrayCollection = new ArrayCollection($optArray);
                $quotationEntity->setQuotationItem($optArrayCollection);
                $this->getQuotationMapper()->save($quotationEntity);
            }
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

    public function updateOptionFields(QuotationEvent $event)
    {
        try {
            $bodyRequest = $event->getInputFilter()->getValues();

            $quotationEntity = $event->getQuotationEntity();
            $optionFields = $event->getOptionFields();
            $counter = 0;
            foreach ($optionFields as $option) {
                $quotationItemEntity  = $this->getQuotationItemMapper()->fetchOneBy([
                    'uuid' => $option->uuid
                ]);

                if (!is_null($quotationItemEntity)) {
                    if ($option->delete == "1") {

                        $this->getQuotationItemMapper()->delete($quotationItemEntity);
                        $uuid   = $quotationItemEntity->getUuid();

                        $this->logger->log(
                            \Psr\Log\LogLevel::INFO,
                            "{function} (DELETED) quotation itemList: {uuid}: Data Quotation Item deleted successfully",
                            [
                                'uuid' => $uuid,
                                "function" => __FUNCTION__
                            ]
                        );
                        continue;
                    }
                } else {
                    $quotationItemEntity = new QuotationItemEntity;
                }


                $itemListUuid = $option->itemList;
                $itemListEntity  = $this->getItemListMapper()->fetchOneBy([
                    'uuid' => $itemListUuid
                ]);

                $customerUuid = $bodyRequest['customer'];
                $customerEntity  = $this->getCustomerMapper()->fetchOneBy([
                    'uuid' => $customerUuid
                ]);

                $taxValueUuid = $bodyRequest['taxValue'];
                $taxValueEntity  = $this->getTaxValueMapper()->fetchOneBy([
                    'uuid' => $taxValueUuid
                ]);

                $discountValue = is_null($option->discount) || $option->discount == '' ? 0 : (int)$option->discount;

                if ($option->customPrice == '' && $option->itemList == '' && $customerEntity->getSalesType() == "Personal") {
                    $priceItem  = 0;
                    $this->logger->log(
                        \Psr\Log\LogLevel::WARNING,
                        "{function}: (Quotation Item) User try to input itemList with uuid => {uuid}",
                        [
                            "function" => __FUNCTION__,
                            "uuid" => $itemListUuid
                        ]
                    );
                    continue;
                } elseif ($option->customPrice > 0) {
                    $priceItem  = $option->customPrice; //User customprice when avaiable
                } elseif ($option->customPrice <= 0 && $customerEntity->getSalesType() == "Personal") {
                    $priceItem  = $itemListEntity->getNormalPrice(); //use Normal Price by Personal SalesType
                } elseif ($option->customPrice <= 0 && $customerEntity->getSalesType() == "Corporate") {
                    $priceItem  = $itemListEntity->getCorporatePrice(); //use Corporate Price by Corporate SalesType
                }

                $quantity    = $option->quantity;
                $taxValue    = $taxValueEntity->getValue();
                // $quotationItemEntity = new QuotationItemEntity;
                $quotationItemEntity->setQuotation($quotationEntity);
                $quotationItemEntity->setItemList($itemListEntity);

                // $quotationItemEntity->setQtyIssue($option->qtyIssue);
                $quotationItemEntity->setQuantity($quantity);
                $quotationItemEntity->setCustomPrice($option->customPrice);
                $quotationItemEntity->setCustomItem($option->customItem);
                $quotationItemEntity->setIsChecked(1);
                $quotationItemEntity->setDiscount($discountValue);

                $subTotal = (int)$quantity * (float)$priceItem;
                $quotationItemEntity->setSubTotal($subTotal);

                $totalDiscount = ($discountValue / 100) * $subTotal;
                $quotationItemEntity->setTotalDiscount($totalDiscount);

                $totalPriceAfterDiscount = (float)$subTotal - (float)$totalDiscount;
                $quotationItemEntity->setTotalPriceAfterDiscount($totalPriceAfterDiscount);

                $totalTax = (float)$subTotal * ((int)$taxValue / 100);
                $totalPriceAfterTax = (float)$totalPriceAfterDiscount + (float)$totalTax;
                $quotationItemEntity->setTotalPriceAfterTax($totalPriceAfterTax);

                $finalPrice = round($totalPriceAfterDiscount, 2);
                $quotationItemEntity->setBalance($finalPrice);

                $saveOption = $this->getQuotationItemMapper()->save($quotationItemEntity);
                $counter += 1;
                $optArray[] = $saveOption;

                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function}: {uuid} Quotation Item Fields updated successfully",
                    [
                        "function" => __FUNCTION__,
                        "uuid"  => $quotationItemEntity->getUuid()
                    ]
                );
            }
            // uncomment this for check the return of optArray
            // if (! is_null($optArray) || count($optArray) > 0) {
            //     $optArrayCollection = new ArrayCollection($optArray);
            //     $quotationEntity->setQuotationItem($optArrayCollection);
            //     $this->getQuotationMapper()->save($quotationEntity);
            // }

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: {counter} Quotation Item Fields updated",
                [
                    "function" => __FUNCTION__,
                    "counter"  => $counter
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

    public function createQuotation(QuotationEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }
            $fileConfig = $this->getFileConfig()['quotation'];
            $destinationFolder = $fileConfig['photo_dir'];
            $bodyRequest = $event->getInputFilter()->getValues();
            $quotationEntity = new QuotationEntity;
            unset($bodyRequest['quotationItem']);
            // unset($bodyRequest['quotationTerm']);

            $tmpName = $bodyRequest['photo']['tmp_name'];
            $newPath = str_replace($destinationFolder, 'photo/quotation', $tmpName);
            $bodyRequest["path"] = $newPath;

            $hydrateEntity  = $this->getQuotationHydrator()->hydrate($bodyRequest, $quotationEntity);

            $entityResult   = $this->getQuotationMapper()->save($hydrateEntity);
            $event->setQuotationEntity($entityResult);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: {uuid} New Quotation created successfully",
                [
                    "function" => __FUNCTION__,
                    "uuid" => $hydrateEntity->getUuid()
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

    public function createTermCondition(QuotationEvent $event)
    {
        try {
            $quotationEntity = $event->getQuotationEntity();
            $bodyRequest = $event->getInputFilter()->getValues();
            $date = new \DateTime;
            $termConditionEntity = new TermConditionEntity;
            // $hydrateEntity  = $this->getTermConditionHydrator()->hydrate($bodyRequest, $termConditionEntity);
            $termConditionEntity->setTnc($bodyRequest['termCondition']);
            $termConditionEntity->setAccount($quotationEntity->getAccount());
            $termConditionEntity->setCreatedBy($quotationEntity->getRequestedBy());
            $termConditionEntity->setCreatedAt($date);

            $entityResult   = $this->getTermConditionMapper()->save($termConditionEntity);
            $uuid = $entityResult->getUuid();

            // embed the uuid term condition to quotation
            $quotationEntity->setTermCondition($entityResult);
            $this->getQuotationMapper()->save($quotationEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Term Condition {uuid} created successfully",
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

    public function updateQuotation(QuotationEvent $event)
    {
        $date = new \DateTime;
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $inputFilter = $event->getInputFilter()->getValues();
            // unset($inputFilter['quotationItem']);
            unset($inputFilter['photo']);

            $quotationEntity = $event->getQuotationEntity();
            $quotationEntity->setUpdatedAt($date);

            $hydrateEntity  = $this->getQuotationHydrator()->hydrate($inputFilter, $quotationEntity);
            $entityResult   = $this->getQuotationMapper()->save($hydrateEntity);
            $event->setQuotationEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: data quotation updated successfully\nData : {data}",
                [
                    "uuid" => $hydrateEntity->getUuid(),
                    "data" => json_encode($inputFilter),
                    "function" => __FUNCTION__
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

    public function updateTermCondition(QuotationEvent $event)
    {
        try {
            $quotationEntity = $event->getQuotationEntity();
            $termCondition = $quotationEntity->getTermCondition();
            if (is_null($termCondition)) {
                $termCondition = new TermConditionEntity;
                $termCondition->setCreatedAt(new \DateTime('now'));
            }
            $bodyRequest = $event->getInputFilter()->getValues();

            $termCondition->setTnc($bodyRequest['termCondition']);
            $termCondition->setUpdatedAt(new \DateTime('now'));

            $entityResult   = $this->getTermConditionMapper()->save($termCondition);
            $uuid = $entityResult->getUuid();

            if (is_null($quotationEntity->getTermCondition())) {
                // embed the uuid term condition to quotation
                $quotationEntity->setTermCondition($entityResult);
                $this->getQuotationMapper()->save($quotationEntity);
            }

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Term Condition {uuid} updated successfully",
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

    public function actionQuotation(QuotationEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $inputFilter = $event->getInputFilter()->getValues();
            unset($inputFilter['note']);
            $action = $inputFilter['action'];
            $quotationEntity = $event->getQuotationEntity();
            $quotationUuid = $quotationEntity->getUuid();
            if ($action == "approve") {
                $status = "Approved";
            } elseif ($action == "reject") {
                $status = "Rejected";
            }
            $quotationEntity->setStatus($status);
            $hydrateEntity  = $this->getQuotationHydrator()->hydrate($inputFilter, $quotationEntity);
            $entityResult   = $this->getQuotationMapper()->save($hydrateEntity);
            $event->setQuotationEntity($entityResult);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Quotation " . $status . " {uuid} successfully",
                [
                    "function" => __FUNCTION__,
                    "uuid" => $hydrateEntity->getUuid()
                ]
            );
            if ($action == "approve") {
                $queryParams = ["quotation_uuid" => $quotationUuid];
                $quotationItem = $this->getQuotationItemMapper()->fetchAll($queryParams);
                foreach ($quotationItem->getResult() as $itemListOrder) {
                    $itemListObj = $itemListOrder->getItem();
                    if (!is_null($itemListObj) && $itemListObj != '') {
                        $qtyUsed  = $itemListOrder->getQtyUsed();
                        $itemListData = $this->getItemListMapper()->fetchOneBy([
                            'uuid' => $itemListObj->getUuid()
                        ]);
                        $stockItem = $itemListData->getQuantity();
                        $stockNow = (int)$stockItem - (int)$qtyUsed;
                        $itemListData->setQuantity($stockNow);
                        $this->getItemListMapper()->save($itemListData);
                    } else {
                        continue;
                    }
                }
            }
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


    /**
     * @param  \User\V1\QuotationEvent  $event
     * @return \Exception|null
     */
    public function deleteQuotation(QuotationEvent $event)
    {
        try {
            $targetEntity = $event->getQuotationEntity();
            $this->quotationMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : User Supplier data {uuid} deleted successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $targetEntity->getUuid(),
                ]
            );
        } catch (RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }

    /**
     * Get the value of fileConfig
     */
    public function getFileConfig()
    {
        return $this->fileConfig;
    }

    /**
     * Set the value of fileConfig
     *
     * @return  self
     */
    public function setFileConfig($fileConfig)
    {
        $this->fileConfig = $fileConfig;

        return $this;
    }

    /**
     * Get the value of quotationHydrator
     */
    public function getQuotationHydrator()
    {
        return $this->quotationHydrator;
    }

    /**
     * Set the value of quotationHydrator
     *
     * @return  self
     */
    public function setQuotationHydrator($quotationHydrator)
    {
        $this->quotationHydrator = $quotationHydrator;

        return $this;
    }

    /**
     * Get the value of termConditionHydrator
     */
    public function getTermConditionHydrator()
    {
        return $this->termConditionHydrator;
    }

    /**
     * Set the value of termConditionHydrator
     *
     * @return  self
     */
    public function setTermConditionHydrator($termConditionHydrator)
    {
        $this->termConditionHydrator = $termConditionHydrator;

        return $this;
    }
}
