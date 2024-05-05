<?php

namespace User\V1\Rest\Company;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator as ZendPaginator;
use User\V1\Rest\AbstractResource;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\Company as CompanyMapper;
use User\Mapper\CompanyTrait as CompanyMapperTrait;

class CompanyResource extends AbstractResource
{
    use CompanyMapperTrait;

    protected $companyService;

    public function __construct(
        UserProfileMapper $userProfileMapper,
        CompanyMapper $companyMapper
    ) {
        $this->setUserProfileMapper($userProfileMapper);
        $this->setCompanyMapper($companyMapper);
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
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(403, "You do not have access!"));
        }

        $data = (array) $data;
        $inputFilter = $this->getInputFilter();

        try {
            $inputFilter->add(['name' => 'account']);
            $inputFilter->get('account')->setValue($userProfile->getAccount());

            $inputFilter->add(['name' => 'isActive']);
            $inputFilter->get('isActive')->setValue(1);

            $inputFilter->add(['name' => 'isHq']);
            $inputFilter->get('isHq')->setValue(1);

            $inputFilter->add(['name' => 'createdAt']);
            $inputFilter->get('createdAt')->setValue(new \DateTime('now'));

            $inputFilter->add(['name' => 'updatedAt']);
            $inputFilter->get('updatedAt')->setValue(new \DateTime('now'));

            $result = $this->getCompanyService()->save($inputFilter);
        } catch (\User\V1\Service\Exception\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $result;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile) || is_null($userProfile->getAccount())) {
            return new ApiProblemResponse(new ApiProblem(404, "You do not have access"));
        }

        try {
            $company = $this->getCompanyMapper()->fetchOneBy(['uuid' => $id]);
            if (is_null($company)) {
                return new ApiProblem(404, "Company data Not Found");
            }
            return $this->getCompanyService()->delete($company);
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $company;
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
        try {
            $userProfile = $this->fetchUserProfile();

            if ($userProfile === null) {
                return;
            }

            $queryParams = [
                'uuid' => $id
            ];

            $data = $this->getCompanyMapper()->fetchOneBy($queryParams);
            if (is_null($data)) {
                return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
            }

            return $data;
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }
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

        $urlParams   = $params->toArray();
        $queryParams = [];
        if (!is_null($userProfile->getAccount())) {
            $queryParams = ["account_uuid" => $userProfile->getAccount()->getUuid()];
        }

        $queryParams = array_merge($queryParams, $urlParams);

        $order = null;
        $asc   = false;

        if (isset($queryParams['order'])) {
            $order = $queryParams['order'];
            unset($queryParams['order']);
        }

        if (isset($queryParams['ascending'])) {
            $asc = $queryParams['ascending'];
            unset($queryParams['ascending']);
        }

        $qb = $this->getCompanyMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getCompanyMapper()->createPaginatorAdapter($qb);
        return new ZendPaginator($paginatorAdapter);
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
        $company = $this->getCompanyMapper()->fetchOneBy(['uuid' => $id]);
        if (is_null($company)) {
            return new ApiProblemResponse(new ApiProblem(404, "Company data not found!"));
        }
        $inputFilter = $this->getInputFilter();

        $this->getCompanyService()->update($company, $inputFilter);
        return $company;
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
     * Get the value of companyService
     */
    public function getCompanyService()
    {
        return $this->companyService;
    }

    /**
     * Set the value of companyService
     *
     * @return  self
     */
    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;

        return $this;
    }
}
