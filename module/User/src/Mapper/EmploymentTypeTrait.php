<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * EmploymentType Trait
 */
trait EmploymentTypeTrait
{
    /**
     * @var \User\Mapper\EmploymentType
     */
    protected $employmentTypeMapper;


    /**
     * Get the value of employmentTypeMapper
     *
     * @return  \User\Mapper\EmploymentType
     */
    public function getEmploymentTypeMapper()
    {
        return $this->employmentTypeMapper;
    }

    /**
     * Set the value of employmentTypeMapper
     *
     * @param  \User\Mapper\EmploymentType  $employmentTypeMapper
     *
     * @return  self
     */
    public function setEmploymentTypeMapper(\User\Mapper\EmploymentType $employmentTypeMapper)
    {
        $this->employmentTypeMapper = $employmentTypeMapper;

        return $this;
    }
}
