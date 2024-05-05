<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Department Trait
 */
trait DepartmentTrait
{
    /**
     * @var \User\Mapper\Department
     */
    protected $departmentMapper;

    /**
     * Get the value of departmentMapper
     *
     * @return  \User\Mapper\Department
     */
    public function getDepartmentMapper()
    {
        return $this->departmentMapper;
    }

    /**
     * Set the value of departmentMapper
     *
     * @param  \User\Mapper\Department  $departmentMapper
     *
     * @return  self
     */
    public function setDepartmentMapper(\User\Mapper\Department $departmentMapper)
    {
        $this->departmentMapper = $departmentMapper;

        return $this;
    }
}
