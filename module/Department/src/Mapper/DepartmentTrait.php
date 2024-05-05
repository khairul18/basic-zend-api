<?php

namespace Department\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Department Trait
 */
trait DepartmentTrait
{
    /**
     * @var \Department\Mapper\Department
     */
    protected $departmentMapper;

    /**
     * Get the value of departmentMapper
     *
     * @return  \Department\Mapper\Department
     */
    public function getDepartmentMapper()
    {
        return $this->departmentMapper;
    }

    /**
     * Set the value of departmentMapper
     *
     * @param  \Department\Mapper\Department  $departmentMapper
     *
     * @return  self
     */
    public function setDepartmentMapper(\Department\Mapper\Department $departmentMapper)
    {
        $this->departmentMapper = $departmentMapper;

        return $this;
    }
}
