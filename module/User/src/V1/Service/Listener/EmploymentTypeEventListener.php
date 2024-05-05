<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\EmploymentTypeTrait as EmploymentTypeMapperTrait;
use User\Entity\EmploymentType as EmploymentTypeEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\EmploymentTypeEvent;
use Zend\Log\Exception\RuntimeException;

class EmploymentTypeEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use EmploymentTypeMapperTrait;
    use AccountMapperTrait;

    protected $employmentTypeEvent;
    protected $employmentTypeHydrator;

    public function __construct(
        \User\Mapper\EmploymentType $employmentTypeMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setEmploymentTypeMapper($employmentTypeMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            EmploymentTypeEvent::EVENT_CREATE_EMPLOYMENT_TYPE,
            [$this, 'createEmploymentType'],
            500
        );
    }

    public function createEmploymentType(EmploymentTypeEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $employmentTypeEntity = new EmploymentTypeEntity;
            $hydrateEntity  = $this->getEmploymentTypeHydrator()->hydrate($bodyRequest, $employmentTypeEntity);
            $entityResult   = $this->getEmploymentTypeMapper()->save($hydrateEntity);
            $event->setEmploymentTypeEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Employment Type {uuid} created successfully",
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
     * Get the value of employmentTypeHydrator
     */
    public function getEmploymentTypeHydrator()
    {
        return $this->employmentTypeHydrator;
    }

    /**
     * Set the value of employmentTypeHydrator
     *
     * @return  self
     */
    public function setEmploymentTypeHydrator($employmentTypeHydrator)
    {
        $this->employmentTypeHydrator = $employmentTypeHydrator;

        return $this;
    }
}
