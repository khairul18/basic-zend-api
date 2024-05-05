<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Department
 */
class Department implements EntityInterface
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var string|null
     */
    private $extPhone;

    /**
     * @var string|null
     */
    private $fax;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var int|null
     */
    private $isActive = '1';

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
    private $note;

    /**
     * @var \User\Entity\Company
     */
    private $company;

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
     * Get the value of note
     *
     * @return  string|null
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @param  string|null  $note
     *
     * @return  self
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
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
     * Get the value of phone
     *
     * @return  string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @param  string|null  $phone
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of extPhone
     *
     * @return  string|null
     */
    public function getExtPhone()
    {
        return $this->extPhone;
    }

    /**
     * Set the value of extPhone
     *
     * @param  string|null  $extPhone
     *
     * @return  self
     */
    public function setExtPhone($extPhone)
    {
        $this->extPhone = $extPhone;

        return $this;
    }

    /**
     * Get the value of fax
     *
     * @return  string|null
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set the value of fax
     *
     * @param  string|null  $fax
     *
     * @return  self
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

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
     * Get the value of email
     *
     * @return  string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string|null  $email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of company
     *
     * @return  \User\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @param  \User\Entity\Company  $company
     *
     * @return  self
     */
    public function setCompany(\User\Entity\Company $company)
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
     * Get the value of isActive
     *
     * @return  int|null
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of isActive
     *
     * @param  int|null  $isActive
     *
     * @return  self
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
}
