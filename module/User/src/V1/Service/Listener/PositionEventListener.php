<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\PositionTrait as PositionMapperTrait;
use User\Entity\Position as PositionEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\PositionEvent;
use Zend\Log\Exception\RuntimeException;

class PositionEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use PositionMapperTrait;
    use AccountMapperTrait;

    protected $positionEvent;
    protected $positionHydrator;

    public function __construct(
        \User\Mapper\Position $positionMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setPositionMapper($positionMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            PositionEvent::EVENT_CREATE_POSITION,
            [$this, 'createPosition'],
            500
        );
    }

    public function createPosition(PositionEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $positionEntity = new PositionEntity;
            $hydrateEntity  = $this->getPositionHydrator()->hydrate($bodyRequest, $positionEntity);
            $entityResult   = $this->getPositionMapper()->save($hydrateEntity);
            $event->setPositionEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Position {uuid} created successfully",
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

    /**
     * Get the value of positionHydrator
     */
    public function getPositionHydrator()
    {
        return $this->positionHydrator;
    }

    /**
     * Set the value of positionHydrator
     *
     * @return  self
     */
    public function setPositionHydrator($positionHydrator)
    {
        $this->positionHydrator = $positionHydrator;

        return $this;
    }
}
