<?php

namespace User\V1;

use Zend\EventManager\Event;
use User\Entity\Branch as BranchEntity;
use Zend\InputFilter\InputFilterInterface;
use \Exception;

class BranchEvent extends Event
{
    /**#@+
     * Tracking events triggered by eventmanager
     */
    const EVENT_CREATE_BRANCH         = 'create.branch';
    const EVENT_CREATE_BRANCH_ERROR   = 'create.branch.error';
    const EVENT_CREATE_BRANCH_SUCCESS = 'create.branch.success';

    const EVENT_UPDATE_BRANCH         = 'update.branch';
    const EVENT_UPDATE_BRANCH_ERROR   = 'update.branch.error';
    const EVENT_UPDATE_BRANCH_SUCCESS = 'update.branch.success';

    const EVENT_DELETE_BRANCH         = 'delete.branch';
    const EVENT_DELETE_BRANCH_ERROR   = 'delete.branch.error';
    const EVENT_DELETE_BRANCH_SUCCESS = 'delete.branch.success';

    /**#@-*/

    /**
     * @var User\Entity\FakeGpsLog
     */
    protected $techSupportEntity;

    /**
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    protected $updateData;

    protected $deleteData;

    protected $deletedUuid;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @return the \User\Entity\FakeGpsLog
     */
    public function getBranchEntity()
    {
        return $this->techSupportEntity;
    }

    /**
     * @param User\Entity\FakeGpsLog $fakegps
     */
    public function setBranchEntity(BranchEntity $techSupportEntity)
    {
        $this->techSupportEntity = $techSupportEntity;
    }

    public function getUpdateData()
    {
        return $this->updateData;
    }

    public function setUpdateData($updateData)
    {
        $this->updateData = $updateData;
    }

    public function getDeletedUuid()
    {
        return $this->deletedUuid;
    }

    public function setDeletedUuid($deletedUuid)
    {
        $this->deletedUuid = $deletedUuid;
    }

    /**
     * @return the $inputFilter
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * @param Zend\InputFilter\InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * @return the $exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * Get the value of deleteData
     */
    public function getDeleteData()
    {
        return $this->deleteData;
    }

    /**
     * Set the value of deleteData
     *
     * @return  self
     */
    public function setDeleteData($deleteData)
    {
        $this->deleteData = $deleteData;

        return $this;
    }
}
