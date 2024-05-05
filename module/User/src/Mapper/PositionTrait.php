<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Position Trait
 */
trait PositionTrait
{
    /**
     * @var \User\Mapper\Position
     */
    protected $positionMapper;


    /**
     * Get the value of positionMapper
     *
     * @return  \User\Mapper\Position
     */
    public function getPositionMapper()
    {
        return $this->positionMapper;
    }

    /**
     * Set the value of positionMapper
     *
     * @param  \User\Mapper\Position  $positionMapper
     *
     * @return  self
     */
    public function setPositionMapper(\User\Mapper\Position $positionMapper)
    {
        $this->positionMapper = $positionMapper;

        return $this;
    }
}
