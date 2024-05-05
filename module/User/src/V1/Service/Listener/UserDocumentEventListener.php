<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\UserDocumentTrait as UserDocumentMapperTrait;
use User\Entity\UserDocument as UserDocumentEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\UserDocumentEvent;
use Zend\Log\Exception\RuntimeException;

class UserDocumentEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use UserDocumentMapperTrait;
    use AccountMapperTrait;

    protected $fileConfig;
    protected $userDocumentEvent;
    protected $userDocumentHydrator;

    public function __construct(
        \User\Mapper\UserDocument $userDocumentMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setUserDocumentMapper($userDocumentMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserDocumentEvent::EVENT_CREATE_USER_DOCUMENT,
            [$this, 'createUserDocument'],
            499
        );

        $this->listeners[] = $events->attach(
            UserDocumentEvent::EVENT_UPDATE_USER_DOCUMENT,
            [$this, 'updateUserDocument'],
            499
        );
    }

    public function createUserDocument(UserDocumentEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }
            $bodyRequest = $event->getInputFilter()->getValues();
            $userDocumentEntity = new UserDocumentEntity;

            $tmpName = $bodyRequest['doc']['tmp_name'];
            $newPath = str_replace('data/doc/user-document/', 'user-document/', $tmpName);
            $bodyRequest["path"] = $newPath;

            $hydrateEntity  = $this->getUserDocumentHydrator()->hydrate($bodyRequest, $userDocumentEntity);
            $entityResult   = $this->getUserDocumentMapper()->save($hydrateEntity);
            $event->setUserDocumentEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: {uuid} New User Document created successfully",
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

    public function updateUserDocument(UserDocumentEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            // var_dump($event->getInputFilter()->get('doc'));exit;
            $userDocumentEntity = $event->getUserDocumentEntity();

            $bodyRequest = $event->getInputFilter()->getValues();

            $note = $event->getInputFilter()->getValue('note');
            if (! isset($note) || $note == '') {
                $note = $userDocumentEntity->getNote();
            }

            $type = $event->getInputFilter()->getValue('type');
            if (! isset($type) || $type == '') {
                $type = $userDocumentEntity->getType();
            }

            if (isset($bodyRequest["doc"])) {
                $tmpName = $bodyRequest['doc']['tmp_name'];
                $newPath = str_replace('data/doc/user-document/', 'user-document/', $tmpName);
            }

            // $inputDoc = $event->getInputFilter()->get('doc');
            // $inputDoc->getFilterChain()
            //             ->attach(new \Zend\Filter\File\RenameUpload([
            //             'target' => 'data/doc/user-document',
            //             'randomize' => true,
            //             'use_upload_extension' => true
            //         ]));

            // if (isset($bodyRequest["doc"])) {

            //     var_dump($inputDoc->getValue('doc'));exit;
            //     var_dump(get_class_methods($inputDoc));exit;
            //     $tmpName = $bodyRequest['doc']['tmp_name'];
            //     $newPath = str_replace('data/doc/user-document/', 'user-document/', $tmpName);

            // }

            $hydrateEntity = $this->getUserDocumentHydrator()->hydrate($bodyRequest, $userDocumentEntity);
            $hydrateEntity->setNote($note);
            $hydrateEntity->setType($type);
            $hydrateEntity->setPath($newPath);

            $hydrateEntity->setUpdatedAt(new \DateTime('now'));
            $entityResult  = $this->getUserDocumentMapper()->save($hydrateEntity);
            $event->setUserDocumentEntity($entityResult);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}:{uuid} User Document data updated successfully",
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
     * Get the value of fileConfig
     */
    public function getFileConfig()
    {
        return $this->fileConfig;
    }

    /**
     * Set the value of fileConfig
     *
     * @return  self
     */
    public function setFileConfig($fileConfig)
    {
        $this->fileConfig = $fileConfig;

        return $this;
    }

    /**
     * Get the value of userDocumentEvent
     */
    public function getUserDocumentEvent()
    {
        return $this->userDocumentEvent;
    }

    /**
     * Set the value of userDocumentEvent
     *
     * @return  self
     */
    public function setUserDocumentEvent($userDocumentEvent)
    {
        $this->userDocumentEvent = $userDocumentEvent;

        return $this;
    }

    /**
     * Get the value of userDocumentHydrator
     */
    public function getUserDocumentHydrator()
    {
        return $this->userDocumentHydrator;
    }

    /**
     * Set the value of userDocumentHydrator
     *
     * @return  self
     */
    public function setUserDocumentHydrator($userDocumentHydrator)
    {
        $this->userDocumentHydrator = $userDocumentHydrator;

        return $this;
    }
}
