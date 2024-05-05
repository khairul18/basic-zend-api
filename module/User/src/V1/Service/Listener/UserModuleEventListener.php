<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\UserModuleTrait as UserModuleMapperTrait;
use User\Entity\UserModule as UserModuleEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\UserModuleEvent;
use Zend\Log\Exception\RuntimeException;

class UserModuleEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use UserModuleMapperTrait;
    use AccountMapperTrait;

    protected $userModuleEvent;
    protected $userModuleHydrator;

    public function __construct(
        \User\Mapper\UserModule $userModuleMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setUserModuleMapper($userModuleMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserModuleEvent::EVENT_CREATE_USER_MODULE,
            [$this, 'createUserModule'],
            500
        );

        $this->listeners[] = $events->attach(
            UserModuleEvent::EVENT_UPDATE_USER_MODULE,
            [$this, 'updateUserModule'],
            500
        );
    }

    public function createUserModule(UserModuleEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();
            $bodyRequest['name'] = ucwords($bodyRequest['name']);

            $userModuleEntity = new UserModuleEntity;
            $tmpName = $bodyRequest['photo']['tmp_name'];
            if (! is_null($tmpName)) {
                $newPath = str_replace('data/photo/icon-module/', 'photo/icon-module/', $tmpName);
                $bodyRequest["path"] = $newPath;
            }
            $hydrateEntity  = $this->getUserModuleHydrator()->hydrate($bodyRequest, $userModuleEntity);
            $entityResult   = $this->getUserModuleMapper()->save($hydrateEntity);
            $event->setUserModuleEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New User Module {uuid} created successfully",
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

    public function updateUserModule(UserModuleEvent $event)
    {
        try {
            $userModuleEntity = $event->getUserModuleEntity();
            $userModuleEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();
            $updateData['name'] = strtoupper($updateData['name']);
            
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $userModulePath = $userModuleEntity->getPath();
            $tmpName = $updateData['photo']['tmp_name'];
            if ($tmpName != "") {
                $newPath = str_replace('data/photo/icon-module/', 'photo/icon-module/', $tmpName);
                $userModulePath = $newPath;
                if ( ! is_null($userModuleEntity->getPath()) && $userModuleEntity->getPath() != '' ) {
                    unlink('data/'.$userModuleEntity->getPath());
                }
            }

            $userModule = $this->getUserModuleHydrator()->hydrate($updateData, $userModuleEntity);
            
            $userModule->setPath($userModulePath);

            $entityResult = $this->getUserModuleMapper()->save($userModule);
            $uuid = $entityResult->getUuid();
            $event->setUserModuleEntity($entityResult);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: UserModule {uuid} updated successfully",
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
     * Get the value of userModuleHydrator
     */
    public function getUserModuleHydrator()
    {
        return $this->userModuleHydrator;
    }

    /**
     * Set the value of userModuleHydrator
     *
     * @return  self
     */
    public function setUserModuleHydrator($userModuleHydrator)
    {
        $this->userModuleHydrator = $userModuleHydrator;

        return $this;
    }
}
