<?php

namespace QRCode\V1\Rest\QRCode;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;
use Zend\Paginator\Paginator as ZendPaginator;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserProfile as UserProfileMapper;
use QRCode\Mapper\QRCode as QRCodeMapper;
use QRCode\Mapper\QRCodeTrait as QRCodeMapperTrait;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class QRCodeResource extends AbstractResource
{
    use QRCodeMapperTrait;

    protected $qrCodeService;

    public function __construct(
        QRCodeMapper $qrCodeMapper,
        UserProfileMapper $userProfileMapper,
        \User\Mapper\UserAccess $userAccessMapper
    ) {
        $this->setQRCodeMapper($qrCodeMapper);
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserAccessMapper($userAccessMapper);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $userProfile = $this->fetchUserProfile();
        if ($userProfile === null) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }
        $userProfileUuid = $userProfile->getUuid();
        $queryParamUserAccess = [
            'userProfile' => $userProfileUuid
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (!is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role !== \User\V1\Role::ADMIN) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        try {
            // $userProfile = $this->fetchAccount();
            $qrCode = $this->getQRCodeService()->createQRCode($userProfile);
        } catch (\RuntimeException $e) {
            return new ApiProblem(500, 'Cannot create QR Code');
        }
        // return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $userProfile = $this->fetchUserProfile();
        if ($userProfile === null) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $userProfileUuid = $userProfile->getUuid();
        $queryParamUserAccess = [
            'userProfile' => $userProfileUuid
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (!is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role !== \User\V1\Role::ADMIN) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $queryParams = [
            'uuid' => $id
        ];
        $data = $this->getQRCodeMapper()->fetchOneBy($queryParams);
        if (is_null($data)) {
            $data = new ApiProblem(404, "QRCode Not found");
        }

        return $data;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $userProfile = $this->fetchUserProfile();
        if ($userProfile === null) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }
        $userProfileUuid = $userProfile->getUuid();
        $queryParamUserAccess = [
            'userProfile' => $userProfileUuid
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (!is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role !== \User\V1\Role::ADMIN) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $urlParams   = $params->toArray();
        $queryParams = [];

        $queryParams = array_merge($queryParams, $params->toArray());
        $order = null;
        $asc   = false;
        if (isset($queryParams['order'])) {
            $order = $queryParams['order'];
            unset($queryParams['order']);
        }

        if (isset($queryParams['asc'])) {
            $asc = $queryParams['asc'];
            unset($queryParams['asc']);
        }

        $qb = $this->getQRCodeMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getQRCodeMapper()->createPaginatorAdapter($qb);
        return new ZendPaginator($paginatorAdapter);
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
     * Get the value of qrCodeService
     */
    public function getQrCodeService()
    {
        return $this->qrCodeService;
    }

    /**
     * Set the value of qrCodeService
     *
     * @return  self
     */
    public function setQrCodeService($qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;

        return $this;
    }
}
