<?php

namespace Notification\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Notification
 */
class Notification implements EntityInterface
{

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $subtype;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var bool
     */
    private $unread = '1';

    /**
     * @var bool
     */
    private $isAdmin = '0';

    /**
     * @var \DateTime|null
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     */
    private $deletedAt;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\Account
     */
    private $account;

    /**
     * @var \User\Entity\UserProfile
     */
    private $userProfile;

    // /**
    //  * @var \Vehicle\Entity\VehicleRequest
    //  */
    // private $vehicleRequest;

    // /**
    //  * @var \Leave\Entity\Leave
    //  */
    // private $leave;

    // /**
    //  * @var \Overtime\Entity\Overtime
    //  */
    // private $overtime;

    // /**
    //  * @var \Reimbursement\Entity\Reimburse
    //  */
    // private $reimburse;

    // /**
    //  * @var \Item\Entity\SalesOrder
    //  */
    // private $salesOrder;

    // /**
    //  * @var \Item\Entity\PurchaseRequisition
    //  */
    // private $purchaseRequisition;


    /**
     * Set type.
     *
     * @param string|null $type
     *
     * @return Notification
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title.
     *
     * @param string|null $title
     *
     * @return Notification
     */
    public function setTitle($title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set unread.
     *
     * @param bool $unread
     *
     * @return Notification
     */
    public function setUnread($unread)
    {
        $this->unread = $unread;

        return $this;
    }

    /**
     * Get unread.
     *
     * @return bool
     */
    public function getUnread()
    {
        return $this->unread;
    }

    /**
     * Set isAdmin.
     *
     * @param bool $isAdmin
     *
     * @return Notification
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin.
     *
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set account
     *
     * @param \User\Entity\Account $account
     *
     * @return Notification
     */
    public function setAccount(\User\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \User\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set userProfile.
     *
     * @param \User\Entity\UserProfile|null $userProfile
     *
     * @return Notification
     */
    public function setUserProfile(\User\Entity\UserProfile $userProfile = null)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get userProfile.
     *
     * @return \User\Entity\UserProfile|null
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Get the value of createdAt
     *
     * @return  \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  \DateTime|null  $createdAt
     *
     * @return  self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return  \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  \DateTime|null  $updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of deletedAt
     *
     * @return  \DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set the value of deletedAt
     *
     * @param  \DateTime|null  $deletedAt
     *
     * @return  self
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    // /**
    //  * @return \Leave\Entity\Leave
    //  */
    // public function getLeave()
    // {
    //     return $this->leave;
    // }

    // /**
    //  * @param \Leave\Entity\Leave $leave
    //  *
    //  * @return self
    //  */
    // public function setLeave(\Leave\Entity\Leave $leave)
    // {
    //     $this->leave = $leave;

    //     return $this;
    // }

    // /**
    //  * @return \Overtime\Entity\Overtime
    //  */
    // public function getOvertime()
    // {
    //     return $this->overtime;
    // }

    // /**
    //  * @param \Overtime\Entity\Overtime $overtime
    //  *
    //  * @return self
    //  */
    // public function setOvertime(\Overtime\Entity\Overtime $overtime)
    // {
    //     $this->overtime = $overtime;

    //     return $this;
    // }

    // /**
    //  * @return \Reimbursement\Entity\Reimburse
    //  */
    // public function getReimburse()
    // {
    //     return $this->reimburse;
    // }

    // /**
    //  * @param \Reimbursement\Entity\Reimburse $reimburse
    //  *
    //  * @return self
    //  */
    // public function setReimburse(\Reimbursement\Entity\Reimburse $reimburse)
    // {
    //     $this->reimburse = $reimburse;

    //     return $this;
    // }

    // /**
    //  * Get the value of salesOrder
    //  *
    //  * @return  \Item\Entity\SalesOrder
    //  */
    // public function getSalesOrder()
    // {
    //     return $this->salesOrder;
    // }

    // /**
    //  * Set the value of salesOrder
    //  *
    //  * @param  \Item\Entity\SalesOrder  $salesOrder
    //  *
    //  * @return  self
    //  */
    // public function setSalesOrder(\Item\Entity\SalesOrder $salesOrder)
    // {
    //     $this->salesOrder = $salesOrder;

    //     return $this;
    // }

    /**
     * Get the value of subtype
     *
     * @return  string|null
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * Set the value of subtype
     *
     * @param  string|null  $subtype
     *
     * @return  self
     */
    public function setSubtype($subtype)
    {
        $this->subtype = $subtype;

        return $this;
    }

    // /**
    //  * Get the value of purchaseRequisition
    //  *
    //  * @return  \Item\Entity\PurchaseRequisition
    //  */ 
    // public function getPurchaseRequisition()
    // {
    //     return $this->purchaseRequisition;
    // }

    // /**
    //  * Set the value of purchaseRequisition
    //  *
    //  * @param  \Item\Entity\PurchaseRequisition  $purchaseRequisition
    //  *
    //  * @return  self
    //  */ 
    // public function setPurchaseRequisition(\Item\Entity\PurchaseRequisition $purchaseRequisition = null)
    // {
    //     $this->purchaseRequisition = $purchaseRequisition;

    //     return $this;
    // }
}
