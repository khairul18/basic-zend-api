<?php

namespace Xtend\Firebase\Service;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Firebase Trait
 */
trait FirebaseTrait
{
    /**
     * @var Xtend\Firebase\Service\Firebase
     */
    protected $firebaseService;

    /**
     * Get Firebase Service
     *
     * @var Xtend\Firebase\Service\Firebase
     */
    public function getFirebaseService()
    {
        return $this->firebaseService;
    }

    /**
     * Set Firebase Service
     *
     * @var Xtend\Firebase\Service\Firebase $firebaseService
     */
    public function setFirebaseService($firebaseService)
    {
        $this->firebaseService = $firebaseService;
        return $this;
    }
}
