<?php

namespace Department\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Company Trait
 */
trait CompanyTrait
{
    /**
     * @var \Department\Mapper\Company
     */
    protected $companyMapper;

    /**
     * Get the value of companyMapper
     *
     * @return  \Department\Mapper\Company
     */
    public function getCompanyMapper()
    {
        return $this->companyMapper;
    }

    /**
     * Set the value of companyMapper
     *
     * @param  \Department\Mapper\Company  $companyMapper
     *
     * @return  self
     */
    public function setCompanyMapper(\Department\Mapper\Company $companyMapper)
    {
        $this->companyMapper = $companyMapper;

        return $this;
    }
}
