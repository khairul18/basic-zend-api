<?php

namespace Department\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Group
 */
class Group implements EntityInterface
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var \User\Entity\Account
     */
    private $account;

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
     * @var string|null
     */
    private $desc;

    /**
     * @var \Department\Entity\Company
     */
    private $company;

    /**
     * @var \User\Entity\UserProfile
     */
    private $createdBy;

    /**
     * @var \User\Entity\Branch
     */
    private $branch;


    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Department
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Department
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Department
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt.
     *
     * @param \DateTime|null $deletedAt
     *
     * @return Department
     */
    public function setDeletedAt($deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     *
     * @return \DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
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
     * Get the value of account
     *
     * @return  \User\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set the value of account
     *
     * @param  \User\Entity\Account  $account
     *
     * @return  self
     */
    public function setAccount(\User\Entity\Account $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get the value of code
     *
     * @return  int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param  int  $code
     *
     * @return  self
     */
    public function setCode(int $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of company
     *
     * @return  \Department\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @param  \Department\Entity\Company  $company
     *
     * @return  self
     */
    public function setCompany(\Department\Entity\Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get the value of branch
     *
     * @return  \User\Entity\Branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set the value of branch
     *
     * @param  \User\Entity\Branch  $branch
     *
     * @return  self
     */
    public function setBranch(\User\Entity\Branch $branch)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get the value of desc
     *
     * @return  string|null
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Set the value of desc
     *
     * @param  string|null  $desc
     *
     * @return  self
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Get the value of createdBy
     *
     * @return  \User\Entity\UserProfile
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set the value of createdBy
     *
     * @param  \User\Entity\UserProfile  $createdBy
     *
     * @return  self
     */
    public function setCreatedBy(\User\Entity\UserProfile $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
