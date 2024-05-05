<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Education Trait
 */
trait EducationTrait
{
    /**
     * @var \User\Mapper\Education
     */
    protected $educationMapper;

    /**
     * Get the value of educationMapper
     *
     * @return  \User\Mapper\Education
     */
    public function getEducationMapper()
    {
        return $this->educationMapper;
    }

    /**
     * Set the value of educationMapper
     *
     * @param  \User\Mapper\Education  $educationMapper
     *
     * @return  self
     */
    public function setEducationMapper(\User\Mapper\Education $educationMapper)
    {
        $this->educationMapper = $educationMapper;

        return $this;
    }
}
