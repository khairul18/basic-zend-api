<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
* @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
*/

namespace User\Service\Listener;

use ZF\MvcAuth\MvcAuthEvent;
use Psr\Log\LoggerAwareTrait;
use User\Mapper\UserProfile as UserProfileMapper;
use Zend\Http\Response as HttpResponse;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;

class AuthorizationTimezoneListener
{

    use UserProfileMapperTrait;

    use LoggerAwareTrait;

    /**
     * Determine if we have an authorization failure, and, if so, return a 403 response
     *
     * @param MvcAuthEvent $mvcAuthEvent
     * @return null|\Zend\Http\Response
     */
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $mvcEvent = $mvcAuthEvent->getMvcEvent();
        $response = $mvcEvent->getResponse();

        $username = $mvcAuthEvent->getIdentity()->getAuthenticationIdentity();
        $userProfile = $this->getUserProfileMapper()->fetchOneBy(['username' => $username['user_id']]);
        if (is_null($userProfile)) {
            return;
        }
        // date_default_timezone_set($userProfile->getTimezone());
        locale_set_default($userProfile->getAccount()->getLocale());
    }
}
