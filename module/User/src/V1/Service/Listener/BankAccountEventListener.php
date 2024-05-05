<?php
namespace User\V1\Service\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\Mapper\BankAccountTrait as BankAccountMapperTrait;
use User\Entity\BankAccount as BankAccountEntity;
use Zend\EventManager\EventManagerAwareTrait;
use User\V1\BankAccountEvent;
use Zend\Log\Exception\RuntimeException;

class BankAccountEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;
    use BankAccountMapperTrait;
    use AccountMapperTrait;

    protected $bankAccountEvent;
    protected $bankAccountHydrator;

    public function __construct(
        \User\Mapper\BankAccount $bankAccountMapper,
        \User\Mapper\Account $accountMapper
    ) {
        $this->setBankAccountMapper($bankAccountMapper);
        $this->setAccountMapper($accountMapper);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            BankAccountEvent::EVENT_CREATE_BANK_ACCOUNT,
            [$this, 'createBankAccount'],
            500
        );

        $this->listeners[] = $events->attach(
            BankAccountEvent::EVENT_UPDATE_BANK_ACCOUNT,
            [$this, 'updateBankAccount'],
            500
        );

        $this->listeners[] = $events->attach(
            BankAccountEvent::EVENT_DELETE_BANK_ACCOUNT,
            [$this, 'deleteBankAccount'],
            500
        );
    }

    public function createBankAccount(BankAccountEvent $event)
    {
        try {
            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bodyRequest = $event->getInputFilter()->getValues();

            $bankAccountEntity = new BankAccountEntity;
            $hydrateEntity  = $this->getBankAccountHydrator()->hydrate($bodyRequest, $bankAccountEntity);
            $entityResult   = $this->getBankAccountMapper()->save($hydrateEntity);
            $event->setBankAccountEntity($entityResult);
            $uuid = $entityResult->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: New Bank Account {uuid} created successfully",
                [
                    "function" => __FUNCTION__,
                    "uuid" => $uuid
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
     * Update BankAccount
     *
     * @param  SignupEvent $event
     * @return void|\Exception
     */
    public function updateBankAccount(BankAccountEvent $event)
    {
        try {
            $bankAccountEntity = $event->getBankAccountEntity();
            $bankAccountEntity->setUpdatedAt(new \DateTime('now'));
            $updateData  = $event->getUpdateData();

            if (! $event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            $bankAccount = $this->getBankAccountHydrator()->hydrate($updateData, $bankAccountEntity);
            $this->getBankAccountMapper()->save($bankAccount);
            $uuid = $bankAccount->getUuid();
            $event->setBankAccountEntity($bankAccount);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function}: Bank Account {uuid} updated successfully",
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

    public function deleteBankAccount(BankAccountEvent $event)
    {
        try {
            $deletedData = $event->getDeleteData();
            $result = $this ->getBankAccountMapper()->delete($deletedData);
            $uuid   = $deletedData->getUuid();

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {uuid}: Data Bank Account deleted successfully",
                [
                    'uuid' => $uuid,
                    "function" => __FUNCTION__
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        }
    }


    /**
     * Get the value of bankAccountHydrator
     */
    public function getBankAccountHydrator()
    {
        return $this->bankAccountHydrator;
    }

    /**
     * Set the value of bankAccountHydrator
     *
     * @return  self
     */
    public function setBankAccountHydrator($bankAccountHydrator)
    {
        $this->bankAccountHydrator = $bankAccountHydrator;

        return $this;
    }
}
