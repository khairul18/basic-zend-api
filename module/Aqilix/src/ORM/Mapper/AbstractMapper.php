<?php

namespace Aqilix\ORM\Mapper;

use Aqilix\ORM\Entity\EntityInterface;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;

/**
 * Abstract Mapper with Doctrine support
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
abstract class AbstractMapper implements MapperInterface
{
    use EntityManagerTrait;

    /**
     * Save entity.
     *
     * @param  \Aqilix\ORM\Entity\EntityInterface $entity
     * @return \Aqilix\ORM\Entity\EntityInterface
     */
    public function save(EntityInterface $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    /**
     * Fetch single record by id.
     *
     * @param  mixed  $id
     * @return object|null
     */
    public function fetchOne($id)
    {
        return $this->getEntityRepository()->findOneBy(['uuid' => $id]);
    }

    /**
     * Fetch single record with params.
     *
     * @param  array  $params
     * @return object|null
     */
    public function fetchOneBy($params = [])
    {
        return $this->getEntityRepository()->findOneBy($params);
    }

    /**
     * Fetch multiple records with params.
     *
     * @param  array  $params
     * @param  mixed|null  $order
     * @param  bool  $asc
     * @return \Doctrine\ORM\Query
     */
    public function fetchAll(array $params, $order = null, $asc = false)
    {
    }


    /**
     * Get paginator adapter.
     *
     * @param  \Doctrine\ORM\QueryBuilder  $queryBuilder
     * @return \DoctrineORMModule\Paginator\Adapter\DoctrinePaginator
     */
    public function createPaginatorAdapter($queryBuilder)
    {
        $doctrinePaginator = new DoctrinePaginator($queryBuilder, true);
        $adapter = new DoctrinePaginatorAdapter($doctrinePaginator);

        return $adapter;
    }

    /**
     * Delete entity.
     *
     * @param  \Aqilix\ORM\Entity\EntityInterface  $entity
     * @return void
     */
    public function delete(EntityInterface $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Get entity repository.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
    }
}
