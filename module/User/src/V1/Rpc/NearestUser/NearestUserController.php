<?php
namespace User\V1\Rpc\NearestUser;

use ZF\Hal\View\HalJsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\Mvc\Controller\AbstractActionController;
use User\Entity\UserProfile as UserProfileEntity;
use User\Mapper\UserProfile as UserProfileMapper;
use User\Mapper\UserProfileTrait as UserProfileMapperTrait;

class NearestUserController extends AbstractActionController
{
    use UserProfileMapperTrait;

    protected $config;

    public function __construct(
        $userProfile,
        UserProfileMapper $userProfileMapper
    ) {

        $this->userProfile = $userProfile;
        $this->setUserProfileMapper($userProfileMapper);
    }

    public function nearestUserAction()
    {
        $showDate  = false;
        $totalPatient = $mediumRisk = $highRisk = 0;
        $userProfile = $this->userProfile;
        $params = $this->getRequest()->getQuery()->toArray();
        $hal = $this->getPluginManager()->get('Hal');

        $radius = $this->getConfig()['radius'];
        $userCollection = $this->getUserProfileMapper()->findNearestFrom(
            $params['latitude'],
            $params['longitude'],
            $radius
        );
        foreach ($userCollection as $key => $userEntity) {
            if (! $userEntity[0] instanceof UserProfileEntity) {
                continue;
            }

            $lastScore = $userEntity[0]->getLastScore();
            if (is_null($lastScore)) {
                continue;
            }

            switch ($lastScore) {
                case $lastScore >= 6 && $lastScore <= 11:
                    $mediumRisk += 1;
                    break;
                case $lastScore >= 12 && $lastScore <= 24:
                    $highRisk += 1;
                    break;
            }

            $userData = [
                "distance" => round($userCollection[$key]['distance']) . ' KM',
            ];
        }
        $totalPatient = $mediumRisk + $highRisk;

        $data['category']['High Risk'] = $highRisk;
        $data['category']['Medium Risk'] = $mediumRisk;
        $data['Total Patient'] = $totalPatient;

        // return new HalJsonModel(['totalPatient' => $totalPatient]);
        return new HalJsonModel($data);
    }

    /**
     * Get the value of config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @return  self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }
}
