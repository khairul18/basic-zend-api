<?php
namespace Department\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use Department\Mapper\GroupUserTrait as GroupUserMapperTrait;
use Department\Entity\GroupUser as GroupUserEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Department\V1\GroupUserEvent;
use Zend\Log\Exception\RuntimeException;

class GroupUserEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use GroupUserMapperTrait;
    use AccountMapperTrait;

    protected $groupUserEvent;
    protected $groupUserHydrator;

    public function __construct(
        \Department\Mapper\GroupUser $groupUserMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setGroupUserMapper($groupUserMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            GroupUserEvent::EVENT_CREATE_GROUP_USER,
            [$this, 'createGroupUser'],
            500
        );

        $this->listeners[] = $events->attach(
            GroupUserEvent::EVENT_UPDATE_GROUP_USER,
            [$this, 'updateGroupUser'],
            500
        );

        $this->listeners[] = $events->attach(
            GroupUserEvent::EVENT_DELETE_GROUP_USER,
            [$this, 'deleteGroupUser'],
            500
        );
    }

    public function createGroupUser(GroupUserEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $groupUserEntity = new GroupUserEntity;
            $hydrateEntity  = $this->getGroupUserHydrator()->hydrate($bodyRequest, $groupUserEntity);
            $entityResult   = $this->getGroupUserMapper()->save($hydrateEntity);
            $event->setGroupUserEntity($entityResult);
            $uuid = $entityResult->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Group User {uuid} created successfully",
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
     * Update GroupUser
     *
     * @param SignupEvent $event
     * @return void|\Exception
     */
    public function updateGroupUser(GroupUserEvent $event)
    {
        try {
            $groupUserEntity = $event->getGroupUserEntity();
            $groupUserEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();

            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $groupUser = $this->getGroupUserHydrator()->hydrate($updateData, $groupUserEntity);
            $this->getGroupUserMapper()->save($groupUser);
            $uuid = $groupUser->getUuid();
            $event->setGroupUserEntity($groupUser);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Group User {uuid} updated successfully",
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

    public function deleteGroupUser(GroupUserEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this ->getGroupUserMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data Group User deleted successfully",
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
     * Get the value of groupUserHydrator
     */
    public function getGroupUserHydrator()
    {
        return $this->groupUserHydrator;
    }

    /**
     * Set the value of groupUserHydrator
     *
     * @return  self
     */
    public function setGroupUserHydrator($groupUserHydrator)
    {
        $this->groupUserHydrator = $groupUserHydrator;

        return $this;
    }
}
