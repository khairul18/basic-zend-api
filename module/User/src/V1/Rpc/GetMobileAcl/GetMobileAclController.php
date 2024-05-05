<?php
namespace User\V1\Rpc\GetMobileAcl;

use User\V1\Rpc\AbstractAction;
use Zend\Http\PhpEnvironment\Request;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class GetMobileAclController extends AbstractAction
{
    /**
     * @var  \User\V1\Rpc\GetMobileAcl\MobileAclHardcoded
     */
    protected $hardcodedUtils;

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @param  \User\V1\Rpc\GetMobileAcl\MobileAclHardcoded  $hardcodedUtils
     */
    public function __construct(
        $userProfileMapper,
        $hardcodedUtils
    ) {
        $this->userProfileMapper = $userProfileMapper;
        $this->hardcodedUtils = $hardcodedUtils;
    }

    /**
     * @return mixed
     */
    public function getMobileAclAction()
    {
        $request = $this->getRequest();
        if(!($request instanceof Request))
            return new ApiProblemResponse(new ApiProblem(500, 'Can\'t get request instance.'));

        $queryParams = $request->getQuery()->toArray();

        $mobileAcl = null;
        if(isset($queryParams['domain'])) {
            $mobileAcl = $this->hardcodedUtils->getMobileAcl($queryParams['domain']);
        } else {
            $mobileAcl = $this->hardcodedUtils->getMobileAcl($_SERVER['SERVER_NAME']);
        }

        return new JsonModel($mobileAcl);
    }
}
