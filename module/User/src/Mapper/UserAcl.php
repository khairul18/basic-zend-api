<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;
use Aqilix\ORM\Entity\EntityInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Account Mapper
 */
class UserAcl extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\UserAcl');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('userAcl');
        $cacheKey = 'user_acl_';

        // filter by user_role_uuid
        if (isset($params['user_role_uuid'])) {
            $qb->andWhere('userAcl.userRole = :user_role_uuid')
            ->setParameter('user_role_uuid', $params['user_role_uuid']);
        }

        // filter by user_module_uuid
        if (isset($params['user_module_uuid'])) {
            $qb->andWhere('userAcl.userModule = :user_module_uuid')
            ->setParameter('user_module_uuid', $params['user_module_uuid']);
        }

        $sort = ($asc === false) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('userAcl.createdAt', $sort);
        } else {
            $qb->orderBy('userAcl.' . $order, $sort);
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600, $cacheKey);
        // $result = $query->getResult();
        return $query;
    }

    /**
     * Fetch single records with params
     *
     * @param array $params
     * @return object
     */
    public function fetchBy($params = [])
    {
        return $this->getEntityRepository()->findBy($params);
    }

    /**
     * Delete Entity
     *
     * @param EntityInterface $entity
     */
    public function delete(EntityInterface $entity)
    {
        $this->getEntityManager()->getFilters()->disable('soft-deleteable');

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

}
