<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserAccess Mapper
 */
class UserAccess extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\UserAccess');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');
        $cacheKey = 'user_access_';

        // filter by multiple role~access
        if (isset($params['role'])) {
            $qb->join('t.userRole', 'r');
            $roles = explode(',', $params['role']);
            $qb->andWhere('r.name IN (:role)')
            ->setParameter('role', array_values($roles));
        }

        // filter by name of company
        if (isset($params['name'])) {
            $name = '%'.$params['name'].'%';
            $qb->andWhere('c.name LIKE :name')
            ->setParameter('name', $name);
        }

        // filter by account_uuid - user logged in
        if (isset($params['account_uuid'])) {
            $qb->join('t.userProfile', 'u');
            $qb->andWhere('u.account = :account_uuid')
               ->setParameter('account_uuid', $params['account_uuid']);
        }

        // filter by user_profile_uuid
        if (isset($params['user_profile_uuid'])) {
            $qb->andWhere('t.userProfile = :user_profile_uuid')
            ->setParameter('user_profile_uuid', $params['user_profile_uuid']);
        }

        // filter by user_role_uuid
        if (isset($params['user_role_uuid'])) {
            $qb->andWhere('t.userRole = :user_role_uuid')
            ->setParameter('user_role_uuid', $params['user_role_uuid']);
        }

        // filter by role_down_stream 
        if (isset($params['role_down_stream'])) {
            $qb->join('t.userRole', 'r');
            // $statuses = explode(',', $params['role_down_stream']);
            $qb->andWhere('r.name IN (:role_down_stream)')
            ->setParameter('role_down_stream', $params['role_down_stream']);
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
}
