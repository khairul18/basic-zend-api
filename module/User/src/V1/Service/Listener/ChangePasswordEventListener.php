<?php
namespace User\V1\Service\Listener;

use ZF\ApiProblem\ApiProblem;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\V1\ChangePasswordEvent;
use Aqilix\OAuth2\Mapper\OauthUsers as UserMapper;

class ChangePasswordEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    use LoggerAwareTrait;

    protected $userMapper;

    /**
     * @var array
     */
    protected $config;

    /**
     *
     * @var DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    protected $changePasswordHydrator;

    public function __construct(
        UserMapper $userMapper
    ) {
        $this->userMapper     = $userMapper;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            ChangePasswordEvent::EVENT_CHANGE_PASSWORD,
            [$this, 'changePassword'],
            500
        );
    }

    public function changePassword(ChangePasswordEvent $event)
    {
        try {
            $changePasswordData   = $event->getChangePasswordData();
            $user = new \Aqilix\OAuth2\Entity\OauthUsers;
            $currentPassword   = $this->getUserMapper()
                               ->getPasswordHash($changePasswordData['currentPassword']);
            $newPassword   = $this->getUserMapper()
                               ->getPasswordHash($changePasswordData['newPassword']);
            $userOAuth = $this->getChangePasswordHydrator()->hydrate($changePasswordData, $user);
            $userOAuth->setPassword($newPassword);
            $this->getUserMapper()->save($userOAuth);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "Function : {function}\nUsername : {username}\nCurrent Password : {currentPassword}\nNew Password : {newPassword}",
                [
                    "function" => __FUNCTION__,
                    "username"     => $changePasswordData['username'],
                    "currentPassword"  => $currentPassword,
                    "newPassword"      => $newPassword,
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {data} {message}",
                [
                    "data" => json_encode($userOAuth),
                    "message"  => $e->getMessage(),
                    "function" => __FUNCTION__,
                ]
            );
            return $e;
        }
    }

    /**
     * @return the $userMapper
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }

    /**
     * Set UserMapper
     *
     * @param UserMapper $userMapper
     */
    public function setUserMapper(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    /**
     * Get the value of changePasswordHydrator
     */
    public function getChangePasswordHydrator()
    {
        return $this->changePasswordHydrator;
    }

    /**
     * Set the value of changePasswordHydrator
     *
     * @return  self
     */
    public function setChangePasswordHydrator($changePasswordHydrator)
    {
        $this->changePasswordHydrator = $changePasswordHydrator;

        return $this;
    }
}
