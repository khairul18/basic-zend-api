<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Branch Mapper
 */
class Branch extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\Branch');
    }

    public function fetchAll(array $params = [], $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');
        // filter by account
        if (isset($params['account'])) {
            $qb->andWhere('t.account = :account')
                ->setParameter('account', $params['account']);
        }

        // filter by is_active
        if (isset($params['is_active'])) {
            $qb->andWhere('t.isActive = :is_active')
                ->setParameter('is_active', $params['is_active']);
        }

        // filter by company_uuid
        if (isset($params['company_uuid'])) {
            $qb->andWhere('t.company = :company_uuid')
                ->setParameter('company_uuid', $params['company_uuid']);
        }

        // filter by exchange_id
        if (isset($params['exchange_id'])) {
            $qb->andWhere('t.exchangeId = :exchange_id')
                ->setParameter('exchange_id', $params['exchange_id']);
        }

        // filter by name
        if (isset($params['name'])) {
            $name = '%' . $params['name'] . '%';
            $qb->andWhere('t.name LIKE :name')
                ->setParameter('name', $name);
        }

        $sort = ($asc == 0) ? 'ASC' : 'DESC';
        if (is_null($order)) {
            $qb->orderBy('t.exchangeId', $sort);
        } else {
            $qb->orderBy('t.' . $order, $sort);
        }
        $qb->andWhere('t.company IS NOT NULL');
        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600);
        return $query;
    }
}
