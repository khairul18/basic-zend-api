<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserProfile
 */
class UserProfile implements EntityInterface
{
    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $workemail;

    /**
     * @var string|null
     */
    private $drivingLicence;

    /**
     * @var \DateTime|null
     */
    private $firstDate;

    /**
     * @var string|null
     */
    private $workphone;

    /**
     * @var string|null
     */
    private $pob;

    /**
     * @var string|null
     */
    private $maritalStatus;

    /**
     * @var string|null
     */
    private $addressCurrent;

    /**
     * @var string|null
     */
    private $relationPrimaryName;

    /**
     * @var string|null
     */
    private $relationPrimaryPhone;

    /**
     * @var string|null
     */
    private $relationshipPrimary;

    /**
     * @var string|null
     */
    private $relationSecondaryName;

    /**
     * @var string|null
     */
    private $relationSecondaryPhone;

    /**
     * @var string|null
     */
    private $relationshipSecondary;

    /**
     * @var string|null
     */
    private $jobDesk;

    /**
     * @var string|null
     */
    private $nickName;

    /**
     * @var string|null
     */
    private $ficNumber;

    /**
     * @var string|null
     */
    private $icNumber;

    /**
     * @var string|null
     */
    private $secret;

    /**
     * @var string|null
     */
    private $facetempToken;

    /**
     * @var string|null
     */
    private $atacToken;

    /**
     * @var string|null
     */
    private $staffId;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var string|null
     */
    private $currentAddress;

    /**
     * @var string|null
     */
    private $role;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var string|null
     */
    private $mobile;

    /**
     * @var \DateTime|null
     */
    private $dob;

    /**
     * @var string|null
     */
    private $gender;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var string|null
     */
    private $postalCode;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $identityType;

    /**
     * @var string|null
     */
    private $nationality;

    /**
     * @var string|null
     */
    private $bloodType;

    /**
     * @var string|null
     */
    private $timezone;

    /**
     * @var string|null
     */
    private $photo;

    /**
     * @var bool
     */
    private $isActive = '0';

    /**
     * @var string|null
     */
    private $firebaseId;

    /**
     * @var string|null
     */
    private $androidDeviceId;

    /**
     * @var string|null
     */
    private $iosDeviceToken;

    /**
     * @var string|null
     */
    private $androidLastState;

    /**
     * @var string|null
     */
    private $signature;

    /**
     * @var string|null
     */
    private $latitude;

    /**
     * @var string|null
     */
    private $longitude;

    /**
     * @var integer
     */
    private $questionnaireCounter = '0';

    /**
     * @var \DateTime|null
     */
    private $lastQuestionnaireAt;

    /**
     * @var integer
     */
    private $lastScore;

    /**
     * @var integer
     */
    private $leaveQuota;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \User\Entity\Department
     */
    private $department;

    /**
     * @var \User\Entity\Company
     */
    private $company;

    /**
     * @var \User\Entity\Branch
     */
    private $branch;

    // /**
    //  * @var \Job\Entity\Job
    //  */
    // private $jobActivity;

    // /**
    //  * @var \Vehicle\Entity\VehicleRequest
    //  */
    // private $drivingActivity;

    /**
     * @var \User\Entity\Position
     */
    private $position;

    /**
     * @var \User\Entity\EmploymentType
     */
    private $employmentType;

    /**
     * @var \User\Entity\UserProfile
     */
    private $parent;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUsers
     */
    private $username;

    /**
     * @var \QRCode\Entity\QRCode
     */
    private $qrCode;

    /**
     * @var \User\Entity\UserActivation
     */
    private $userActivation;

    /**
     * @var ArrayCollection
     */
    private $educations;

    /**
     * @var ArrayCollection
     */
    private $userDocument;

    /**
     * @var ArrayCollection
     */
    private $allowedModules;

    /**
     * @var ArrayCollection
     */
    private $roleDownStream;

