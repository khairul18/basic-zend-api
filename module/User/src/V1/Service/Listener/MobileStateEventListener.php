<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Entity\UserProfile as UserProfileEntity;
use Psr\Log\LoggerAwareTrait;
use User\V1\MobileStateEvent;
use ZF\ApiProblem\ApiProblem;

class MobileStateEventListener implements ListenerAggregateInterface
{

    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $userProfileMapper;
    protected $userProfileHydrator;

    public function __construct(
        UserProfileMapper $userProfileMapper,
        DoctrineObject $userProfileHydrator
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserProfileHydrator($userProfileHydrator);
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MobileStateEvent::EVENT_SAVE_MOBILE_STATE,
            [$this, 'saveMobileState'],
            499
        );
    }

    public function saveMobileState(MobileStateEvent $event)
    {
        try {
            $userEntity = $event->getUserEntity();
            $mobileStateData  = $event->getMobileStateData();
            $mobileStateData  = (array) $mobileStateData;
            $mobileState      = $this->getUserProfileHydrator()->hydrate($mobileStateData, $userEntity);
            $this->getUserProfileMapper()->save($mobileState);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : {uuid} New data updated successfully! : ",
                ["function" => __FUNCTION__, "uuid" => $mobileState->getUuid()]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something Error! {message}",
                ["function" => __FUNCTION__, "message" => $e->getMessage()]
            );
        }
    }

    public function setUserProfileMapper(UserProfileMapper $userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    public function getUserProfileHydrator()
    {
        return $this->userProfileHydrator;
    }

    public function setUserProfileHydrator($userProfileHydrator)
    {
        $this->userProfileHydrator = $userProfileHydrator;
    }
}
