<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\UserAccessTrait as UserAccessMapperTrait;
use User\Entity\UserAccess as UserAccessEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\UserAccessEvent;
use Zend\Log\Exception\RuntimeException;

class UserAccessEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use UserAccessMapperTrait;

    protected $config;
    protected $userAccessHydrator;

    public function __construct(
        \User\Mapper\UserAccess $userAccessMapper
    ) {
        $this->setUserAccessMapper($userAccessMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserAccessEvent::EVENT_CREATE_USER_ACCESS,
            [$this, 'createUserAccess'],
            500
        );

        $this->listeners[] = $events->attach(
            UserAccessEvent::EVENT_UPDATE_USER_ACCESS,
            [$this, 'updateUserAccess'],
            500
        );

        $this->listeners[] = $events->attach(
            UserAccessEvent::EVENT_DELETE_USER_ACCESS,
            [$this, 'deleteUserAccess'],
            500
        );
    }

    public function createUserAccess(UserAccessEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $userAccessEntity = new UserAccessEntity;
            $hydrateEntity  = $this->getUserAccessHydrator()->hydrate($bodyRequest, $userAccessEntity);
            $entityResult   = $this->getUserAccessMapper()->save($hydrateEntity);
            $event->setUserAccessEntity($entityResult);
            $uuid = $entityResult->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New User Access {uuid} created successfully",
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
     * Update UserAccess
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateUserAccess(UserAccessEvent $event)
    {
        try {
            $userAccessEntity = $event->getUserAccessEntity();
            $userAccessEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();

            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $userAccess = $this->getUserAccessHydrator()->hydrate($updateData, $userAccessEntity);
            $this->getUserAccessMapper()->save($userAccess);
            $uuid = $userAccess->getUuid();
            $event->setUserAccessEntity($userAccess);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: User Access {uuid} updated successfully",
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

    public function deleteUserAccess(UserAccessEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this ->getUserAccessMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data User Access deleted successfully",
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
     * Get the value of userAccessHydrator
     */
    public function getUserAccessHydrator()
    {
        return $this->userAccessHydrator;
    }

    /**
     * Set the value of userAccessHydrator
     *
     * @return  self
     */
    public function setUserAccessHydrator($userAccessHydrator)
    {
        $this->userAccessHydrator = $userAccessHydrator;

        return $this;
    }

    /**
     * Get the value of config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @return  self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }
}
