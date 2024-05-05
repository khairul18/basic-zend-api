<?php

namespace Department\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Group User Mapper
 */
class GroupUser extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('Department\\Entity\\GroupUser');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');
        $cacheKey = 'group_user_';

        // filter by group_uuid
        if (isset($params['group_uuid'])) {
            $qb->andWhere('t.groups = :group_uuid')
            ->setParameter('group_uuid', $params['group_uuid']);
        }

        // filter by user_profile_uuid
        if (isset($params['user_profile_uuid'])) {
            $qb->andWhere('t.userProfile = :user_profile_uuid')
            ->setParameter('user_profile_uuid', $params['user_profile_uuid']);
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
