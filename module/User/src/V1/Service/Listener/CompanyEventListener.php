<?php

namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\CompanyTrait as CompanyMapperTrait;
use User\Mapper\BranchTrait as BranchMapperTrait;
use User\Mapper\DepartmentTrait as DepartmentMapperTrait;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use User\Entity\Company as CompanyEntity;
use User\V1\CompanyEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Log\Exception\RuntimeException;
use Zend\Validator\Uuid;

class CompanyEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use CompanyMapperTrait;
    use BranchMapperTrait;
    use DepartmentMapperTrait;
    use AccountMapperTrait;
    use UserProfileMapperTrait;

    protected $fileConfig;
    protected $companyEvent;
    protected $companyHydrator;
    protected $branchHydrator;
    protected $departmentHydrator;
    protected $userProfileHydrator;

    public function __construct(
        \User\Mapper\Company $companyMapper,
        \User\Mapper\Branch $branchMapper,
        \User\Mapper\Department $departmentMapper,
        \User\Mapper\Account $accountMapper,
        \User\Mapper\UserProfile $userProfileMapper
    ) {
        $this->setCompanyMapper($companyMapper);
        $this->setBranchMapper($branchMapper);
        $this->setDepartmentMapper($departmentMapper);
        $this->setAccountMapper($accountMapper);
        $this->setUserProfileMapper($userProfileMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            CompanyEvent::EVENT_CREATE_COMPANY,
            [$this, 'createCompany'],
            500
        );

        $this->listeners[] = $events->attach(
            CompanyEvent::EVENT_UPDATE_COMPANY,
            [$this, 'updateCompany'],
            500
        );

        $this->listeners[] = $events->attach(
            CompanyEvent::EVENT_DELETE_COMPANY,
            [$this, 'deleteCompany'],
            500
        );

        $this->listeners[] = $events->attach(
            CompanyEvent::EVENT_DIVISION_COMPANY,
            [$this, 'divisionCompany'],
            500
        );
    }

    public function createCompany(CompanyEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }
            $fileConfig = $this->getFileConfig()['company'];
            $destinationFolder = $fileConfig['photo_dir'];
            $bodyRequest = $event->getInputFilter()->getValues();

            $companyEntity = new CompanyEntity;

            $tmpName = $bodyRequest['photo']['tmp_name'];
            $newPath = str_replace($destinationFolder, 'photo/company', $tmpName);
            $bodyRequest["path"] = $newPath;

            $hydrateEntity  = $this->getCompanyHydrator()->hydrate($bodyRequest, $companyEntity);

            $entityResult   = $this->getCompanyMapper()->save($hydrateEntity);
            $event->setCompanyEntity($entityResult);
            $uuid = $entityResult->getUuid();
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Company data {uuid} created successfully",
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

    /**
     * Update Company
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateCompany(CompanyEvent $event)
    {
        try {
            $companyEntity = $event->getCompanyEntity();
            $companyEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();
            $fileConfig = $this->getFileConfig()['company'];
            $destinationFolder = $fileConfig['photo_dir'];
            // unset photo for now. Still stuck
            // unset($updateData['photo']);
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            // test 1
            // adding filter for photo
            // $imgIcon = $event->getInputFilter()->get('photo')->getValue();
            // // var_dump($imgIcon);
            // if (isset($imgIcon)) {
            //     $inputPhoto  = $event->getInputFilter()->get('photo');
            //     $inputPhoto->getFilterChain()
            //     ->attach(new \Zend\Filter\File\RenameUpload([
            //         'target' => $destinationFolder,
            //         'use_upload_extension' => true,
            //         'overwrite' => true
            //         ]));
            //     $updateData['path']  = str_replace('data/', '', $imgIcon['tmp_name']);
            //     // var_dump($updateData['path']);
            //     $nameIconSmall = $updateData['path'];
            //     $event->getInputFilter()->get('photo')->setValue($nameIconSmall);
            // }

            // test 2
            $companyPath = $companyEntity->getPath();
            var_dump($companyPath);
            $tmpName = $updateData['photo']['tmp_name'];
            if ($tmpName != "") {
                $newPath = str_replace('data/', '', $tmpName);
                $companyPath = $newPath;
                var_dump($companyPath);
            }

            $company = $this->getCompanyHydrator()->hydrate($updateData, $companyEntity);

            // if using test 2
            $company->setPath($companyPath);
            $this->getCompanyMapper()->save($company);
            $uuid = $company->getUuid();
            $event->setCompanyEntity($company);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Company data {uuid} updated successfully \n {data}",
                [
                    "function" => __FUNCTION__,
                    "uuid" => $uuid,
                    "data" => json_encode($updateData),
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

    public function deleteCompany(CompanyEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this->getCompanyMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data company deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: " . $e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function divisionCompany(CompanyEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }
            $inputFilter = $event->getInputFilter()->getValues();
            $level = $event->getInputFilter()->getValues()['level'];
            $isActive = $event->getInputFilter()->getValues()['isActive'];
            if ($level == 'personal') {
                $userProfileEntity = $event->getUserProfileEntity();
                $userProfileEntity->setUpdatedAt(new \DateTime('now'));
                $userProfileEntity->setIsActive($isActive);

                $hydrateEntity  = $this->getUserProfileHydrator()->hydrate($inputFilter, $userProfileEntity);
                $entityResult   = $this->getUserProfileMapper()->save($hydrateEntity);
                $event->setUserProfileEntity($entityResult);
                $uuid = $userProfileEntity->getUuid();
            } elseif ($level == 'department') {
                $departmentEntity = $event->getDepartmentEntity();
                $departmentEntity->setUpdatedAt(new \DateTime('now'));
                $departmentEntity->setIsActive($isActive);

                $hydrateEntity  = $this->getDepartmentHydrator()->hydrate($inputFilter, $departmentEntity);
                $entityResult   = $this->getDepartmentMapper()->save($hydrateEntity);
                $event->setDepartmentEntity($entityResult);
                $uuid = $departmentEntity->getUuid();
            } elseif ($level == 'branch') {
                $branchEntity = $event->getBranchEntity();
                $branchEntity->setUpdatedAt(new \DateTime('now'));
                $branchEntity->setIsActive($isActive);

                $hydrateEntity  = $this->getBranchHydrator()->hydrate($inputFilter, $branchEntity);
                $entityResult   = $this->getBranchMapper()->save($hydrateEntity);
                $event->setBranchEntity($entityResult);
                $uuid = $branchEntity->getUuid();
            } elseif ($level == 'company') {
                $companyEntity = $event->getCompanyEntity();
                $companyEntity->setUpdatedAt(new \DateTime('now'));
                $companyEntity->setIsActive($isActive);

                $hydrateEntity  = $this->getCompanyHydrator()->hydrate($inputFilter, $companyEntity);
                $entityResult   = $this->getCompanyMapper()->save($hydrateEntity);
                $event->setCompanyEntity($entityResult);
                $uuid = $companyEntity->getUuid();
            }

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: {uuid} - {level} data updated successfully",
                [
                    "function" => __FUNCTION__,
                    "level" => $level,
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

    /**
     * Get the value of companyHydrator
     */
    public function getCompanyHydrator()
    {
        return $this->companyHydrator;
    }

    /**
     * Set the value of companyHydrator
     *
     * @return  self
     */
    public function setCompanyHydrator($companyHydrator)
    {
        $this->companyHydrator = $companyHydrator;

        return $this;
    }

    /**
     * Get the value of branchHydrator
     */
    public function getBranchHydrator()
    {
        return $this->branchHydrator;
    }

    /**
     * Set the value of branchHydrator
     *
     * @return  self
     */
    public function setBranchHydrator($branchHydrator)
    {
        $this->branchHydrator = $branchHydrator;

        return $this;
    }

    /**
     * Get the value of departmentHydrator
     */
    public function getDepartmentHydrator()
    {
        return $this->departmentHydrator;
    }

    /**
     * Set the value of departmentHydrator
     *
     * @return  self
     */
    public function setDepartmentHydrator($departmentHydrator)
    {
        $this->departmentHydrator = $departmentHydrator;

        return $this;
    }

    /**
     * Get the value of userProfileHydrator
     */
    public function getUserProfileHydrator()
    {
        return $this->userProfileHydrator;
    }

    /**
     * Set the value of userProfileHydrator
     *
     * @return  self
     */
    public function setUserProfileHydrator($userProfileHydrator)
    {
        $this->userProfileHydrator = $userProfileHydrator;

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
}
