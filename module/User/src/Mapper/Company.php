<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Company Mapper
 */
class Company extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\Company');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');
        $cacheKey = 'company_';

        // filter by account_uuid
        if (isset($params['account_uuid'])) {
            $qb->andWhere('c.account = :account_uuid')
                ->setParameter('account_uuid', $params['account_uuid']);
        }

        // filter by business_sector_uuid
        if (isset($params['business_sector_uuid'])) {
            $qb->andWhere('c.businessSector = :business_sector_uuid')
                ->setParameter('business_sector_uuid', $params['business_sector_uuid']);
        }

        // filter by name of company
        if (isset($params['name'])) {
            $name = '%' . $params['name'] . '%';
            $qb->andWhere('c.name LIKE :name')
                ->setParameter('name', $name);
        }

        // filter by is_active
        if (isset($params['is_active'])) {
            $qb->andWhere('c.isActive = :is_active')
                ->setParameter('is_active', $params['is_active']);
        }

        $sort = ($asc === false) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('c.createdAt', $sort);
        } else {
            $qb->orderBy('c.' . $order, $sort);
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600, $cacheKey);
        return $query;
    }
}
