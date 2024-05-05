<?php

namespace Notification\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * NotificationLog
 */
class NotificationLog implements EntityInterface
{
    use \Gedmo\Timestampable\Traits\Timestampable;

    use \Gedmo\SoftDeleteable\Traits\SoftDeleteable;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\UserProfile
     */
    private $userProfile;


    /**
     * Set title.
     *
     * @param string|null $title
     *
     * @return NotificationLog
     */
    public function setTitle($title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set userProfile.
     *
     * @param \User\Entity\UserProfile|null $userProfile
     *
     * @return NotificationLog
     */
    public function setUserProfile(\User\Entity\UserProfile $userProfile = null)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get userProfile.
     *
     * @return \User\Entity\UserProfile|null
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }
}
