<?php

namespace User\V1\Rest\Branch;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Paginator\Paginator as ZendPaginator;
use Psr\Log\LoggerAwareTrait;
use User\V1\Rest\AbstractResource;
use User\Mapper\BranchTrait;
use User\Mapper\AccountTrait as AccountMapperTrait;
use User\V1\Role;

class BranchResource extends AbstractResource
{
    use AccountMapperTrait;
    use LoggerAwareTrait;
    use BranchTrait;

    protected $branchService;

    public function __construct(
        \User\Mapper\Account $accountMapper,
        \User\Mapper\Branch $branchMapper,
        \User\Mapper\UserProfile $userProfileMapper,
        \User\Mapper\UserAccess $userAccessMapper
    ) {
        $this->setAccountMapper($accountMapper);
        $this->setBranchMapper($branchMapper);
        $this->setUserProfileMapper($userProfileMapper);
        $this->setUserAccessMapper($userAccessMapper);
    }

    public function create($data)
    {
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile) || is_null($userProfile->getAccount())) {
            return new ApiProblemResponse(new ApiProblem(404, "You do not have access"));
        }

        try {
            $inputFilters = $this->getInputFilter();


            $inputFilters->add(['name' => 'isActive']);
            $inputFilters->get('isActive')->setValue(1);

            $accountSlug = $inputFilters->getValue('account');
            if (isset($accountSlug) && $accountSlug != "") {
                $accountEntity = $this->getAccountMapper()->fetchOneBy([
                    "slug" => $accountSlug
                ]);
                $inputFilters->get('account')->setValue($accountEntity);
            } else {
                $inputFilters->get('account')->setValue($this->fetchAccount());
            }

            $branch = $this->getBranchService()->create([], $inputFilters);
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $branch;
    }

    public function patch($id, $data)
    {
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile) || is_null($userProfile->getAccount())) {
            return new ApiProblemResponse(new ApiProblem(404, "You do not have access"));
        }

        try {
            $branch  = $this->getBranchMapper()->fetchOneBy(['uuid' => $id]);
            if (is_null($branch)) {
                return new ApiProblem(404, "Branch Not Found");
            }

            $inputFilters = $this->getInputFilter();
            $accountSlug  = $inputFilters->getValue('account');
            if (isset($accountSlug) && $accountSlug != "") {
                $accountEntity = $this->getAccountMapper()->fetchOneBy([
                    "slug" => $accountSlug
                ]);
                $inputFilters->get('account')->setValue($accountEntity);
            } else {
                $inputFilters->get('account')->setValue($this->fetchAccount());
            }

            $companySlug  = $inputFilters->getValue('company');
            if (!isset($companySlug) || $companySlug == "") {
                unset($inputFilters['company']);
            }

            $branch = $this->getBranchService()->update($branch, $inputFilters);
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $branch;
    }

    public function delete($id)
    {
        $userProfile = $this->fetchUserProfile();
        if (is_null($userProfile) || is_null($userProfile->getAccount())) {
            return new ApiProblemResponse(new ApiProblem(404, "You do not have access"));
        }

        try {
            $branch  = $this->getBranchMapper()->fetchOneBy(['uuid' => $id]);
            if (is_null($branch)) {
                return new ApiProblem(404, "Branch Not Found");
            }
            return $this->getBranchService()->delete($branch);
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(new ApiProblem(500, $e->getMessage()));
        }

        return $branch;
    }

    public function fetch($id)
    {
        try {
            $userProfile = $this->fetchUserProfile();

            if ($userProfile === null) {
                return;
            }

            $queryParams = [
                // 'account'   => $userProfile->getAccount()->getUuid(),
                'uuid' => $id
            ];

            $data = $this->getBranchMapper()->fetchOneBy($queryParams);
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
        if (is_null($userProfile)) {
            return new ApiProblemResponse(new ApiProblem(401, 'You\'re not authorized'));
        }

        $account  = $userProfile->getAccount();
        $queryParams = [];
        if (!is_null($account)) {
            $queryParams = ['account' => $account->getUuid()];
        } else {
            return new ApiProblemResponse(new ApiProblem(403, 'Account not match'));
        }

        $queryParamUserAccess = [
            'userProfile' => $userProfile->getUuid()
        ];
        $userAccess = $this->getUserAccessMapper()->fetchOneBy($queryParamUserAccess);
        //initiate var role, create condition to check if userAccess isExist 
        $role = '';
        if (!is_null($userAccess)) {
            $role = strtolower($userAccess->getUserRole()->getName());
        }

        if ($role == Role::MANAGER) {
            $queryParams['company_uuid'] = $userProfile->getCompany()->getUuid();
        }

        $order = null;
        $asc   = false;
        $queryParams = array_merge($queryParams, $params->toArray());

        if (isset($queryParams['order'])) {
            $order = $queryParams['order'];
            unset($queryParams['order']);
        }

        if (isset($queryParams['ascending'])) {
            $asc = $queryParams['ascending'];
            unset($queryParams['ascending']);
        }

        $branches = $this->getBranchMapper()->fetchAll($queryParams, $order, $asc);
        $paginatorAdapter = $this->getBranchMapper()->createPaginatorAdapter($branches);
        $paginatedData = new ZendPaginator($paginatorAdapter);
        return $paginatedData;
    }

    /**
     * Get the value of branchService
     */
    public function getBranchService()
    {
        return $this->branchService;
    }

    /**
     * Set the value of branchService
     *
     * @return  self
     */
    public function setBranchService($branchService)
    {
        $this->branchService = $branchService;

        return $this;
    }
}
