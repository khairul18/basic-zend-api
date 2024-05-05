<?php

namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use Aqilix\OAuth2\Mapper\OauthUsers as UserMapper;
use User\Mapper\UserProfile as UserProfileMapper;
use User\OAuth2\Adapter\PdoAdapter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\V1\ProfileEvent;
use User\V1\UserSecret;

use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use User\Mapper\EducationTrait as EducationMapperTrait;
use User\Entity\Education as EducationEntity;
use User\Mapper\UserDocumentTrait as UserDocumentMapperTrait;
use User\Entity\UserDocument as UserDocumentEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Log\Exception\RuntimeException;
use Doctrine\Common\Collections\ArrayCollection;

class ProfileEventListener implements ListenerAggregateInterface
{
    use EventManagerAwareTrait;
    use UserProfileMapperTrait;
    use EducationMapperTrait;
    use UserDocumentMapperTrait;

    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $config;
    protected $userMapper;
    protected $userProfileMapper;
    protected $userProfileHydrator;

    protected $fileConfig;
    protected $profileEvent;
    protected $userDocumentHydrator;

    /**
     * Constructor
     *
     * @param UserProfileMapper   $userProfileMapper
     * @param UserProfileHydrator $userProfileHydrator
     * @param array $config
     */
    public function __construct(
        UserMapper $userMapper,
        UserProfileMapper $userProfileMapper,
        DoctrineObject $userProfileHydrator,
        array $config = [],
        \User\Mapper\Education $educationMapper,
        \User\Mapper\UserDocument $userDocumentMapper
    ) {
        $this->setUserMapper($userMapper);
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserProfileHydrator($userProfileHydrator);
        $this->setConfig($config);
        $this->setEducationMapper($educationMapper);
        $this->setUserDocumentMapper($userDocumentMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            ProfileEvent::EVENT_CREATE_PROFILE,
            [$this, 'createUser'],
            500
        );

        $this->listeners[] = $events->attach(
            ProfileEvent::EVENT_CREATE_PROFILE,
            [$this, 'saveEducations'],
            499
        );

        $this->listeners[] = $events->attach(
            ProfileEvent::EVENT_UPDATE_PROFILE,
            [$this, 'updateProfile'],
            500
        );

        $this->listeners[] = $events->attach(
            ProfileEvent::EVENT_UPDATE_PROFILE,
            [$this, 'updateEducations'],
            499
        );

        $this->listeners[] = $events->attach(
            ProfileEvent::EVENT_DELETE_PROFILE,
            [$this, 'deleteProfile'],
            499
        );
    }


    public function saveEducations(ProfileEvent $event)
    {
        try {
            $bodyRequest = $event->getInputFilter()->getValues();
            $userProfileEntity = $event->getUserProfileEntity();
            $optionFields = $event->getOptionFields();
            $this->logger->log(
                \Psr\Log\LogLevel::DEBUG,
                "{function}: Education Fields data @ provilEventListener \n =========> {data}",
                [
                    "function" => __FUNCTION__,
                    "data" => json_encode($optionFields)
                ]
            );

            foreach ($optionFields as $option) {
                $educationEntity = new EducationEntity;
                $educationEntity->setLevelEducation($option->levelEducation);
                $educationEntity->setSchoolName($option->schoolName);
                $educationEntity->setGraduatedYear($option->graduatedYear);
                $educationEntity->setUser($userProfileEntity);
                $saveEducation = $this->getEducationMapper()->save($educationEntity);
                $eduArray[] = $saveEducation;

                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function}: {uuid} Education Fields saved successfully",
                    [
                        "function" => __FUNCTION__,
                        "uuid" => $saveEducation->getUuid()
                    ]
                );
            }

