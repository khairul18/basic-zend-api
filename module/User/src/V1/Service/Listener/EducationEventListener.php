<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\EducationTrait as EducationMapperTrait;
use User\Entity\Education as EducationEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\EducationEvent;
use Zend\Log\Exception\RuntimeException;

class EducationEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use EducationMapperTrait;
    use AccountMapperTrait;

    protected $educationEvent;
    protected $educationHydrator;

    public function __construct(
        \User\Mapper\Education $educationMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setEducationMapper($educationMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            EducationEvent::EVENT_CREATE_EDUCATION,
            [$this, 'createEducation'],
            500
        );
    }

    public function createEducation(EducationEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $educationEntity = new EducationEntity;
            $hydrateEntity  = $this->getEducationHydrator()->hydrate($bodyRequest, $educationEntity);
            $entityResult   = $this->getEducationMapper()->save($hydrateEntity);
            $event->setEducationEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Education {uuid} created successfully",
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
     * Get the value of educationHydrator
     */
    public function getEducationHydrator()
    {
        return $this->educationHydrator;
    }

    /**
     * Set the value of educationHydrator
     *
     * @return  self
     */
    public function setEducationHydrator($educationHydrator)
    {
        $this->educationHydrator = $educationHydrator;

        return $this;
    }
}
