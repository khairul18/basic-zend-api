<?php
namespace User\V1\Rpc;

use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use Zend\Mvc\Controller\AbstractActionController;

class AbstractAction extends AbstractActionController
{
    use UserProfileMapperTrait;

    /**
     * @var \User\Entity\UserProfile
     */
    protected $userProfileEntity;

    /**
     * Get UserProfile
     *
     * @return \User\Entity\UserProfile
     */
    public function fetchUserProfile()
    {
        if ($this->userProfileEntity !== null) {
            return $this->userProfileEntity;
        }

        if (! $this->getIdentity() instanceof \ZF\MvcAuth\Identity\AuthenticatedIdentity) {
            return;
        }

        $identityArray = $this->getIdentity()->getAuthenticationIdentity();
        $userId = $identityArray['user_id'];

        // userProfile
        $this->userProfileEntity = $this->getUserProfileMapper()->fetchOneBy(['username' => $userId]);
        return $this->userProfileEntity;
    }

    /**
     * @return \User\Mapper\UserProfile
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @return self
     */
    public function setUserProfileMapper($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;

        return $this;
    }

    /**
     * @return \User\Mapper\UserAccess
     */
    public function getUserAccessMapper()
    {
        return $this->userAccessMapper;
    }

    /**
     * @param  \User\Mapper\UserAccess  $userAccessMapper
     * @return self
     */
    public function setUserAccessMapper($userAccessMapper)
    {
        $this->userAccessMapper = $userAccessMapper;

        return $this;
    }
}