            if (!is_null($eduArray) || count($eduArray) > 0) {
                $eduArrayCollection = new ArrayCollection($eduArray);
                $userProfileEntity->setEducations($eduArrayCollection);
                $this->getUserProfileMapper()->save($userProfileEntity);
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

    public function updateEducations(ProfileEvent $event)
    {
        try {
            $bodyRequest = $event->getInputFilter()->getValues();
            $userProfileEntity = $event->getUserProfileEntity();
            $optionFields = $event->getOptionFields();
            $counter = 0;
            $this->logger->log(
                \Psr\Log\LogLevel::DEBUG,
                "{function}: Education Fields data @ provilEventListener \n =========> {data}",
                [
                    "function" => __FUNCTION__,
                    "data" => json_encode($optionFields)
                ]
            );
            foreach ($optionFields as $option) {
                $educationEntity  = $this->getEducationMapper()->fetchOneBy([
                    'uuid' => $option->uuid
                ]);
                if (is_null($option->schoolName)) {
                    continue;
                }
                if (is_null($educationEntity)) {
                    $educationEntity = new EducationEntity;
                    $educationEntity->setUser($userProfileEntity);
                }
                $educationEntity->setLevelEducation($option->levelEducation);
                $educationEntity->setSchoolName($option->schoolName);
                $educationEntity->setGraduatedYear($option->graduatedYear);

                $saveEducation = $this->getEducationMapper()->save($educationEntity);
                $counter += 1;
                $eduArray[] = $saveEducation;

                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function}: {uuid} Education Fields updated successfully",
                    [
                        "function" => __FUNCTION__,
                        "uuid"  => $saveEducation->getUuid()
                    ]
                );
            }

            if (!is_null($eduArray) || count($eduArray) > 0) {
                $eduArrayCollection = new ArrayCollection($eduArray);
                $userProfileEntity->setEducations($eduArrayCollection);
                $this->getUserProfileMapper()->save($userProfileEntity);
            }

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: {counter} Education Fields updated",
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

    public function createUser(ProfileEvent $event)
    {
        try {
            $userSecret = new UserSecret;
            $strSecret  = $userSecret->generateUserSecret();
            $userData   = $event->getInputFilter()->getValues();
            $userData['signature'] = $userData['signature']['tmp_name'];
            $userData = str_replace("data", "signature", $userData);

            unset($userData['educations']);
            $username   = $userData['username'];
            $timezone   = $userData['timezone'];
            $checkUser  = $this->getUserMapper()->fetchOneBy([
                'username' => $username
            ]);
            if (!is_null($checkUser)) {
                $userProfileData = $this->getUserProfileMapper()->fetchOneBy([
                    "username" => $checkUser->getUsername()
                ]);

                if (!is_null($checkUser) && is_null($userProfileData)) {
                    $event->stopPropagation(true);
                    $message = "Cannot Registering User. Deleted user data still exist. Please contact developer";
                    return new \User\V1\Service\Exception\RuntimeException($message);
                }

                $event->stopPropagation(true);
                return new \User\V1\Service\Exception\RuntimeException('User already registed!');
            }

            $user = new \Aqilix\OAuth2\Entity\OauthUsers;
            $userProfile = new \User\Entity\UserProfile;
            $password   = $this->getUserMapper()
                ->getPasswordHash($userData['password']);

            $userOAuth = $this->getUserProfileHydrator()->hydrate($userData, $user);

            $userOAuth->setUsername($username);
            $userOAuth->setPassword($password);
            $userOAuth->setAccount($userData['account']);
            $this->getUserMapper()->save($userOAuth);

            $hydrateEntity  = $this->getUserProfileHydrator()->hydrate($userData, $userProfile);
            $hydrateEntity->setUsername($userOAuth);
            $hydrateEntity->setTimezone($timezone);
            $hydrateEntity->setIsActive('1');
            $hydrateEntity->setSecret(substr($strSecret, 8));
            $entityResult = $this->getUserProfileMapper()->save($hydrateEntity);
            $event->setUserProfileEntity($entityResult);

            $this->saveUserDocument($userData, $entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid} {userProfileUuid} {accountUuid}",
                [
                    "function" => __FUNCTION__,
                    "uuid"     => $entityResult->getUsername(),
                    "userProfileUuid"  => $entityResult->getUuid(),
                    "accountUuid"      => $entityResult->getAccount(),
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {data} {message}",
                [
                    "data" => json_encode($entityResult),
                    "message"  => $e->getMessage(),
                    "function" => __FUNCTION__,
                ]
            );
            return $e;
        }
    }

    public function saveUserDocument($userData, $entityResult)
    {
        try {
            $fileConfig = $this->getFileConfig();
            $maxUploadPhoto = $fileConfig['max_uploaded_photo'];

            for ($i = 1; $i <= 5; $i++) {
                $key = (string) $i;
                $docKey = 'doc' . $key;
                $typeKey = 'type' . $key;
                $noteKey = 'note' . $key;
                if (!isset($userData[$docKey])) {
                    continue;
                }
                $tmpName = $userData[$docKey]['tmp_name'];
                $typeData = $userData[$typeKey];
                $noteData = $userData[$noteKey];
                $newPath = str_replace('data/doc/user-document/', 'user-document/', $tmpName);
                $userData["path"] = $newPath;
                $userData["type"] = $typeData;
                $userData["note"] = $noteData;
                $userData['user'] = $entityResult->getUuid();

                $userDocumentEntity = new UserDocumentEntity;
                $hydrate = $this->getUserDocumentHydrator()->hydrate($userData, $userDocumentEntity);
                $result  = $this->getUserDocumentMapper()->save($hydrate);
                $uuidRes = $result->getUuid();

                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function}: Data user-document {uuid} saved successfully",
                    [
                        "function" => __FUNCTION__,
                        "uuid" => $uuidRes
                    ]
                );
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
     * Update Profile
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateProfile(ProfileEvent $event)
    {
        try {
            $userProfileEntity = $event->getUserProfileEntity();

            $updateData  = $event->getUpdateData();
            $updateData['signature'] = $updateData['signature']['tmp_name'];
            $userProfile = str_replace("data", "signature", $updateData);
            // add file input filter here
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }
            $userData   = $event->getInputFilter()->getValues();
            unset($userData['educations']);
            // adding filter for photo
            $inputPhoto  = $event->getInputFilter()->get('photo');
            $inputPhoto->getFilterChain()
                ->attach(new \Zend\Filter\File\RenameUpload([
                    'target' => $this->getConfig()['backup_dir'],
                    'randomize' => true,
                    'use_upload_extension' => true
                ]));
            $userProfile = $this->getUserProfileHydrator()->hydrate($updateData, $userProfileEntity);
            $this->getUserProfileMapper()->save($userProfile);
            $event->setUserProfileEntity($userProfile);
            $this->saveUserDocument($userData, $userProfile);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username}",
                [
                    "function" => __FUNCTION__,
                    "username" => $userProfileEntity->getUsername()
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    public function deleteProfile(ProfileEvent $event)
    {
        $requiermentParams = "";
        try {
            $profileData  = $event->getDeleteProfile();
            $userData    = $profileData['userProfile'];
            $deletedUuid = $profileData['uuid'];

            $checkProfileAsChild = $this->getUserProfileMapper()->fetchOneBy(['parent' => $deletedUuid]);
            if (isset($checkProfileAsChild)) {
                $parentUuid = $checkProfileAsChild->getParent();

                //delete parentProfile
                $parentProfile = $this->getUserProfileMapper()->fetchOneBy([
                    'uuid' => $parentUuid
                ]);
                if (is_null($parentProfile)) {
                    $event->stopPropagation(true);
                    return new \User\V1\Service\Exception\RuntimeException('Profile not exist!');
                }
                $this->getUserProfileMapper()->delete($parentProfile);
                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function} {uuid} {firstName} deleted user parent and All child!",
                    [
                        "function" => __FUNCTION__,
                        "uuid"     => $deletedUuid,
                        "firstName"  => $parentProfile->getFirstName(),
                    ]
                );

                //delete all child on parent
                $childProfile = $this->getUserProfileMapper()->fetchBy([
                    'parent' => $parentUuid
                ]);
                foreach ($childProfile as $result) {
                    $this->getUserProfileMapper()->delete($result);
                }
            } else {
                $checkProfile = $this->getUserProfileMapper()->fetchOneBy(['uuid' => $deletedUuid]);
                $this->getUserProfileMapper()->delete($checkProfile);
                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function} {uuid} {firstName} deleted!",
                    [
                        "function" => __FUNCTION__,
                        "uuid"     => $deletedUuid,
                        "firstName"  => $checkProfile->getFirstName(),
                    ]
                );
            }
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {message}",
                [
                    "message"  => $e->getMessage(),
                    "function" => __FUNCTION__,
                ]
            );
            return $e;
        }
    }

    /**
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return the $userProfileMapper
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * @param UserProfileMapper $userProfileMapper
     */
    public function setUserProfileMapper(UserProfileMapper $userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * @return the $userProfileHydrator
     */
    public function getUserProfileHydrator()
    {
        return $this->userProfileHydrator;
    }

    /**
     * @param DoctrineObject $userProfileHydrator
     */
    public function setUserProfileHydrator($userProfileHydrator)
    {
        $this->userProfileHydrator = $userProfileHydrator;
    }

    /**
     * Get the value of userMapper
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }

    /**
     * Set the value of userMapper
     *
     * @return  self
     */
    public function setUserMapper($userMapper)
    {
        $this->userMapper = $userMapper;

        return $this;
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
     * Get the value of profileEvent
     */
    public function getProfileEvent()
    {
        return $this->profileEvent;
    }

    /**
     * Set the value of profileEvent
     *
     * @return  self
     */
    public function setProfileEvent($profileEvent)
    {
        $this->profileEvent = $profileEvent;

        return $this;
    }

    /**
     * Get the value of userDocumentHydrator
     */
    public function getUserDocumentHydrator()
    {
        return $this->userDocumentHydrator;
    }

    /**
     * Set the value of userDocumentHydrator
     *
     * @return  self
     */
    public function setUserDocumentHydrator($userDocumentHydrator)
    {
        $this->userDocumentHydrator = $userDocumentHydrator;

        return $this;
    }
}
