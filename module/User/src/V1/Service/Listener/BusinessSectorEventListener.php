<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\BusinessSectorTrait as BusinessSectorMapperTrait;
use User\Entity\BusinessSector as BusinessSectorEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\BusinessSectorEvent;
use Zend\Log\Exception\RuntimeException;

class BusinessSectorEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use BusinessSectorMapperTrait;
    use AccountMapperTrait;

    protected $businessSectorEvent;
    protected $businessSectorHydrator;

    public function __construct(
        \User\Mapper\BusinessSector $businessSectorMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setBusinessSectorMapper($businessSectorMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            BusinessSectorEvent::EVENT_CREATE_BUSINESS_SECTOR,
            [$this, 'createBusinessSector'],
            500
        );
    }

    public function createBusinessSector(BusinessSectorEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $businessSectorEntity = new BusinessSectorEntity;
            $hydrateEntity  = $this->getBusinessSectorHydrator()->hydrate($bodyRequest, $businessSectorEntity);
            $entityResult   = $this->getBusinessSectorMapper()->save($hydrateEntity);
            $event->setBusinessSectorEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Business Sector {uuid} created successfully",
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
     * Get the value of businessSectorHydrator
     */
    public function getBusinessSectorHydrator()
    {
        return $this->businessSectorHydrator;
    }

    /**
     * Set the value of businessSectorHydrator
     *
     * @return  self
     */
    public function setBusinessSectorHydrator($businessSectorHydrator)
    {
        $this->businessSectorHydrator = $businessSectorHydrator;

        return $this;
    }
}