    // /**
    //  * @var ArrayCollection
    //  */
    // private $attendance;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->educations = new ArrayCollection();
        $this->userDocument = new ArrayCollection();
        $this->allowedModules = new ArrayCollection();
        $this->roleDownStream = new ArrayCollection();
        // $this->attendance = new ArrayCollection();
    }

    /**
     * Get the value of userActivation
     *
     * @return  \User\Entity\UserActivation
     */
    public function getUserActivation()
    {
        return $this->userActivation;
    }

    /**
     * Set the value of userActivation
     *
     * @param  \User\Entity\UserActivation  $userActivation
     *
     * @return  self
     */
    public function setUserActivation(\User\Entity\UserActivation $userActivation)
    {
        $this->userActivation = $userActivation;

        return $this;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return UserProfile
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
     * Set ficNumber.
     *
     * @param string|null $ficNumber
     *
     * @return UserProfile
     */
    public function setFicNumber($ficNumber = null)
    {
        $this->ficNumber = $ficNumber;

        return $this;
    }

    /**
     * Get ficNumber.
     *
     * @return string|null
     */
    public function getFicNumber()
    {
        return $this->ficNumber;
    }

    /**
     * Set icNumber.
     *
     * @param string|null $icNumber
     *
     * @return UserProfile
     */
    public function setIcNumber($icNumber = null)
    {
        $this->icNumber = $icNumber;

        return $this;
    }

    /**
     * Get icNumber.
     *
     * @return string|null
     */
    public function getIcNumber()
    {
        return $this->icNumber;
    }

    /**
     * Set secret.
     *
     * @param string|null $secret
     *
     * @return UserProfile
     */
    public function setSecret($secret = null)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Get secret.
     *
     * @return string|null
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return UserProfile
     */
    public function setFirstName($firstName = null)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string|null $lastName
     *
     * @return UserProfile
     */
    public function setLastName($lastName = null)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set currentAddress.
     *
     * @param string|null $currentAddress
     *
     * @return UserProfile
     */
    public function setCurrentAddress($currentAddress = null)
    {
        $this->currentAddress = $currentAddress;

        return $this;
    }

    /**
     * Get currentAddress.
     *
     * @return string|null
     */
    public function getCurrentAddress()
    {
        return $this->currentAddress;
    }

    /**
     * Set role.
     *
     * @param string|null $role
     *
     * @return UserProfile
     */
    public function setRole($role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return string|null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return UserProfile
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
     * Set mobile.
     *
     * @param string|null $mobile
     *
     * @return UserProfile
     */
    public function setMobile($mobile = null)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile.
     *
     * @return string|null
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set dob.
     *
     * @param \DateTime|null $dob
     *
     * @return UserProfile
     */
    public function setDob($dob = null)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob.
     *
     * @return \DateTime|null
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set gender.
     *
     * @param string|null $gender
     *
     * @return UserProfile
     */
    public function setGender($gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string|null
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set address.
     *
     * @param string|null $address
     *
     * @return UserProfile
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
     * Set city.
     *
     * @param string|null $city
     *
     * @return UserProfile
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postalCode.
     *
     * @param string|null $postalCode
     *
     * @return UserProfile
     */
    public function setPostalCode($postalCode = null)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode.
     *
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set country.
     *
     * @param string|null $country
     *
     * @return UserProfile
     */
    public function setCountry($country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set identityType.
     *
     * @param string|null $identityType
     *
     * @return UserProfile
     */
    public function setIdentityType($identityType = null)
    {
        $this->identityType = $identityType;

        return $this;
    }

    /**
     * Get identityType.
     *
     * @return string|null
     */
    public function getIdentityType()
    {
        return $this->identityType;
    }

    /**
     * Set nationality.
     *
     * @param string|null $nationality
     *
     * @return UserProfile
     */
    public function setNationality($nationality = null)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality.
     *
     * @return string|null
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set bloodType.
     *
     * @param string|null $bloodType
     *
     * @return UserProfile
     */
    public function setBloodType($bloodType = null)
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    /**
     * Get bloodType.
     *
     * @return string|null
     */
    public function getBloodType()
    {
        return $this->bloodType;
    }

    /**
     * Set timezone.
     *
     * @param string|null $timezone
     *
     * @return UserProfile
     */
    public function setTimezone($timezone = null)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone.
     *
     * @return string|null
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set photo.
     *
     * @param string|null $photo
     *
     * @return UserProfile
     */
    public function setPhoto($photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return string|null
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return UserProfile
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set firebaseId.
     *
     * @param string|null $firebaseId
     *
     * @return UserProfile
     */
    public function setFirebaseId($firebaseId = null)
    {
        $this->firebaseId = $firebaseId;

        return $this;
    }

    /**
     * Get firebaseId.
     *
     * @return string|null
     */
    public function getFirebaseId()
    {
        return $this->firebaseId;
    }

    /**
     * Set androidDeviceId.
     *
     * @param string|null $androidDeviceId
     *
     * @return UserProfile
     */
    public function setAndroidDeviceId($androidDeviceId = null)
    {
        $this->androidDeviceId = $androidDeviceId;

        return $this;
    }

    /**
     * Get androidDeviceId.
     *
     * @return string|null
     */
    public function getAndroidDeviceId()
    {
        return $this->androidDeviceId;
    }

    /**
     * Set iosDeviceToken.
     *
     * @param string|null $iosDeviceToken
     *
     * @return UserProfile
     */
    public function setIosDeviceToken($iosDeviceToken = null)
    {
        $this->iosDeviceToken = $iosDeviceToken;

        return $this;
    }

    /**
     * Get iosDeviceToken.
     *
     * @return string|null
     */
    public function getIosDeviceToken()
    {
        return $this->iosDeviceToken;
    }

    /**
     * Set androidLastState.
     *
     * @param string|null $androidLastState
     *
     * @return UserProfile
     */
    public function setAndroidLastState($androidLastState = null)
    {
        $this->androidLastState = $androidLastState;

        return $this;
    }

    /**
     * Get androidLastState.
     *
     * @return string|null
     */
    public function getAndroidLastState()
    {
        return $this->androidLastState;
    }

    /**
     * Set signature.
     *
     * @param string|null $signature
     *
     * @return UserProfile
     */
    public function setSignature($signature = null)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature.
     *
     * @return string|null
     */
    public function getSignature()
    {
        return $this->signature;
    }
    /**
     * Set latitude.
     *
     * @param string|null $latitude
     *
     * @return UserProfile
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return string|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param string|null $longitude
     *
     * @return UserProfile
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return string|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return UserProfile
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
     * @return UserProfile
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
     * @return UserProfile
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
     * Add child.
     *
     * @param \User\Entity\UserProfile $child
     *
     * @return UserProfile
     */
    public function addChild(\User\Entity\UserProfile $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child.
     *
     * @param \User\Entity\UserProfile $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\User\Entity\UserProfile $child)
    {
        return $this->children->removeElement($child);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set account.
     *
     * @param \User\Entity\Account|null $account
     *
     * @return UserProfile
     */
    public function setAccount(\User\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account.
     *
     * @return \User\Entity\Account|null
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set parent.
     *
     * @param \User\Entity\UserProfile|null $parent
     *
     * @return UserProfile
     */
    public function setParent(\User\Entity\UserProfile $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \User\Entity\UserProfile|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set username.
     *
     * @param \Aqilix\OAuth2\Entity\OauthUsers|null $username
     *
     * @return UserProfile
     */
    public function setUsername(\Aqilix\OAuth2\Entity\OauthUsers $username = null)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return \Aqilix\OAuth2\Entity\OauthUsers|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the value of qrCode
     *
     * @return  \QRCode\Entity\QRCode
     */
    public function getQrCode()
    {
        return $this->qrCode;
    }

    /**
     * Set the value of qrCode
     *
     * @param  \QRCode\Entity\QRCode  $qrCode
     *
     * @return  self
     */
    public function setQrCode(\QRCode\Entity\QRCode $qrCode)
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    /**
     * @return integer
     */
    public function getQuestionnaireCounter()
    {
        return $this->questionnaireCounter;
    }

    /**
     * @param integer $questionnaireCounter
     *
     * @return self
     */
    public function setQuestionnaireCounter($questionnaireCounter)
    {
        $this->questionnaireCounter = $questionnaireCounter;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastQuestionnaireAt()
    {
        return $this->lastQuestionnaireAt;
    }

    /**
     * @param \DateTime|null $lastQuestionnaireAt
     *
     * @return self
     */
    public function setLastQuestionnaireAt($lastQuestionnaireAt)
    {
        $this->lastQuestionnaireAt = $lastQuestionnaireAt;

        return $this;
    }

    /**
     * Get the value of lastScore
     *
     * @return  integer
     */
    public function getLastScore()
    {
        return $this->lastScore;
    }

    /**
     * Set the value of lastScore
     *
     * @param  integer  $lastScore
     *
     * @return  self
     */
    public function setLastScore($lastScore)
    {
        $this->lastScore = $lastScore;

        return $this;
    }

    /**
     * Get the value of department
     *
     * @return  \User\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set the value of department
     *
     * @param  \User\Entity\Department  $department
     *
     * @return  self
     */
    public function setDepartment(\User\Entity\Department $department)
    {
        $this->department = $department;

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
     * Get the value of leaveQuota
     *
     * @return  integer
     */
    public function getLeaveQuota()
    {
        return $this->leaveQuota;
    }

    /**
     * Set the value of leaveQuota
     *
     * @param  integer  $leaveQuota
     *
     * @return  self
     */
    public function setLeaveQuota($leaveQuota)
    {
        $this->leaveQuota = $leaveQuota;

        return $this;
    }

    /**
     * Get the value of drivingLicence
     *
     * @return  string|null
     */
    public function getDrivingLicence()
    {
        return $this->drivingLicence;
    }

    /**
     * Set the value of drivingLicence
     *
     * @param  string|null  $drivingLicence
     *
     * @return  self
     */
    public function setDrivingLicence($drivingLicence)
    {
        $this->drivingLicence = $drivingLicence;

        return $this;
    }

    /**
     * Get the value of firstDate
     *
     * @return  \DateTime|null
     */
    public function getFirstDate()
    {
        return $this->firstDate;
    }

    /**
     * Set the value of firstDate
     *
     * @param  \DateTime|null  $firstDate
     *
     * @return  self
     */
    public function setFirstDate($firstDate)
    {
        $this->firstDate = $firstDate;

        return $this;
    }

    /**
     * Get the value of pob
     *
     * @return  string|null
     */
    public function getPob()
    {
        return $this->pob;
    }

    /**
     * Set the value of pob
     *
     * @param  string|null  $pob
     *
     * @return  self
     */
    public function setPob($pob)
    {
        $this->pob = $pob;

        return $this;
    }

    /**
     * Get the value of maritalStatus
     *
     * @return  string|null
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * Set the value of maritalStatus
     *
     * @param  string|null  $maritalStatus
     *
     * @return  self
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    /**
     * Get the value of addressCurrent
     *
     * @return  string|null
     */
    public function getAddressCurrent()
    {
        return $this->addressCurrent;
    }

    /**
     * Set the value of addressCurrent
     *
     * @param  string|null  $addressCurrent
     *
     * @return  self
     */
    public function setAddressCurrent($addressCurrent)
    {
        $this->addressCurrent = $addressCurrent;

        return $this;
    }

    /**
     * Get the value of relationPrimaryName
     *
     * @return  string|null
     */
    public function getRelationPrimaryName()
    {
        return $this->relationPrimaryName;
    }

    /**
     * Set the value of relationPrimaryName
     *
     * @param  string|null  $relationPrimaryName
     *
     * @return  self
     */
    public function setRelationPrimaryName($relationPrimaryName)
    {
        $this->relationPrimaryName = $relationPrimaryName;

        return $this;
    }

    /**
     * Get the value of relationPrimaryPhone
     *
     * @return  string|null
     */
    public function getRelationPrimaryPhone()
    {
        return $this->relationPrimaryPhone;
    }

    /**
     * Set the value of relationPrimaryPhone
     *
     * @param  string|null  $relationPrimaryPhone
     *
     * @return  self
     */
    public function setRelationPrimaryPhone($relationPrimaryPhone)
    {
        $this->relationPrimaryPhone = $relationPrimaryPhone;

        return $this;
    }

    /**
     * Get the value of relationshipPrimary
     *
     * @return  string|null
     */
    public function getRelationshipPrimary()
    {
        return $this->relationshipPrimary;
    }

    /**
     * Set the value of relationshipPrimary
     *
     * @param  string|null  $relationshipPrimary
     *
     * @return  self
     */
    public function setRelationshipPrimary($relationshipPrimary)
    {
        $this->relationshipPrimary = $relationshipPrimary;

        return $this;
    }

    /**
     * Get the value of relationSecondaryName
     *
     * @return  string|null
     */
    public function getRelationSecondaryName()
    {
        return $this->relationSecondaryName;
    }

    /**
     * Set the value of relationSecondaryName
     *
     * @param  string|null  $relationSecondaryName
     *
     * @return  self
     */
    public function setRelationSecondaryName($relationSecondaryName)
    {
        $this->relationSecondaryName = $relationSecondaryName;

        return $this;
    }

    /**
     * Get the value of relationSecondaryPhone
     *
     * @return  string|null
     */
    public function getRelationSecondaryPhone()
    {
        return $this->relationSecondaryPhone;
    }

    /**
     * Set the value of relationSecondaryPhone
     *
     * @param  string|null  $relationSecondaryPhone
     *
     * @return  self
     */
    public function setRelationSecondaryPhone($relationSecondaryPhone)
    {
        $this->relationSecondaryPhone = $relationSecondaryPhone;

        return $this;
    }

    /**
     * Get the value of relationshipSecondary
     *
     * @return  string|null
     */
    public function getRelationshipSecondary()
    {
        return $this->relationshipSecondary;
    }

    /**
     * Set the value of relationshipSecondary
     *
     * @param  string|null  $relationshipSecondary
     *
     * @return  self
     */
    public function setRelationshipSecondary($relationshipSecondary)
    {
        $this->relationshipSecondary = $relationshipSecondary;

        return $this;
    }

    /**
     * Get the value of jobDesk
     *
     * @return  string|null
     */
    public function getJobDesk()
    {
        return $this->jobDesk;
    }

    /**
     * Set the value of jobDesk
     *
     * @param  string|null  $jobDesk
     *
     * @return  self
     */
    public function setJobDesk($jobDesk)
    {
        $this->jobDesk = $jobDesk;

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
     * Get the value of nickName
     *
     * @return  string|null
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set the value of nickName
     *
     * @param  string|null  $nickName
     *
     * @return  self
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * Get the value of workemail
     *
     * @return  string|null
     */
    public function getWorkemail()
    {
        return $this->workemail;
    }

    /**
     * Set the value of workemail
     *
     * @param  string|null  $workemail
     *
     * @return  self
     */
    public function setWorkemail($workemail)
    {
        $this->workemail = $workemail;

        return $this;
    }

    /**
     * Get the value of workphone
     *
     * @return  string|null
     */
    public function getWorkphone()
    {
        return $this->workphone;
    }

    /**
     * Set the value of workphone
     *
     * @param  string|null  $workphone
     *
     * @return  self
     */
    public function setWorkphone($workphone)
    {
        $this->workphone = $workphone;

        return $this;
    }

    /**
     * Get the value of educations
     *
     * @return  ArrayCollection
     */
    public function getEducations()
    {
        return $this->educations;
    }

    /**
     * Set the value of educations
     *
     * @param  ArrayCollection  $educations
     *
     * @return  self
     */
    public function setEducations(ArrayCollection $educations)
    {
        $this->educations = $educations;

        return $this;
    }

    /**
     * Get the value of userDocument
     *
     * @return  ArrayCollection
     */
    public function getUserDocument()
    {
        return $this->userDocument;
    }

    /**
     * Set the value of userDocument
     *
     * @param  ArrayCollection  $userDocument
     *
     * @return  self
     */
    public function setUserDocument(ArrayCollection $userDocument)
    {
        $this->userDocument = $userDocument;

        return $this;
    }

    /**
     * Get the value of allowedModules
     *
     * @return  ArrayCollection
     */
    public function getAllowedModules()
    {
        return $this->allowedModules;
    }

    /**
     * Set the value of allowedModules
     *
     * @param  ArrayCollection  $allowedModules
     *
     * @return  self
     */
    public function setAllowedModules($allowedModules)
    {
        $this->allowedModules = $allowedModules;

        return $this;
    }

    /**
     * Get the value of position
     *
     * @return  \User\Entity\Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the value of position
     *
     * @param  \User\Entity\Position  $position
     *
     * @return  self
     */
    public function setPosition(\User\Entity\Position $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get the value of employmentType
     *
     * @return  \User\Entity\EmploymentType
     */
    public function getEmploymentType()
    {
        return $this->employmentType;
    }

    /**
     * Set the value of employmentType
     *
     * @param  \User\Entity\EmploymentType  $employmentType
     *
     * @return  self
     */
    public function setEmploymentType(\User\Entity\EmploymentType $employmentType)
    {
        $this->employmentType = $employmentType;

        return $this;
    }

    /**
     * Get the value of facetempToken
     *
     * @return  string|null
     */
    public function getFacetempToken()
    {
        return $this->facetempToken;
    }

    /**
     * Set the value of facetempToken
     *
     * @param  string|null  $facetempToken
     *
     * @return  self
     */
    public function setFacetempToken($facetempToken)
    {
        $this->facetempToken = $facetempToken;

        return $this;
    }

    /**
     * Get the value of atacToken
     *
     * @return  string|null
     */
    public function getAtacToken()
    {
        return $this->atacToken;
    }

    /**
     * Set the value of atacToken
     *
     * @param  string|null  $atacToken
     *
     * @return  self
     */
    public function setAtacToken($atacToken)
    {
        $this->atacToken = $atacToken;

        return $this;
    }

    /**
     * Get the value of staffId
     *
     * @return  string|null
     */
    public function getStaffId()
    {
        return $this->staffId;
    }

    /**
     * Set the value of staffId
     *
     * @param  string|null  $staffId
     *
     * @return  self
     */
    public function setStaffId($staffId)
    {
        $this->staffId = $staffId;

        return $this;
    }

    // /**
    //  * Get the value of jobActivity
    //  *
    //  * @return  \Job\Entity\Job|null
    //  */
    // public function getJobActivity()
    // {
    //     return $this->jobActivity;
    // }

    // /**
    //  * Set the value of jobActivity
    //  *
    //  * @param  \Job\Entity\Job  $jobActivity
    //  *
    //  * @return  self
    //  */
    // public function setJobActivity(\Job\Entity\Job $jobActivity = null)
    // {
    //     $this->jobActivity = $jobActivity;

    //     return $this;
    // }

    // /**
    //  * Get the value of drivingActivity
    //  *
    //  * @return  \Vehicle\Entity\VehicleRequest|null
    //  */
    // public function getDrivingActivity()
    // {
    //     return $this->drivingActivity;
    // }

    // /**
    //  * Set the value of drivingActivity
    //  *
    //  * @param  \Vehicle\Entity\VehicleRequest  $drivingActivity
    //  *
    //  * @return  self
    //  */
    // public function setDrivingActivity(\Vehicle\Entity\VehicleRequest $drivingActivity = null)
    // {
    //     $this->drivingActivity = $drivingActivity;

    //     return $this;
    // }

    /**
     * Get the value of roleDownStream
     *
     * @return  ArrayCollection
     */
    public function getRoleDownStream()
    {
        return $this->roleDownStream;
    }

    /**
     * Set the value of roleDownStream
     *
     * @param  ArrayCollection  $roleDownStream
     *
     * @return  self
     */
    public function setRoleDownStream($roleDownStream)
    {
        $this->roleDownStream = $roleDownStream;

        return $this;
    }

    // /**
    //  * Add attendance.
    //  *
    //  * @param \Attendance\Entity\Attendance $attendance
    //  *
    //  * @return UserProfile
    //  */
    // public function addAttendance(\Attendance\Entity\Attendance $attendance)
    // {
    //     $this->attendance[] = $attendance;

    //     return $this;
    // }

    // /**
    //  * Remove attendance.
    //  *
    //  * @param \Attendance\Entity\Attendance $attendance
    //  *
    //  * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
    //  */
    // public function removeAttendance(\Attendance\Entity\Attendance $attendance)
    // {
    //     return $this->attendance->removeElement($attendance);
    // }

    // /**
    //  * Get attendance.
    //  *
    //  * @return \Doctrine\Common\Collections\Collection
    //  */
    // public function getAttendance()
    // {
    //     return $this->attendance;
    // }
}
