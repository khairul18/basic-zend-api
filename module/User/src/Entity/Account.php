<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable as TimestampableTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable as SoftDeleteableTrait;

/**
 * Account
 */
class Account implements EntityInterface
{
    use TimestampableTrait;

    use SoftDeleteableTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $note;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string|null
     */
    private $currency;

    /**
     * @var string
     */
    private $countryId;

    /**
     * @var string|null
     */
    private $fcmBroadcastTopic;

    /**
     * @var string|null
     */
    private $timezone;

    /**
     * @var string|null
     */
    private $locale;

    /**
     * @var string
     */
    private $uuid;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Account
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
     * Set note
     *
     * @param string $note
     *
     * @return Account
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
     * Set email
     *
     * @param string $email
     *
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Account
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Account
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Account
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Account
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set countryId
     *
     * @param string $countryId
     *
     * @return Account
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return string
     */
    public function getCountryId()
    {
        return $this->countryId;
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
     * Get the value of currency
     *
     * @return  string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @param  string|null  $currency
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of timezone
     *
     * @return  string|null
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set the value of timezone
     *
     * @param  string|null  $timezone
     *
     * @return  self
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get the value of locale
     *
     * @return  string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the value of locale
     *
     * @param  string|null  $locale
     *
     * @return  self
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the value of fcmBroadcastTopic
     *
     * @return  string|null
     */
    public function getFcmBroadcastTopic()
    {
        return $this->fcmBroadcastTopic;
    }

    /**
     * Set the value of fcmBroadcastTopic
     *
     * @param  string|null  $fcmBroadcastTopic
     *
     * @return  self
     */
    public function setFcmBroadcastTopic($fcmBroadcastTopic)
    {
        $this->fcmBroadcastTopic = $fcmBroadcastTopic;

        return $this;
    }
}
