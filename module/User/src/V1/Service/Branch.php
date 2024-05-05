<?php
namespace User\V1\Service;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;
use User\Entity\Branch as BranchEntity;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use User\V1\BranchEvent;

class Branch
{
    use EventManagerAwareTrait;

    protected $branchEvent;


    public function create(array $data, ZendInputFilter $inputFilter)
    {
        $branchEvent = new BranchEvent();
        $branchEvent->setInputFilter($inputFilter);
        $branchEvent->setName(BranchEvent::EVENT_CREATE_BRANCH);
        $create = $this->getEventManager()->triggerEvent($branchEvent);
        if ($create->stopped()) {
            $branchEvent->setName(BranchEvent::EVENT_CREATE_BRANCH_ERROR);
            $branchEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($branchEvent);
            throw $branchEvent->getException();
        } else {
            $branchEvent->setName(BranchEvent::EVENT_CREATE_BRANCH_SUCCESS);
            $this->getEventManager()->triggerEvent($branchEvent);
            return $branchEvent->getBranchEntity();
        }
    }

    public function update(BranchEntity $branch, ZendInputFilter $newData)
    {
        $branchEvent = new BranchEvent();
        $branchEvent->setInputFilter($newData);
        $branchEvent->setBranchEntity($branch);
        $branchEvent->setName(BranchEvent::EVENT_UPDATE_BRANCH);
        $create = $this->getEventManager()->triggerEvent($branchEvent);
        if ($create->stopped()) {
            $branchEvent->setName(BranchEvent::EVENT_UPDATE_BRANCH_ERROR);
            $branchEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($branchEvent);
            throw $branchEvent->getException();
        } else {
            $branchEvent->setName(BranchEvent::EVENT_UPDATE_BRANCH_SUCCESS);
            $this->getEventManager()->triggerEvent($branchEvent);
            return $branchEvent->getBranchEntity();
        }
    }

    public function delete(BranchEntity $deletedData)
    {
        $branchEvent = new BranchEvent();
        $branchEvent->setDeleteData($deletedData);
        $branchEvent->setName(BranchEvent::EVENT_DELETE_BRANCH);
        $create = $this->getEventManager()->triggerEvent($branchEvent);
        if ($create->stopped()) {
            $branchEvent->setName(BranchEvent::EVENT_DELETE_BRANCH_ERROR);
            $branchEvent->setException($create->last());
            $this->getEventManager()->triggerEvent($branchEvent);
            throw $branchEvent->getException();
        } else {
            $branchEvent->setName(BranchEvent::EVENT_DELETE_BRANCH_SUCCESS);
            $this->getEventManager()->triggerEvent($branchEvent);
            return true;
        }
    }

    public function getBranchEvent()
    {
        if ($this->branchEvent == null) {
            $this->branchEvent = new BranchEvent();
        }

        return $this->branchEvent;
    }

    public function setBranchEvent(BranchEvent $branchEvent)
    {
        $this->branchEvent = $branchEvent;
    }
}
