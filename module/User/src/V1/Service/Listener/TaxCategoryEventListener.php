<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\TaxCategoryTrait as TaxCategoryMapperTrait;
use User\Entity\TaxCategory as TaxCategoryEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\TaxCategoryEvent;
use Zend\Log\Exception\RuntimeException;

class TaxCategoryEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use TaxCategoryMapperTrait;
    use AccountMapperTrait;

    protected $taxCategoryEvent;
    protected $taxCategoryHydrator;

    public function __construct(
        \User\Mapper\TaxCategory $taxCategoryMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setTaxCategoryMapper($taxCategoryMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            TaxCategoryEvent::EVENT_CREATE_TAX_CATEGORY,
            [$this, 'createTaxCategory'],
            500
        );
    }

    public function createTaxCategory(TaxCategoryEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $taxCategoryEntity = new TaxCategoryEntity;
            $hydrateEntity  = $this->getTaxCategoryHydrator()->hydrate($bodyRequest, $taxCategoryEntity);
            $entityResult   = $this->getTaxCategoryMapper()->save($hydrateEntity);
            $event->setTaxCategoryEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Tax Category {uuid} created successfully",
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
     * Get the value of taxCategoryHydrator
     */
    public function getTaxCategoryHydrator()
    {
        return $this->taxCategoryHydrator;
    }

    /**
     * Set the value of taxCategoryHydrator
     *
     * @return  self
     */
    public function setTaxCategoryHydrator($taxCategoryHydrator)
    {
        $this->taxCategoryHydrator = $taxCategoryHydrator;

        return $this;
    }
}
