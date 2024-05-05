<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Branch Trait
 */
trait BranchTrait
{
    /**
     * @var User\Mapper\Branch
     */
    protected $branchMapper;

    /**
     * Get BranchMapper
     *
     * @return \User\Mapper\Branch
     */
    public function getBranchMapper()
    {
        return $this->branchMapper;
    }

    /**
     * Set BranchMapper
     *
     * @param  \User\Mapper\Branch $branchMapper
     */
    public function setBranchMapper(\User\Mapper\Branch $branchMapper)
    {
        $this->branchMapper = $branchMapper;
    }
}
