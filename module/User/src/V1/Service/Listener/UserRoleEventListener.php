<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\UserRoleTrait as UserRoleMapperTrait;
use User\Entity\UserRole as UserRoleEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\UserRoleEvent;
use Zend\Log\Exception\RuntimeException;

class UserRoleEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use UserRoleMapperTrait;
    use AccountMapperTrait;

    protected $userRoleEvent;
    protected $userRoleHydrator;

    public function __construct(
        \User\Mapper\UserRole $userRoleMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setUserRoleMapper($userRoleMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserRoleEvent::EVENT_CREATE_USER_ROLE,
            [$this, 'createUserRole'],
            500
        );

        $this->listeners[] = $events->attach(
            UserRoleEvent::EVENT_UPDATE_USER_ROLE,
            [$this, 'updateUserRole'],
            500
        );
    }

    public function createUserRole(UserRoleEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();
            $bodyRequest['name'] = strtoupper($bodyRequest['name']);

            $userRoleEntity = new UserRoleEntity;
            $hydrateEntity  = $this->getUserRoleHydrator()->hydrate($bodyRequest, $userRoleEntity);
            $entityResult   = $this->getUserRoleMapper()->save($hydrateEntity);
            $event->setUserRoleEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New UserRole {uuid} created successfully",
                [
                    "function" => __FUNCTION__,
                    "uuid" => $entityResult->getUuid()
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

    public function updateUserRole(UserRoleEvent $event)
    {
        try {
            $userRoleEntity = $event->getUserRoleEntity();
            $userRoleEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();
            $updateData['name'] = strtoupper($updateData['name']);
            
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $userRole = $this->getUserRoleHydrator()->hydrate($updateData, $userRoleEntity);
            $this->getUserRoleMapper()->save($userRole);
            $uuid = $userRole->getUuid();
            $event->setUserRoleEntity($userRole);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: UserRole {uuid} updated successfully",
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

    /**
     * Get the value of userRoleHydrator
     */
    public function getUserRoleHydrator()
    {
        return $this->userRoleHydrator;
    }

    /**
     * Set the value of userRoleHydrator
     *
     * @return  self
     */
    public function setUserRoleHydrator($userRoleHydrator)
    {
        $this->userRoleHydrator = $userRoleHydrator;

        return $this;
    }
}
