<?php

namespace Notification\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Notification Mapper
 */
class Notification extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('Notification\\Entity\\Notification');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');

        // filter by userProfile
        if (isset($params['userProfile'])) {
            $qb->andWhere('t.userProfile = :userProfile')
               ->setParameter('userProfile', $params['userProfile']);
        }

        // filter by Admin Notif Only
        if (isset($params['admin'])) {
            $qb->andWhere('t.isAdmin = :admin')
               ->setParameter('admin', $params['admin']);
        }

        // filter by Unread notif
        if (isset($params['unread'])) {
            $qb->andWhere('t.unread = :unread')
               ->setParameter('unread', $params['unread']);
        }

        // view all broadcast message for tenant
        // if (isset($params['type'])) {
        //     $qb->orWhere('t.type LIKE :type')
        //     ->setParameter('type', '%'.$params['type'].'%');
        // }

        // filter by type
        if (isset($params['type'])) {
            $qb->andWhere('t.type LIKE :type')
            ->setParameter('type', '%'.$params['type'].'%');
        }

        // filter by status_type
        if (isset($params['status_type'])) {
            $statuses = explode(',', $params['status_type']);
            $qb->andWhere('t.type IN (:status)')
            ->setParameter('status', array_values($statuses));
        }

        // filter by pilgrim
        if (isset($params['pilgrim_uuid'])) {
            $qb->andWhere('t.pilgrim = :pilgrim_uuid')
               ->setParameter('pilgrim_uuid', $params['pilgrim_uuid']);
        }

        // filter by registrar
        if (isset($params['registrar_uuid'])) {
            $qb->andWhere('t.registrar = :registrar_uuid')
               ->setParameter('registrar_uuid', $params['registrar_uuid']);
        }

        // filter by user profile
        if (isset($params['user_profile'])) {
            $qb->andWhere('t.userProfile = :user_profile')
               ->setParameter('user_profile', $params['user_profile']);
        }

        $sort = ($asc == 0) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('t.createdAt', $sort);
        } else {
            $qb->orderBy('t.' . $order, $sort);
        }
        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600);
        return $query;
    }
}
