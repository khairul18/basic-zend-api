<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\UserAclTrait as UserAclMapperTrait;
use User\Mapper\UserRoleTrait as UserRoleMapperTrait;
use User\Mapper\UserModuleTrait as UserModuleMapperTrait;
use User\Entity\UserAcl as UserAclEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\UserAclEvent;
use Zend\Log\Exception\RuntimeException;
use Doctrine\Common\Collections\ArrayCollection;

class UserAclEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use UserAclMapperTrait;
    use UserRoleMapperTrait;
    use UserModuleMapperTrait;

    protected $config;
    protected $userAclEvent;
    protected $userAclHydrator;
    
    public function __construct(
        \User\Mapper\UserAcl $userAclMapper,
        \User\Mapper\UserRole $userRoleMapper,
        \User\Mapper\UserModule $userModuleMapper
    ) {
        $this->setUserAclMapper($userAclMapper);
        $this->setUserRoleMapper($userRoleMapper);
        $this->setUserModuleMapper($userModuleMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserAclEvent::EVENT_ACTION_USER_ACL,
            [$this, 'updateOptionFields'],
            499
        );
    }

    public function updateOptionFields(UserAclEvent $event)
    {
        try {
            $optionFields = $event->getOptionFields();
            $counter = 0;
            foreach ($optionFields as $option) {
                $userAclEntity  = $this->getUserAclMapper()->fetchOneBy([
                    'uuid' => $option->uuid
                ]);

                if (! is_null($userAclEntity)) {
                    if ($option->delete == "1") {
                        $this->getUserAclMapper()->delete($userAclEntity);
                        $uuid = $userAclEntity->getUuid();

                        $this->logger->log(
                            \Psr\Log\LogLevel::INFO,
                            "{function} (DELETED) UserAcl : {uuid}: Data deleted successfully",
                            [
                                'uuid' => $uuid,
                                "function" => __FUNCTION__
                            ]
                        );
                        continue;
                    }
                } else {
                    $userAclEntity = new UserAclEntity;
                }

                $userRoleUuid = $option->userRole;
                $userModuleUuid = $option->userModule;
                
                $userRoleEntity = $this->getUserRoleMapper()->fetchOneBy([
                    'uuid' => $userRoleUuid
                ]);

                $userModuleEntity = $this->getUserModuleMapper()->fetchOneBy([
                    'uuid' => $userModuleUuid
                ]);
                
                $userAclEntity->setUserModule($userModuleEntity);
                $userAclEntity->setUserRole($userRoleEntity);

                $saveOption = $this->getUserAclMapper()->save($userAclEntity);
                $counter += 1;
                $optArray[] = $saveOption;

                $this->logger->log(
                    \Psr\Log\LogLevel::INFO,
                    "{function}: {uuid} User Acl Fields added successfully",
                    [
                        "function" => __FUNCTION__,
                        "uuid"  => $saveOption->getUuid()
                    ]
                );
            }
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
     * Get the value of userAclHydrator
     */
    public function getUserAclHydrator()
    {
        return $this->userAclHydrator;
    }

    /**
     * Set the value of userAclHydrator
     *
     * @return  self
     */
    public function setUserAclHydrator($userAclHydrator)
    {
        $this->userAclHydrator = $userAclHydrator;

        return $this;
    }

    /**
     * Get the value of config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @return  self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }
}
