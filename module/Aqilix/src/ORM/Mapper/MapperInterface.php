<?php

namespace Aqilix\ORM\Mapper;

use Doctrine\ORM\EntityManagerInterface;
use Aqilix\ORM\Entity\EntityInterface;

/**
 * Interface of Entity
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
interface MapperInterface
{
    /**
     * @param  \Doctrine\ORM\EntityManagerInterface  $em
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $em);

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager();

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository();

    /**
     * @param  mixed  $id
     * @return \Doctrine\ORM\Query
     */
    public function fetchOne($id);

    /**
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     */
    public function fetchAll(array $params);

    /**
     * @param  \Aqilix\ORM\Entity\EntityInterface  $entity
     * @return \Aqilix\ORM\Entity\EntityInterface
     */
    public function save(EntityInterface $entity);

    /**
     * @param  \Aqilix\ORM\Entity\EntityInterface  $entity
     * @return void
     */
    public function delete(EntityInterface $entity);
}
