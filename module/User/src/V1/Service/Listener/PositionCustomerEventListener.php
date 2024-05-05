<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\PositionCustomerTrait as PositionCustomerMapperTrait;
use User\Entity\PositionCustomer as PositionCustomerEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\PositionCustomerEvent;
use Zend\Log\Exception\RuntimeException;

class PositionCustomerEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use PositionCustomerMapperTrait;
    use AccountMapperTrait;

    protected $positionCustomerEvent;
    protected $positionCustomerHydrator;

    public function __construct(
        \User\Mapper\PositionCustomer $positionCustomerMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setPositionCustomerMapper($positionCustomerMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            PositionCustomerEvent::EVENT_CREATE_POSITION_CUSTOMER,
            [$this, 'createPositionCustomer'],
            500
        );
    }

    public function createPositionCustomer(PositionCustomerEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $positionCustomerEntity = new PositionCustomerEntity;
            $hydrateEntity  = $this->getPositionCustomerHydrator()->hydrate($bodyRequest, $positionCustomerEntity);
            $entityResult   = $this->getPositionCustomerMapper()->save($hydrateEntity);
            $event->setPositionCustomerEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Position Customer {uuid} created successfully",
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
     * Get the value of positionCustomerHydrator
     */
    public function getPositionCustomerHydrator()
    {
        return $this->positionCustomerHydrator;
    }

    /**
     * Set the value of positionCustomerHydrator
     *
     * @return  self
     */
    public function setPositionCustomerHydrator($positionCustomerHydrator)
    {
        $this->positionCustomerHydrator = $positionCustomerHydrator;

        return $this;
    }
}
