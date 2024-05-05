<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\DivisionCustomerTrait as DivisionCustomerMapperTrait;
use User\Entity\DivisionCustomer as DivisionCustomerEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\DivisionCustomerEvent;
use Zend\Log\Exception\RuntimeException;

class DivisionCustomerEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use DivisionCustomerMapperTrait;
    use AccountMapperTrait;

    protected $divisionCustomerEvent;
    protected $divisionCustomerHydrator;

    public function __construct(
        \User\Mapper\DivisionCustomer $divisionCustomerMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setDivisionCustomerMapper($divisionCustomerMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            DivisionCustomerEvent::EVENT_CREATE_DIVISION_CUSTOMER,
            [$this, 'createDivisionCustomer'],
            500
        );
    }

    public function createDivisionCustomer(DivisionCustomerEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $divisionCustomerEntity = new DivisionCustomerEntity;
            $hydrateEntity  = $this->getDivisionCustomerHydrator()->hydrate($bodyRequest, $divisionCustomerEntity);
            $entityResult   = $this->getDivisionCustomerMapper()->save($hydrateEntity);
            $event->setDivisionCustomerEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Division Customer {uuid} created successfully",
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
     * Get the value of divisionCustomerHydrator
     */
    public function getDivisionCustomerHydrator()
    {
        return $this->divisionCustomerHydrator;
    }

    /**
     * Set the value of divisionCustomerHydrator
     *
     * @return  self
     */
    public function setDivisionCustomerHydrator($divisionCustomerHydrator)
    {
        $this->divisionCustomerHydrator = $divisionCustomerHydrator;

        return $this;
    }
}
