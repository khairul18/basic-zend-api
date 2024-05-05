<?php
namespace Department\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use Department\Mapper\GroupTrait as GroupMapperTrait;
use Department\Entity\Group as GroupEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Department\V1\GroupEvent;
use Zend\Log\Exception\RuntimeException;

class GroupEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use GroupMapperTrait;
    use AccountMapperTrait;

    protected $groupEvent;
    protected $groupHydrator;

    public function __construct(
        \Department\Mapper\Group $groupMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setGroupMapper($groupMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            GroupEvent::EVENT_CREATE_GROUP,
            [$this, 'createGroup'],
            500
        );

        $this->listeners[] = $events->attach(
            GroupEvent::EVENT_UPDATE_GROUP,
            [$this, 'updateGroup'],
            500
        );

        $this->listeners[] = $events->attach(
            GroupEvent::EVENT_DELETE_GROUP,
            [$this, 'deleteGroup'],
            500
        );
    }

    public function createGroup(GroupEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $groupEntity = new GroupEntity;
            $hydrateEntity  = $this->getGroupHydrator()->hydrate($bodyRequest, $groupEntity);
            $entityResult   = $this->getGroupMapper()->save($hydrateEntity);
            $event->setGroupEntity($entityResult);
            $uuid = $entityResult->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Group {uuid} created successfully",
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
     * Update Group
     *
     * @param SignupEvent $event
     * @return void|\Exception
     */
    public function updateGroup(GroupEvent $event)
    {
        try {
            $groupEntity = $event->getGroupEntity();
            $groupEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();

            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $group = $this->getGroupHydrator()->hydrate($updateData, $groupEntity);
            $this->getGroupMapper()->save($group);
            $uuid = $group->getUuid();
            $event->setGroupEntity($group);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Group {uuid} updated successfully",
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

    public function deleteGroup(GroupEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this ->getGroupMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data Group deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }

    /**
     * Get the value of groupHydrator
     */
    public function getGroupHydrator()
    {
        return $this->groupHydrator;
    }

    /**
     * Set the value of groupHydrator
     *
     * @return  self
     */
    public function setGroupHydrator($groupHydrator)
    {
        $this->groupHydrator = $groupHydrator;

        return $this;
    }
}
