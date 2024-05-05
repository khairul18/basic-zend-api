<?php

namespace Notification\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Notification\V1\NotificationEvent;
// use Overtime\V1\OvertimeEvent;
// use Reimbursement\V1\ReimbursementEvent;
// use Leave\V1\LeaveEvent;
use Item\V1\SalesOrderEvent;
use Item\V1\PurchaseRequisitionEvent;
use Vehicle\V1\VehicleRequestEvent;
use Xtend\Firebase\Service\FirebaseTrait;
use User\V1\Role;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileTraitMapper;
use User\Mapper\UserAccessTrait as UserAccessTraitMapper;
use Notification\Mapper\NotificationTrait as NotificationMapperTrait;
use Notification\Entity\Notification as NotificationEntity;
use Item\V1\PurchaseRequisitionEvent as PR_Event;

class NotificationEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    use AccountMapperTrait;

    use NotificationMapperTrait;

    use FirebaseTrait;

    use UserProfileTraitMapper;

    use UserAccessTraitMapper;

    /**
     *
     * @var DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    protected $notificationHydrator;
    protected $telegramConfig;
    protected $phpProcessBuilder;
    protected $telegramNotification;

    /**
     * Constructor
     *
     * @param QRcode\Mapper\Notification   $trackingMapper
     */
    public function __construct(
        $userProfileMapper,
        \Notification\Mapper\Notification $notificationMapper = null,
        \User\Mapper\Account $accountMapper = null,
        $phpProcessBuilder,
        \User\Mapper\UserAccess $userAccessMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setNotificationMapper($notificationMapper);
        $this->setAccountMapper($accountMapper);
        $this->setPhpProcessBuilder($phpProcessBuilder);
        $this->setUserAccessMapper($userAccessMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            NotificationEvent::EVENT_UPDATE_NOTIFICATION,
            [$this, 'updateNotification'],
            499
        );

        // $this->listeners[] = $events->attach(
        //     OvertimeEvent::EVENT_ACTION_OVERTIME_SUCCESS,
        //     [$this, 'overtimeActionNotification'],
        //     498
        // );

        // $this->listeners[] = $events->attach(
        //     LeaveEvent::EVENT_ACTION_LEAVE_SUCCESS,
        //     [$this, 'leaveActionNotification'],
        //     498
        // );

        // $this->listeners[] = $events->attach(
        //     ReimbursementEvent::EVENT_ACTION_REIMBURSE_SUCCESS,
        //     [$this, 'reimbursementActionNotification'],
        //     498
        // );

        // $this->listeners[] = $events->attach(
        //     SalesOrderEvent::EVENT_ACTION_SALES_ORDER_SUCCESS,
        //     [$this, 'salesOrderActionNotification'],
        //     498
        // );

        // $this->listeners[] = $events->attach(
        //     PurchaseRequisitionEvent::EVENT_ACTION_PURCHASE_REQUISITION_SUCCESS,
        //     [$this, 'purchaseRequisitionActionNotification'],
        //     498
        // );

        // $this->listeners[] = $events->attach(
        //     PurchaseRequisitionEvent::EVENT_ACTION_PURCHASE_REQUISITION_SUCCESS,
        //     [$this, 'sendPurchaseRequisitionApprovalNotif'],
        //     497
        // );

        // $this->listeners[] = $events->attach(
        //     PurchaseRequisitionEvent::EVENT_CREATE_PURCHASE_REQUISITION_SUCCESS,
        //     [$this, 'sendPurchaseRequisitionApprovalNotif'],
        //     497
        // );

        // $this->listeners[] = $events->attach(
        //     VehicleRequestEvent::EVENT_CREATE_VEHICLE_REQUEST_SUCCESS,
        //     [$this, 'sendRequestedVehicleNotifToAdmin'],
        //     499
        // );

        // $this->listeners[] = $events->attach(
        //     VehicleRequestEvent::EVENT_START_VEHICLE_REQUEST_SUCCESS,
        //     [$this, 'sendStartedVehicleNotifToAdmin'],
        //     499
        // );

        // $this->listeners[] = $events->attach(
        //     VehicleRequestEvent::EVENT_FINISH_VEHICLE_REQUEST_SUCCESS,
        //     [$this, 'sendFinishedVehicleNotifToAdmin'],
        //     499
        // );

        // $this->listeners[] = $events->attach(
        //     VehicleRequestEvent::EVENT_CANCEL_VEHICLE_REQUEST_SUCCESS,
        //     [$this, 'sendCanceledVehicleNotifToAdmin'],
        //     499
        // );

        // $this->listeners[] = $events->attach(
        //     OvertimeEvent::EVENT_CREATE_OVERTIME_SUCCESS,
        //     [$this, 'overtimeCreateTelegramNotification'],
        //     498
        // );

        // $this->listeners[] = $events->attach(
        //     ReimbursementEvent::EVENT_CREATE_REIMBURSE_SUCCESS,
        //     [$this, 'reimbursementCreateTelegramNotification'],
        //     498
        // );

        // $this->listeners[] = $events->attach(
        //     LeaveEvent::EVENT_CREATE_LEAVE_SUCCESS,
        //     [$this, 'leaveCreateTelegramNotification'],
        //     498
        // );
    }


    /**
     * Get config
     *
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function updateNotification(NotificationEvent $event)
    {
        try {
            $oldData = $event->getNotificationEntity();
            $newData = $event->getUpdateData();

            $notificationData   = $this->getNotificationHydrator()->hydrate($newData, $oldData);
            $notificationResult = $this->getNotificationMapper()->save($notificationData);
            $unread = $newData['unread'] == 1 ? true : false;
            $notificationResult->setUnread($unread);
            $event->setNotificationEntity($notificationResult);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification read!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    /**
     * Send Telegram Notification for Overtime Created
     *
     * @param OvertimeEvent $event
     * @void
     */
    public function overtimeCreateTelegramNotification(OvertimeEvent $event)
    {
        $telegramNotification = $this->getTelegramNotification();
        $overtimeEntity = $event->getOvertimeEntity();
        $requestedBy = $overtimeEntity->getRequestedBy();
        $helper = new \Zend\View\Helper\ServerUrl();
        $data   = [];
        $data[]  = $requestedBy->getFirstName() . ' ' . $requestedBy->getLastName();
        $data[]  = $helper->getScheme() . '://' . $helper->getHost() . '/#/overtime/' . $overtimeEntity->getUuid();
        $message = str_replace([':user', ':url'], $data, $telegramNotification['new_overtime_created']);
        $this->sendTelegramNotification($event, $message);
    }

    /**
     * Send Telegram Notification for Reimbursement Created
     *
     * @param OvertimeEvent $event
     * @void
     */
    public function reimbursementCreateTelegramNotification(ReimbursementEvent $event)
    {
        $telegramNotification = $this->getTelegramNotification();
        $reimbursementEntity  = $event->getReimbursementEntity();
        $requestedBy = $reimbursementEntity->getRequestedBy();
        $helper  = new \Zend\View\Helper\ServerUrl();
        $data    = [];
        $data[]  = $requestedBy->getFirstName() . ' ' . $requestedBy->getLastName();
        $data[]  = $helper->getScheme() . '://' . $helper->getHost() . '/#/reimbursement/' . $reimbursementEntity->getUuid();
        $message = str_replace([':user', ':url'], $data, $telegramNotification['new_reimbursement_created']);
        $this->sendTelegramNotification($event, $message);
    }


    /**
     * Send Telegram Notification for Leave Created
     *
     * @param LeaveEvent $event
     * @void
     */
    public function leaveCreateTelegramNotification(LeaveEvent $event)
    {
        $telegramNotification = $this->getTelegramNotification();
        $leaveEntity = $event->getLeaveEntity();
        $requestedBy = $leaveEntity->getRequestedBy();
        $helper  = new \Zend\View\Helper\ServerUrl();
        $data    = [];
        $data[]  = $requestedBy->getFirstName() . ' ' . $requestedBy->getLastName();
        $data[]  = $helper->getScheme() . '://' . $helper->getHost() . '/#/leave/' . $leaveEntity->getUuid();
        $message = str_replace([':user', ':url'], $data, $telegramNotification['new_leave_created']);
        $this->sendTelegramNotification($event, $message);
    }

    public function overtimeActionNotification(OvertimeEvent $event)
    {
        try {
            $overtime = $event->getOvertimeEntity();
            $message = $event->getNotificationMessage();
            $firebaseId = $overtime->getRequestedBy()->getFirebaseId();
            if (is_null($firebaseId)) {
                $this->logger->log(
                    \Psr\Log\LogLevel::WARNING,
                    "{function} {uuid} {message}",
                    [
                        "function" => __FUNCTION__,
                        "message"  => "Notification not send caused by there is no tenant firebase id",
                        "uuid" => $overtime->getRequestedBy()->getUuid()
                    ]
                );
                return;
            }
            $this->getFirebaseService()->send($firebaseId, $message);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification send!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function leaveActionNotification(LeaveEvent $event)
    {
        try {
            $leave = $event->getLeaveEntity();
            $message = $event->getNotificationMessage();
            $firebaseId = $leave->getRequestedBy()->getFirebaseId();
            if (is_null($firebaseId)) {
                $this->logger->log(
                    \Psr\Log\LogLevel::WARNING,
                    "{function} {uuid} {message}",
                    [
                        "function" => __FUNCTION__,
                        "message"  => "Notification not send caused by there is no tenant firebase id",
                        "uuid" => $leave->getRequestedBy()->getUuid()
                    ]
                );
                return;
            }
            $this->getFirebaseService()->send($firebaseId, $message);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification send!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function reimbursementActionNotification(ReimbursementEvent $event)
    {
        try {
            $reimbursement = $event->getReimbursementEntity();
            $message = $event->getNotificationMessage();
            $firebaseId = $reimbursement->getRequestedBy()->getFirebaseId();
            if (is_null($firebaseId)) {
                $this->logger->log(
                    \Psr\Log\LogLevel::WARNING,
                    "{function} {uuid} {message}",
                    [
                        "function" => __FUNCTION__,
                        "message"  => "Notification not send caused by there is no tenant firebase id",
                        "uuid" => $reimbursement->getRequestedBy()->getUuid()
                    ]
                );
                return;
            }
            $this->getFirebaseService()->send($firebaseId, $message);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification send!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function salesOrderActionNotification(SalesOrderEvent $event)
    {
        try {
            $salesOrder = $event->getSalesOrderEntity();
            $message = $event->getNotificationMessage();
            $firebaseId = $salesOrder->getRequestedBy()->getFirebaseId();
            if (is_null($firebaseId)) {
                $this->logger->log(
                    \Psr\Log\LogLevel::WARNING,
                    "{function} {uuid} {message}",
                    [
                        "function" => __FUNCTION__,
                        "message"  => "Notification not send caused by there is no tenant firebase id",
                        "uuid" => $salesOrder->getRequestedBy()->getUuid()
                    ]
                );
                return;
            }
            $this->getFirebaseService()->send($firebaseId, $message);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification send!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    // notif for user / technician
    public function purchaseRequisitionActionNotification(PurchaseRequisitionEvent $event)
    {
        try {
            $purchaseRequisition = $event->getPurchaseRequisitionEntity();
            $message = $event->getNotificationMessage();
            $firebaseId = $purchaseRequisition->getRequestedBy()->getFirebaseId();
            if (is_null($firebaseId)) {
                $this->logger->log(
                    \Psr\Log\LogLevel::WARNING,
                    "{function} {uuid} {message}",
                    [
                        "function" => __FUNCTION__,
                        "message"  => "Notification not send caused by there is no tenant firebase id",
                        "uuid" => $purchaseRequisition->getRequestedBy()->getUuid()
                    ]
                );
                return;
            }
            $this->getFirebaseService()->send($firebaseId, $message);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message} {userProfile} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification send!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function sendPurchaseRequisitionApprovalNotif(PurchaseRequisitionEvent $event)
    {
        try {
            $purchaseRequisition = $event->getPurchaseRequisitionEntity();
            $requestedUser = $purchaseRequisition->getRequestedBy()->getFirstName() . " " . $purchaseRequisition->getRequestedBy()->getLastName();
            $purchaseGoal = $purchaseRequisition->getName();
            $countryId = $purchaseRequisition->getRequestedBy()->getAccount()->getCountryId();
            if (strtolower($countryId) == 'my') {
                $currency = 'RM ';
                $limitValue = $event::LIMIT_MYR;
            } elseif (strtolower($countryId) == 'id') {
                $currency = 'Rp ';
                $limitValue = $event::LIMIT_IDR;
            }
            $price = $purchaseRequisition->getPrice();
            $account = $purchaseRequisition->getRequestedBy()->getAccount()->getUuid();
            $isFinance = false;
            $isPic = false;
            if (is_null($purchaseRequisition->getPosition())) {
                $isPic = true;
                $users = $this->getUserProfileMapper()->fetchOneBy([
                    "uuid" => $purchaseRequisition->getRequestedBy()->getParent()->getUuid()
                ]);
                $users = [$users];
            } elseif ($purchaseRequisition->getPosition() == PR_Event::AS_PIC) {
                $isFinance = true;
                $users = $this->getUserAccessMapper()->fetchAll([
                    "account_uuid" => $account,
                    "role" => 'ADMIN,MANAGER'
                ])->getResult();
            } elseif ($purchaseRequisition->getPosition() == PR_Event::AS_FINANCE && (int) $purchaseRequisition->getPrice() > $limitValue) {
                $users = $this->getUserAccessMapper()->fetchAll([
                    "account_uuid" => $account,
                    "role" => 'ADMIN'
                ])->getResult();
            }
            foreach ($users as $user) {
                if ($isFinance && !is_null($user->getUserProfile()->getDepartment())) {
                    if (strtolower($user->getUserProfile()->getDepartment()->getName()) != 'finance') {
                        continue;
                    }
                }
                if ($isPic) {
                    $recipientFirebaseId = $user->getFirebaseId();
                    $fullname =  $user->getFirstName() . ' ' . $user->getLastName();
                } else {
                    $recipientFirebaseId = $user->getUserProfile()->getFirebaseId();
                    $fullname =  $user->getUserProfile()->getFirstName() . ' ' . $user->getUserProfile()->getLastName();
                }

                if (is_null($recipientFirebaseId)) {
                    $this->logger->log(
                        \Psr\Log\LogLevel::WARNING,
                        "{function} {username} {message}",
                        [
                            "function" => __FUNCTION__,
                            "message"  => "Notification not send caused by there is no firebase id from web user",
                            "username" => $fullname
                        ]
                    );

                    continue;
                }

                $newData = [
                    "account" => $account,
                    "userProfile" => $user->getUuid(),
                    "type" => "PURCHASE_REQUISITION",
                    "purchaseRequisition" => $purchaseRequisition->getUuid(),
                    "title" => "([PURCHASE REQUISITION] User: " . $requestedUser . " requires your approval to " . $purchaseGoal . " for " . $currency . $price,
                    "unread" => 1
                ];

                $notificationEntity = new NotificationEntity;
                $notificationData   = $this->getNotificationHydrator()->hydrate($newData, $notificationEntity);
                $notificationResult = $this->getNotificationMapper()->save($notificationData);
                $this->sendFirebaseNotification($event, $newData, $recipientFirebaseId, 'PURCHASE_REQUISITION');
            }
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message}",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification read!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function sendRequestedVehicleNotifToAdmin(VehicleRequestEvent $event)
    {
        try {
            $webUsers = Role::ADMIN . ',' . Role::HELPDESK . ',' . Role::MANAGER;
            $vehicleRequest = $event->getVehicleRequestEntity();
            $requestedUser = $vehicleRequest->getRequestedBy()->getFirstName() . " " . $vehicleRequest->getRequestedBy()->getLastName();
            $plateNumber = $vehicleRequest->getVehicle()->getPlate();
            $account = $vehicleRequest->getRequestedBy()->getAccount()->getUuid();
            $users = $this->getUserProfileMapper()->fetchAll([
                "account" => $account,
                "role" => $webUsers
            ])->getResult();

            foreach ($users as $user) {
                $recipientFirebaseId = $user->getFirebaseId();
                if (is_null($recipientFirebaseId)) {
                    $this->logger->log(
                        \Psr\Log\LogLevel::WARNING,
                        "{function} {username} {message}",
                        [
                            "function" => __FUNCTION__,
                            "message"  => "Notification not send caused by there is no firebase id from web user",
                            "username" => $user->getFirstName() . ' ' . $user->getLastName()
                        ]
                    );

                    continue;
                }

                $newData = [
                    "account" => $account,
                    "userProfile" => $user->getUuid(),
                    "vehicleRequest" => $vehicleRequest->getUuid(),
                    "type" => "VEHICLE",
                    "title" => "Vehicle " . $plateNumber . "  is requested by " . $requestedUser,
                    "unread" => 1,
                    "isAdmin" => "1"
                ];

                $notificationEntity = new NotificationEntity;
                $notificationData   = $this->getNotificationHydrator()->hydrate($newData, $notificationEntity);
                $notificationResult = $this->getNotificationMapper()->save($notificationData);
                $this->sendFirebaseNotification($event, $newData, $recipientFirebaseId, 'VEHICLE');
            }
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message}",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification read!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function sendStartedVehicleNotifToAdmin(VehicleRequestEvent $event)
    {
        try {
            $webUsers = Role::ADMIN . ',' . Role::HELPDESK . ',' . Role::MANAGER;
            $vehicleRequest = $event->getVehicleRequestEntity();

            $requestedUser = $vehicleRequest->getRequestedBy()->getFirstName() . " " . $vehicleRequest->getRequestedBy()->getLastName();
            $plateNumber = $vehicleRequest->getVehicle()->getPlate();
            $account = $vehicleRequest->getRequestedBy()->getAccount()->getUuid();
            $users = $this->getUserProfileMapper()->fetchAll([
                "account" => $account,
                "role" => $webUsers
            ])->getResult();

            foreach ($users as $user) {
                $recipientFirebaseId = $user->getFirebaseId();
                if (is_null($recipientFirebaseId)) {
                    $this->logger->log(
                        \Psr\Log\LogLevel::WARNING,
                        "{function} {username} {message}",
                        [
                            "function" => __FUNCTION__,
                            "message"  => "Notification not send caused by there is no firebase id from web user",
                            "username" => $user->getFirstName() . ' ' . $user->getLastName()
                        ]
                    );

                    continue;
                }

                $newData = [
                    "account" => $account,
                    "userProfile" => $user->getUuid(),
                    "vehicleRequest" => $vehicleRequest->getUuid(),
                    "type" => "VEHICLE",
                    "title" => "Vehicle " . $plateNumber . "  is being driven by " . $requestedUser,
                    "unread" => 1,
                    "isAdmin" => "1"
                ];
                $notificationEntity = new NotificationEntity;
                $notificationData   = $this->getNotificationHydrator()->hydrate($newData, $notificationEntity);
                $notificationResult = $this->getNotificationMapper()->save($notificationData);

                $this->sendFirebaseNotification($event, $newData, $recipientFirebaseId, 'VEHICLE');
            }
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message}",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification read!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function sendFinishedVehicleNotifToAdmin(VehicleRequestEvent $event)
    {
        try {
            $webUsers = Role::ADMIN . ',' . Role::HELPDESK . ',' . Role::MANAGER;
            $vehicleRequest = $event->getVehicleRequestEntity();

            $requestedUser = $vehicleRequest->getRequestedBy()->getFirstName() . " " . $vehicleRequest->getRequestedBy()->getLastName();
            $plateNumber = $vehicleRequest->getVehicle()->getPlate();
            $account = $vehicleRequest->getRequestedBy()->getAccount()->getUuid();
            $users = $this->getUserProfileMapper()->fetchAll([
                "account" => $account,
                "role" => $webUsers
            ])->getResult();

            foreach ($users as $user) {
                $recipientFirebaseId = $user->getFirebaseId();
                if (is_null($recipientFirebaseId)) {
                    $this->logger->log(
                        \Psr\Log\LogLevel::WARNING,
                        "{function} {username} {message}",
                        [
                            "function" => __FUNCTION__,
                            "message"  => "Notification not send caused by there is no firebase id from web user",
                            "username" => $user->getFirstName() . ' ' . $user->getLastName()
                        ]
                    );

                    continue;
                }

                $newData = [
                    "account" => $account,
                    "userProfile" => $user->getUuid(),
                    "vehicleRequest" => $vehicleRequest->getUuid(),
                    "type" => "VEHICLE",
                    "title" => $requestedUser . " has finished using vehicleRequest " . $plateNumber,
                    "unread" => 1,
                    "isAdmin" => "1"
                ];

                $notificationEntity = new NotificationEntity;
                $notificationData   = $this->getNotificationHydrator()->hydrate($newData, $notificationEntity);
                $notificationResult = $this->getNotificationMapper()->save($notificationData);
                $this->sendFirebaseNotification($event, $newData, $recipientFirebaseId, 'VEHICLE');
            }
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message}",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification read!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function sendCanceledVehicleNotifToAdmin(VehicleRequestEvent $event)
    {
        try {
            $webUsers = Role::ADMIN . ',' . Role::HELPDESK . ',' . Role::MANAGER;
            $vehicleRequest = $event->getVehicleRequestEntity();

            $requestedUser = $vehicleRequest->getRequestedBy()->getFirstName() . " " . $vehicleRequest->getRequestedBy()->getLastName();
            $plateNumber = $vehicleRequest->getVehicle()->getPlate();
            $account = $vehicleRequest->getRequestedBy()->getAccount()->getUuid();
            $users = $this->getUserProfileMapper()->fetchAll([
                "account" => $account,
                "role" => $webUsers
            ])->getResult();

            foreach ($users as $user) {
                $recipientFirebaseId = $user->getFirebaseId();
                if (is_null($recipientFirebaseId)) {
                    $this->logger->log(
                        \Psr\Log\LogLevel::WARNING,
                        "{function} {username} {message}",
                        [
                            "function" => __FUNCTION__,
                            "message"  => "Notification not send caused by there is no firebase id from web user",
                            "username" => $user->getFirstName() . ' ' . $user->getLastName()
                        ]
                    );

                    continue;
                }

                $newData = [
                    "account" => $account,
                    "userProfile" => $user->getUuid(),
                    "vehicleRequest" => $vehicleRequest->getUuid(),
                    "type" => "VEHICLE",
                    "title" => $requestedUser . " has canceled the request of vehicle " . $plateNumber,
                    "unread" => 1,
                    "isAdmin" => "1"
                ];

                $notificationEntity = new NotificationEntity;
                $notificationData   = $this->getNotificationHydrator()->hydrate($newData, $notificationEntity);
                $notificationResult = $this->getNotificationMapper()->save($notificationData);
                $this->sendFirebaseNotification($event, $newData, $recipientFirebaseId, 'VEHICLE');
            }
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {message}",
                [
                    "function" => __FUNCTION__,
                    "message"  => "Notification read!"
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message} ",
                [
                    "function" => __FUNCTION__,
                    "message"  => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function sendTelegramNotification($event, string $message, string $recepient = null)
    {
        $config = $this->getTelegramConfig();
        if (is_null($recepient)) {
            $recepient = $config['default_recepient'];
        }

        $body = [
            'u' => $config['username'],
            'p' => $config['password'],
            'to' => $recepient,
            'msg' => $message,
            'from' => $config['from']
        ];
        // curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['url']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        //execute post
        $result = curl_exec($ch);
        $info   = curl_getinfo($ch);
        if (curl_errno($ch)) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {recepient} {code} {message}",
                ["function" => __FUNCTION__, "code" => $info['http_code'], "recepient" => $recepient, "message" => $data['message']]
            );
        }

        $this->logger->log(
            \Psr\Log\LogLevel::DEBUG,
            "{function} {code} {recepient} {message}",
            [
                "function" => __FUNCTION__,
                "code" => $info['http_code'],
                "recepient" => $recepient,
                "message" => $data['message']
            ]
        );

        //close connection
        curl_close($ch);
    }

    public function sendFirebaseNotification($event, $data, $firebaseId, $flag)
    {
        if ($flag == 'VEHICLE') {
            $request = $event->getVehicleRequestEntity();
        } elseif ($flag == 'PURCHASE_REQUISITION') {
            $request = $event->getPurchaseRequisitionEntity();
        }
        $message  = new \stdClass();
        $message->type  = $data['type'];
        $message->title = $data['title'];
        $message->uuid  = $request->getUuid();
        // command: v1 ticket send-notification-ticket <firebaseId> <message>
        $cli = $this->getPhpProcessBuilder()
            ->setArguments(
                ['v1', 'notification', 'send-notification-ticket', $firebaseId, '"' . addslashes(json_encode($message)) . '"']
            )->getProcess();
        $cli->start();
        $pid = $cli->getPid();
        $this->logger->log(
            \Psr\Log\LogLevel::INFO,
            "{function} {pid} {commandline}",
            ["function" => __FUNCTION__, "commandline" => $cli->getCommandLine(), "pid" => $pid]
        );
    }

    /**
     * Get the value of notificationHydrator
     *
     * @return  DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    public function getNotificationHydrator()
    {
        return $this->notificationHydrator;
    }

    /**
     * Set the value of notificationHydrator
     *
     * @param  DoctrineModule\Stdlib\Hydrator\DoctrineObject  $notificationHydrator
     *
     * @return  self
     */
    public function setNotificationHydrator($notificationHydrator)
    {
        $this->notificationHydrator = $notificationHydrator;

        return $this;
    }

    /**
     * Get the value of telegramConfig
     */
    public function getTelegramConfig()
    {
        return $this->telegramConfig;
    }

    /**
     * Set the value of telegramConfig
     *
     * @return  self
     */
    public function setTelegramConfig($telegramConfig)
    {
        $this->telegramConfig = $telegramConfig;

        return $this;
    }

    /**
     * @return array
     */
    public function getTelegramNotification()
    {
        return $this->telegramNotification;
    }

    /**
     * @param array $overtimeTelegramConfig
     */
    public function setTelegramNotification($overtimeTelegramConfig)
    {
        $this->telegramNotification = $overtimeTelegramConfig;
    }

    /**
     * Get the value of phpProcessBuilder
     */
    public function getPhpProcessBuilder()
    {
        return $this->phpProcessBuilder;
    }

    /**
     * Set the value of phpProcessBuilder
     *
     * @return  self
     */
    public function setPhpProcessBuilder($phpProcessBuilder)
    {
        $this->phpProcessBuilder = $phpProcessBuilder;

        return $this;
    }
}
