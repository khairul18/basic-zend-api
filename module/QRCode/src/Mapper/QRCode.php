<?php

namespace QRCode\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Visitor Mapper
 */
class QRCode extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('QRCode\\Entity\\QRCode');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');
        $cacheKey = 'qr_code_list_';

        // filter by account
        if (isset($params['account'])) {
            $qb->andWhere('t.account = :account')
            ->setParameter('account', $params['account']);
        }

        // filter by start date and end date
        if (isset($params['start_date']) && isset($params['end_date'])) {
            $startDate = $params['start_date'];
            $endDate   = $params['end_date'];
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $startDate) &&
                preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $endDate)) {
                $startDate = new \DateTime($startDate); // default is 00:00:00
                $endDate   = new \DateTime($endDate . ' 23:59:59'); // set to 23:59:59
                $qb->andWhere('t.createdAt >= :startDate')
                   ->setParameter('startDate', $startDate);
                $qb->andWhere('t.createdAt <= :endDate')
                   ->setParameter('endDate', $endDate);
            }
        }

        // filter by isAvailable
        if (isset($params['available'])) {
            $qb->andWhere('t.isAvailable = :available')
            ->setParameter('available', $params['available']);
        }

        $sort = ($asc === false) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('t.createdAt', $sort);
        } else {
            $qb->orderBy('t.' . $order, $sort);
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600, $cacheKey);
        return $query;
    }
}
