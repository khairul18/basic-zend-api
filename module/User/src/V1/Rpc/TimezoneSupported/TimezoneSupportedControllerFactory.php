<?php
namespace User\V1\Rpc\TimezoneSupported;

class TimezoneSupportedControllerFactory
{
    public function __invoke($controllers)
    {
        return new TimezoneSupportedController();
    }
}
