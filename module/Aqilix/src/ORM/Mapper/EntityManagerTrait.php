<?php
/**
 * Aqilix Doctrine ORM Module
 *
 * @copyright Copyright (c) 2014-2015
 */

namespace Aqilix\ORM\Mapper;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Trait for EntityManager
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
trait EntityManagerTrait
{
    /**
     * The entity manager object.
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * Set the entity manager.
     *
     * @param  \Doctrine\ORM\EntityManagerInterface  $entityManager
     *
     * @return self
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
        return $this;
    }

    /**
     * Get the entity manager.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     **/
    public function getEntityManager()
    {
        return $this->em;
    }
}
