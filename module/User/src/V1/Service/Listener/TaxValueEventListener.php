<?php

namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\TaxValueTrait as TaxValueMapperTrait;
use User\Entity\TaxValue as TaxValueEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\TaxValueEvent;
use Zend\Log\Exception\RuntimeException;

class TaxValueEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use TaxValueMapperTrait;
    use AccountMapperTrait;

    protected $taxValueEvent;
    protected $taxValueHydrator;

    public function __construct(
        \User\Mapper\TaxValue $taxValueMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setTaxValueMapper($taxValueMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            TaxValueEvent::EVENT_CREATE_TAX_VALUE,
            [$this, 'createTaxValue'],
            500
        );
        $this->listeners[] = $events->attach(
            TaxValueEvent::EVENT_UPDATE_TAX_VALUE,
            [$this, 'updateTaxValue'],
            500
        );
    }

    public function createTaxValue(TaxValueEvent $event)
    {
        try {
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $taxValueEntity = new TaxValueEntity;
            $hydrateEntity  = $this->getTaxValueHydrator()->hydrate($bodyRequest, $taxValueEntity);
            $entityResult   = $this->getTaxValueMapper()->save($hydrateEntity);
            $event->setTaxValueEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Tax Value {uuid} created successfully",
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

    public function updateTaxValue(TaxValueEvent $event)
    {
        try {
            $taxValueEntity = $event->getTaxValueEntity();
            $taxValueEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();

            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $taxValue = $this->getTaxValueHydrator()->hydrate($updateData, $taxValueEntity);
            $this->getTaxValueMapper()->save($taxValue);
            $uuid = $taxValue->getUuid();
            $event->setTaxValueEntity($taxValue);
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
     * Get the value of taxValueHydrator
     */
    public function getTaxValueHydrator()
    {
        return $this->taxValueHydrator;
    }

    /**
     * Set the value of taxValueHydrator
     *
     * @return  self
     */
    public function setTaxValueHydrator($taxValueHydrator)
    {
        $this->taxValueHydrator = $taxValueHydrator;

        return $this;
    }
}
