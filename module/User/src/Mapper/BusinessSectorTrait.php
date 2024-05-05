<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * BusinessSector Trait
 */
trait BusinessSectorTrait
{
    /**
     * @var \User\Mapper\BusinessSector
     */
    protected $businessSectorMapper;

    /**
     * Get the value of businessSectorMapper
     *
     * @return  \User\Mapper\BusinessSector
     */
    public function getBusinessSectorMapper()
    {
        return $this->businessSectorMapper;
    }

    /**
     * Set the value of businessSectorMapper
     *
     * @param  \User\Mapper\BusinessSector  $businessSectorMapper
     *
     * @return  self
     */
    public function setBusinessSectorMapper(\User\Mapper\BusinessSector $businessSectorMapper)
    {
        $this->businessSectorMapper = $businessSectorMapper;

        return $this;
    }
}
