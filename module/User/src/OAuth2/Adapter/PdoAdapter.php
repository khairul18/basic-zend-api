<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @author    Dolly Aswin <dolly.aswin@gmail.com>
 */

namespace User\OAuth2\Adapter;

use ZF\OAuth2\Adapter\PdoAdapter as ZFOAuth2PdoAdapter;
use ZF\MvcAuth\MvcAuthEvent;
use Zend\Authentication\Result;
use ZF\MvcAuth\Identity;
//use ZF\ContentNegotiation\Request;
use Zend\EventManager\EventManager;
use Psr\Log\InvalidArgumentException;

/**
 * Extension of OAuth2\Storage\PDO with EventManager
 */
class PdoAdapter extends ZFOAuth2PdoAdapter
{
    const ACCOUNT_DELIMITER = ':';

    /**
     *
     * @var ZF\ContentNegotiation\Request
     */
    protected $request;

    /**
     *
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @var MvcAuthEvent
     */
    protected $mvcAuthEvent;

    public function __construct($connection, $request, $config = [])
    {
        $this->setRequest($request);
        parent::__construct($connection, $config);
    }

    public function setAccessToken($accessToken, $clientId, $userId, $expires, $scope = null)
    {
        // set default timezone
        $sqlFindingUser = 'SELECT u.* from user_profile as u where u.username = :username';
        $stmt = $this->db->prepare($sqlFindingUser);
        $stmt->execute(['username' => $userId]);
        if (! $userInfo = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }

        parent::setAccessToken($accessToken, $clientId, $userId, $expires, $scope);
    }

    /**
     * @param string $access_token
     * @return array|bool|mixed|null
     */
    public function getAccessToken($access_token)
    {
        $stmt  = $this->db->prepare(sprintf(
            'SELECT ac.*, up.timezone FROM %s AS ac INNER JOIN '
            . 'user_profile up ON ac.user_id = up.username '
            . 'WHERE ac.access_token = :access_token',
            $this->config['access_token_table']
        ));
        $token = $stmt->execute(compact('access_token'));
        if ($token = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            // set default timestamp based on user timezone
            date_default_timezone_set($token['timezone']);
            // convert date string back to timestamp
            $token['expires'] = strtotime($token['expires']);
        }

        return $token;
    }

    /**
     * Check password using bcrypt
     *
     * @param string $user
     * @param string $password
     * @return bool
     */
    protected function checkPassword($user, $password)
    {
        $this->getMvcAuthEvent()->setAuthenticationResult(new Result(Result::SUCCESS, $user['user_id']));
        $result = $this->getMvcAuthEvent()->getAuthenticationResult();
        $this->getMvcAuthEvent()->setIdentity(new Identity\AuthenticatedIdentity($result->getIdentity()));
        $this->getMvcAuthEvent()->setName(MvcAuthEvent::EVENT_AUTHENTICATION);
        $this->getEventManager()->triggerEvent($this->getMvcAuthEvent());
        $verified = parent::verifyHash($password, $user['password']);
        if (! $verified) {
            $this->getMvcAuthEvent()->setAuthenticationResult(new Result(Result::FAILURE_CREDENTIAL_INVALID, null));
            $this->getMvcAuthEvent()->setIdentity(new Identity\GuestIdentity());
        }

        $this->getMvcAuthEvent()->setName(MvcAuthEvent::EVENT_AUTHENTICATION_POST);
        $this->getEventManager()->triggerEvent($this->getMvcAuthEvent());
        return $verified;
    }

    /**
     * @return MvcAuthEvent
     */
    public function getMvcAuthEvent()
    {
        return $this->mvcAuthEvent;
    }

    /**
     * @param MvcAuthEvent $mvcAuthEvent
     */
    public function setMvcAuthEvent(MvcAuthEvent $mvcAuthEvent)
    {
        $this->mvcAuthEvent = $mvcAuthEvent;
    }

    /**
     * @return the $eventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * @param EventManager $eventManager
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }
}
