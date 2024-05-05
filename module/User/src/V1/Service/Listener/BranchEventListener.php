<?php

namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use User\Mapper\BranchTrait as BranchMapperTrait;
use User\Entity\Branch as BranchEntity;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\BranchEvent;

class BranchEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use LoggerAwareTrait;
    use UserProfileMapperTrait;
    use BranchMapperTrait;

    protected $branchEvent;
    protected $branchHydrator;



    public function __construct(
        \User\Mapper\UserProfile $userProfileMapper,
        \User\Mapper\Branch $branchMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setBranchMapper($branchMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            BranchEvent::EVENT_CREATE_BRANCH,
            [$this, 'createBranch'],
            500
        );

        $this->listeners[] = $events->attach(
            BranchEvent::EVENT_UPDATE_BRANCH,
            [$this, 'updateBranch'],
            500
        );

        $this->listeners[] = $events->attach(
            BranchEvent::EVENT_DELETE_BRANCH,
            [$this, 'deleteBranch'],
            500
        );
    }


    public function createBranch(BranchEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $branchEntity = new BranchEntity;
            $branch = $this->getBranchHydrator()->hydrate($data, $branchEntity);
            $result = $this->getBranchMapper()->save($branch);
            $event->setBranchEntity($branch);
            $uuid = $result->getUuid();
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: New Branch data created successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: " . $e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function updateBranch(BranchEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $data = $event->getInputFilter()->getValues();
            $branchEntity = $event->getBranchEntity();
            $hydrate = $this->getBranchHydrator()->hydrate($data, $branchEntity);
            $result = $this->getBranchMapper()->save($hydrate);
            $uuid = $result->getUuid();
            $event->setBranchEntity($result);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Branch data updated successfully\nData : {data}",
                [
                    'uuid' => $uuid,
                    "data" => json_encode($data),
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: " . $e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function deleteBranch(BranchEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this->getBranchMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: " . $e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    public function setBranchHydrator($branchHydrator)
    {
        $this->BranchHydrator = $branchHydrator;
    }

    public function getBranchHydrator()
    {
        return $this->BranchHydrator;
    }
}
