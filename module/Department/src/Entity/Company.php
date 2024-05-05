<?php

namespace Department\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Company
 */
class Company implements EntityInterface
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
     * @var string|null
     */
    private $address;

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
    private $registrationId;

    /**
     * @var string|null
     */
    private $taxId;

    /**
     * @var string|null
     */
    private $about;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var int|null
     */
    private $isActive = '1';

    /**
     * @var int|null
     */
    private $isHq = '1';

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
     * Set code.
     *
     * @param int $code
     *
     * @return Company
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Company
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address.
     *
     * @param string|null $address
     *
     * @return Company
     */
    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return Company
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set extPhone.
     *
     * @param string|null $extPhone
     *
     * @return Company
     */
    public function setExtPhone($extPhone = null)
    {
        $this->extPhone = $extPhone;

        return $this;
    }

    /**
     * Get extPhone.
     *
     * @return string|null
     */
    public function getExtPhone()
    {
        return $this->extPhone;
    }

    /**
     * Set fax.
     *
     * @param string|null $fax
     *
     * @return Company
     */
    public function setFax($fax = null)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax.
     *
     * @return string|null
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set registrationId.
     *
     * @param string|null $registrationId
     *
     * @return Company
     */
    public function setRegistrationId($registrationId = null)
    {
        $this->registrationId = $registrationId;

        return $this;
    }

    /**
     * Get registrationId.
     *
     * @return string|null
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    /**
     * Set taxId.
     *
     * @param string|null $taxId
     *
     * @return Company
     */
    public function setTaxId($taxId = null)
    {
        $this->taxId = $taxId;

        return $this;
    }

    /**
     * Get taxId.
     *
     * @return string|null
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * Set about.
     *
     * @param string|null $about
     *
     * @return Company
     */
    public function setAbout($about = null)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about.
     *
     * @return string|null
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Company
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Company
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
     * @return Company
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
     * @return Company
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
     * Get the value of isHq
     *
     * @return  int|null
     */
    public function getIsHq()
    {
        return $this->isHq;
    }

    /**
     * Set the value of isHq
     *
     * @param  int|null  $isHq
     *
     * @return  self
     */
    public function setIsHq($isHq)
    {
        $this->isHq = $isHq;

        return $this;
    }

    /**
     * Get the value of path
     *
     * @return  string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @param  string|null  $path
     *
     * @return  self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}
