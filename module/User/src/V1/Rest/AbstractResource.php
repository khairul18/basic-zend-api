<?php
namespace User\V1\Rest;

use ZF\Rest\AbstractResourceListener;
use ZF\ApiProblem\ApiProblem;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserAccess as UserAccessMapper;

class AbstractResource extends AbstractResourceListener
{
    use UserProfileMapperTrait;
    // use UserAccessMapperTrait;

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
     * Get Account
     *
     * @return User\Entity\Account
     */
    public function fetchAccount()
    {
        $account = null;
        $userProfile = $this->fetchUserProfile();
        if ($userProfile !== null) {
            $account = $userProfile->getAccount();
        }

        return $account;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }

    /**
     * @return the $userProfileMapper
     */
    public function getUserProfileMapper()
    {
        return $this->userProfileMapper;
    }

    /**
     * @param UserProfileMapper $userProfileMapper
     */
    public function setUserProfileMapper($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * @return the $userAccessMapper
     */
    public function getUserAccessMapper()
    {
        return $this->userAccessMapper;
    }

    /**
     * @param UserAccessMapper $userAccessMapper
     */
    public function setUserAccessMapper(\User\Mapper\UserAccess $userAccessMapper)
    {
        $this->userAccessMapper = $userAccessMapper;
    }
}
