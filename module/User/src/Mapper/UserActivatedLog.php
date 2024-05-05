<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserProfile Mapper
 */
class UserActivatedLog extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\UserActivatedLog');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');

        // filter by user_profile_uuid
        if (isset($params['user_profile_uuid'])) {
            $qb->andWhere('t.userProfile = :user_profile_uuid')
            ->setParameter('user_profile_uuid', $params['user_profile_uuid']);
        }

        // filter by active
        if (isset($params['active'])) {
            $qb->andWhere('t.isActive = :active')
            ->setParameter('active', $params['active']);
        }

        $sort = ($asc == 0) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('t.createdAt', $sort);
        } else {
            $qb->orderBy('t.' . $order, $sort);
        }

        // filter by account
        if (isset($params['account'])) {
            $qb->andWhere('t.account = :account')
            ->setParameter('account', $params['account']);
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600);
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
}
