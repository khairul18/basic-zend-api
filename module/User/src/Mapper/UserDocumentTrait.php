<?php

namespace User\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserDocument Trait
 */
trait UserDocumentTrait
{
    /**
     * @var \User\Mapper\UserDocument
     */
    protected $userDocumentMapper;


    /**
     * Get the value of userDocumentMapper
     *
     * @return  \User\Mapper\UserDocument
     */
    public function getUserDocumentMapper()
    {
        return $this->userDocumentMapper;
    }

    /**
     * Set the value of userDocumentMapper
     *
     * @param  \User\Mapper\UserDocument  $userDocumentMapper
     *
     * @return  self
     */
    public function setUserDocumentMapper(\User\Mapper\UserDocument $userDocumentMapper)
    {
        $this->userDocumentMapper = $userDocumentMapper;

        return $this;
    }
}
