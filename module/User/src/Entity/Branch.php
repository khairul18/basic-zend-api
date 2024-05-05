<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable as TimestampableTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable as SoftDeleteableTrait;

/**
 * Branch
 */
class Branch implements EntityInterface
{
    use TimestampableTrait;

    use SoftDeleteableTrait;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $exchangeId;

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
    private $email;

    /**
     * @var int|null
     */
    private $isActive = '1';

    /**
     * @var string
     */
    private $note;

    /**
     * @var int|null
     */
    private $geofence = '0';

    /**
     * @var float|null
     */
    private $geofenceRadius = '60.00';

    /**
     * @var float|null
     */
    private $latitude;

    /**
     * @var float|null
     */
    private $longitude;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\Company
     */
    private $company;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Branch
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set account
     *
     * @param string $account
     *
     * @return Branch
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set exchangeId
     *
     * @param string $exchangeId
     *
     * @return Branch
     */
    public function setExchangeId($exchangeId)
    {
        $this->exchangeId = $exchangeId;

        return $this;
    }

    /**
     * Get exchangeId
     *
     * @return string
     */
    public function getExchangeId()
    {
        return $this->exchangeId;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Branch
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Get the value of geofence
     *
     * @return  int|null
     */
    public function getGeofence()
    {
        return $this->geofence;
    }

    /**
     * Set the value of geofence
     *
     * @param  int|null  $geofence
     *
     * @return  self
     */
    public function setGeofence($geofence)
    {
        $this->geofence = $geofence;

        return $this;
    }

    /**
     * Set geofenceRadius.
     *
     * @param float|null $geofenceRadius
     *
     * @return Branch
     */
    public function setGeofenceRadius($geofenceRadius = null)
    {
        $this->geofenceRadius = $geofenceRadius;

        return $this;
    }

    /**
     * Get geofenceRadius.
     *
     * @return float|null
     */
    public function getGeofenceRadius()
    {
        return $this->geofenceRadius;
    }

    /**
     * Set latitude.
     *
     * @param float|null $latitude
     *
     * @return Branch
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param float|null $longitude
     *
     * @return Branch
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
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
     * Get the value of address
     *
     * @return  string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @param  string|null  $address
     *
     * @return  self
     */
    public function setAddress($address)
    {
        $this->address = $address;

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
