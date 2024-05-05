<?php

namespace User\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use User\Entity\Supplier as SupplierEntity;
use User\Mapper\Supplier as SupplierMapper;
use User\V1\SupplierEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class SupplierEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $supplierMapper;
    protected $supplierHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \User\Mapper\Supplier  $supplierMapper
     * @param  mixed  $supplierHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        SupplierMapper $supplierMapper,
        $supplierHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->supplierMapper = $supplierMapper;
        $this->supplierHydrator = $supplierHydrator;
        $this->logger = $logger;
    }

    /**
     * @param  \Zend\EventManager\EventManagerInterface  $events
     * @param  int  $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            SupplierEvent::EVENT_CREATE_SUPPLIER,
            [$this, 'createUserSupplier'],
            500
        );
        $this->listeners[] = $events->attach(
            SupplierEvent::EVENT_UPDATE_SUPPLIER,
            [$this, 'updateUserSupplier'],
            500
        );
        $this->listeners[] = $events->attach(
            SupplierEvent::EVENT_DELETE_SUPPLIER,
            [$this, 'deleteUserSupplier'],
            500
        );
    }

    /**
     * @param  \User\V1\SupplierEvent  $event
     * @return \Exception|null
     */
    public function createUserSupplier(SupplierEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();

            // $bodyRequest['threadAttach'] = $bodyRequest['threadAttach']['tmp_name'];
            // $bodyRequest = str_replace("data", "assets", $bodyRequest);
            $hydratedEntity = $this->supplierHydrator
                ->hydrate(
                    $bodyRequest,
                    new SupplierEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->supplierMapper->save($hydratedEntity);
            if (!$entity instanceof SupplierEntity)
                throw new \Exception('$entity is not an instance of SupplierEntity');

            $event->setSupplier($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New forum thread data {uuid} created successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $entity->getUuid(),
                ]
            );
        } catch (RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }

    /**
     * @param  \User\V1\SupplierEvent  $event
     * @return \Exception|null
     */
    public function updateUserSupplier(SupplierEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            // $bodyRequest['threadAttach'] = $bodyRequest['threadAttach']['tmp_name'];
            // $bodyRequest = str_replace("data", "assets", $bodyRequest);
            $currentEntity = $event->getSupplier();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->supplierHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->supplierMapper->save($hydratedEntity);
            if (!$entity instanceof SupplierEntity)
                throw new \Exception('$entity is not an instance of SupplierEntity');

            $event->setSupplier($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : User Supplier data {uuid} updated successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $entity->getUuid(),
                ]
            );
        } catch (RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }

    /**
     * @param  \User\V1\SupplierEvent  $event
     * @return \Exception|null
     */
    public function deleteUserSupplier(SupplierEvent $event)
    {
        try {
            $targetEntity = $event->getSupplier();
            $this->supplierMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : User Supplier data {uuid} deleted successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $targetEntity->getUuid(),
                ]
            );
        } catch (RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }
}
