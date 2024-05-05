<?php

namespace Department\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Department Mapper
 */
class Department extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('Department\\Entity\\Department');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');
        $cacheKey = 'department_';

        // filter by account_uuid
        if (isset($params['account_uuid'])) {
            $qb->andWhere('t.account = :account_uuid')
            ->setParameter('account_uuid', $params['account_uuid']);
        }

        // filter by company_uuid
        if (isset($params['company_uuid'])) {
            $qb->andWhere('t.company = :company_uuid')
            ->setParameter('company_uuid', $params['company_uuid']);
        }

        // filter by branch_uuid
        if (isset($params['branch_uuid'])) {
            $qb->andWhere('t.branch = :branch_uuid')
            ->setParameter('branch_uuid', $params['branch_uuid']);
        }

        // filter by is_active
        if (isset($params['is_active'])) {
            $qb->andWhere('t.isActive = :is_active')
            ->setParameter('is_active', $params['is_active']);
        }

        $sort = ($asc === false) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('t.createdAt', $sort);
        } else {
            $qb->orderBy('t.' . $order, $sort);
        }

        $qb->andWhere('t.company IS NOT NULL');
        $qb->andWhere('t.branch IS NOT NULL');
        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600, $cacheKey);
        return $query;
    }
}
