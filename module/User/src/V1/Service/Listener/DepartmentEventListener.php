<?php

namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\DepartmentTrait as DepartmentMapperTrait;
use User\Entity\Department as DepartmentEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\DepartmentEvent;
use Zend\Log\Exception\RuntimeException;

class DepartmentEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use DepartmentMapperTrait;
    use AccountMapperTrait;

    protected $departmentEvent;
    protected $departmentHydrator;

    public function __construct(
        \User\Mapper\Department $departmentMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setDepartmentMapper($departmentMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            DepartmentEvent::EVENT_CREATE_DEPARTMENT,
            [$this, 'createDepartment'],
            500
        );

        $this->listeners[] = $events->attach(
            DepartmentEvent::EVENT_UPDATE_DEPARTMENT,
            [$this, 'updateDepartment'],
            500
        );

        $this->listeners[] = $events->attach(
            DepartmentEvent::EVENT_DELETE_DEPARTMENT,
            [$this, 'deleteDepartment'],
            500
        );
    }

    public function createDepartment(DepartmentEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $departmentEntity = new DepartmentEntity;
            $hydrateEntity  = $this->getDepartmentHydrator()->hydrate($bodyRequest, $departmentEntity);
            $entityResult   = $this->getDepartmentMapper()->save($hydrateEntity);
            $event->setDepartmentEntity($entityResult);
            $uuid = $entityResult->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Department {uuid} created successfully",
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
     * Update Department
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateDepartment(DepartmentEvent $event)
    {
        try {
            $departmentEntity = $event->getDepartmentEntity();
            $departmentEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();

            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $department = $this->getDepartmentHydrator()->hydrate($updateData, $departmentEntity);
            $this->getDepartmentMapper()->save($department);
            $uuid = $department->getUuid();
            $event->setDepartmentEntity($department);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Department {uuid} updated successfully",
                [
                    "function" => __FUNCTION__,
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

    public function deleteDepartment(DepartmentEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this->getDepartmentMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data Department deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: " . $e->getMessage(), ["function" => __FUNCTION__]);
        }
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
}
