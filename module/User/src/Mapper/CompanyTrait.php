<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Company Trait
 */
trait CompanyTrait
{
    /**
     * @var \User\Mapper\Company
     */
    protected $companyMapper;

    /**
     * Get the value of companyMapper
     *
     * @return  \User\Mapper\Company
     */
    public function getCompanyMapper()
    {
        return $this->companyMapper;
    }

    /**
     * Set the value of companyMapper
     *
     * @param  \User\Mapper\Company  $companyMapper
     *
     * @return  self
     */
    public function setCompanyMapper(\User\Mapper\Company $companyMapper)
    {
        $this->companyMapper = $companyMapper;

        return $this;
    }
}
