<?php
namespace User\V1\Service\Listener;

use ZF\ApiProblem\ApiProblem;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\V1\UserActivatedEvent;
use User\Entity\UserProfile as UserProfileEntity;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;

class UserActivatedEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use UserProfileMapperTrait;
    use LoggerAwareTrait;

    /**
     * @var array
     */
    protected $config;

    /**
     *
     * @var DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    protected $userActivatedHydrator;

    public function __construct(
        $userProfileMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserActivatedEvent::EVENT_USER_ACTIVATED,
            [$this, 'userActivated'],
            500
        );
    }

    public function userActivated(UserActivatedEvent $event)
    {
        try {
            $userActivatedData   = $event->getUserActivatedData();
            $userProfileEntity = new UserProfileEntity;
            $userActivated = $this->getUserActivatedHydrator()->hydrate($userActivatedData, $userProfileEntity);
            $this->getUserProfileMapper()->save($userActivated);
            $event->setUserActivatedEntity($userActivated);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid} {data}",
                [
                    "uuid" => $userActivated->getUuid(),
                    "data" => json_encode($userActivatedData),
                    "function" => __FUNCTION__,
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {uuid} {data} {message}",
                [
                    "uuid" => $userActivated->getUuid(),
                    "data" => json_encode($userActivatedData),
                    "message"  => $e->getMessage(),
                    "function" => __FUNCTION__,
                ]
            );
            return $e;
        }
    }

    /**
     * Get the value of userActivatedHydrator
     */
    public function getUserActivatedHydrator()
    {
        return $this->userActivatedHydrator;
    }

    /**
     * Set the value of userActivatedHydrator
     *
     * @return  self
     */
    public function setUserActivatedHydrator($userActivatedHydrator)
    {
        $this->userActivatedHydrator = $userActivatedHydrator;

        return $this;
    }
}
