<?php
namespace User\V1\Rpc\TimezoneSupported;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use \DateTimeZone;

class TimezoneSupportedController extends AbstractActionController
{
    public function timezoneSupportedAction()
    {
        $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        return new JsonModel(['timezoneSupported' => $tzlist]);
    }
}
