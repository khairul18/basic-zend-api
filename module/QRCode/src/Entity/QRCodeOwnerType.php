<?php

namespace QRCode\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * QRCodeOwnerType
 */
class QRCodeOwnerType implements EntityInterface
{
    use \Gedmo\Timestampable\Traits\Timestampable;

    use \Gedmo\SoftDeleteable\Traits\SoftDeleteable;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \User\Entity\Account
     */
    private $account;


    /**
     * Set type.
     *
     * @param string|null $type
     *
     * @return QRCodeOwnerType
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
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
     * Set account.
     *
     * @param \User\Entity\Account|null $account
     *
     * @return QRCodeOwnerType
     */
    public function setAccount(\User\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account.
     *
     * @return \User\Entity\Account|null
     */
    public function getAccount()
    {
        return $this->account;
    }
}
