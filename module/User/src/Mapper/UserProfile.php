<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserProfile Mapper
 */
class UserProfile extends AbstractMapper implements MapperInterface
{
    const KM_CONVERSION = 6371;

    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\UserProfile');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');

        // filter by role
        if (isset($params['role'])) {
            $roles  = explode(',', $params['role']);
            $scopes = $qb->expr()->in('t.role', $roles);
            $qb->add('where', $scopes);
        }

        // filter by branch_uuid
        if (isset($params['parent_uuid'])) {
            $qb->andWhere('t.parent = :parent_uuid')
                ->setParameter('parent_uuid', $params['parent_uuid']);
        }

        // filter by department_uuid
        if (isset($params['department_uuid'])) {
            $qb->andWhere('t.department = :department_uuid')
                ->setParameter('department_uuid', $params['department_uuid']);
        }

        // filter by branch_uuid
        if (isset($params['branch_uuid'])) {
            $qb->andWhere('t.branch = :branch_uuid')
                ->setParameter('branch_uuid', $params['branch_uuid']);
        }

        // filter by company_uuid
        if (isset($params['company_uuid'])) {
            $qb->andWhere('t.company = :company_uuid')
                ->setParameter('company_uuid', $params['company_uuid']);
        }

        // filter by position_uuid
        if (isset($params['position_uuid'])) {
            $qb->andWhere('t.position = :position_uuid')
                ->setParameter('position_uuid', $params['position_uuid']);
        }

        // filter by employment_type_uuid
        if (isset($params['employment_type_uuid'])) {
            $qb->andWhere('t.employmentType = :employment_type_uuid')
                ->setParameter('employment_type_uuid', $params['employment_type_uuid']);
        }

        // filter by location_group_uuid
        if (isset($params['location_group_uuid'])) {
            $qb->andWhere('t.locationGroup = :location_group_uuid')
                ->setParameter('location_group_uuid', $params['location_group_uuid']);
        }

        // filter by parent
        if (isset($params['parent'])) {
            if ($params['parent'] == 'null') {
                $qb->andWhere('t.parent IS NULL');
            } else {
                $qb->andWhere('t.parent = :parentUuid')
                    ->setParameter('parentUuid', $params['parent']);
            }
        }

        // filter by name
        if (isset($params['search'])) {
            $qb->join('t.username', 'o');
            $qb->andWhere('o.username LIKE :search')
                ->setParameter('search', '%' . $params['search'] . '%');
        }

        // filter by search_employee
        if (isset($params['search_employee'])) {
            $searchEmployee = '%' . $params['search_employee'] . '%';
            $qb->andWhere('t.firstName like :search_employee')
                ->orWhere('t.lastName like :search_employee')
                ->setParameter('search_employee', $searchEmployee);
        }

        // filter by address
        if (isset($params['address'])) {
            $qb->andWhere('t.address LIKE :address')
                ->setParameter('address', '%' . $params['address'] . '%');
        }

        // filter by email
        if (isset($params['email'])) {
            $qb->andWhere('t.email = :email')
                ->setParameter('email', $params['email']);
        }

        // filter username fix
        if (isset($params['username'])) {
            $qb->andWhere('t.username = :username')
                ->setParameter('username', $params['username']);
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

    public function findNearestFrom($latitude, $longitude, $radius)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('ua')
            ->addSelect(
                '(' . self::KM_CONVERSION . '*
                            ACOS(
                            COS( RADIANS( ua.latitude ) ) *
                            COS( RADIANS( ' . $latitude  . ' ) ) *
                            COS( RADIANS( ' . $longitude . ' ) -
                            RADIANS( ua.longitude ) ) +
                            SIN( RADIANS( ua.latitude ) ) *
                            SIN( RADIANS( ' . $latitude . ') )
                            )
                        ) AS distance'
            )
            ->having('distance < :distance')
            ->setParameter('distance', $radius)
            ->orderBy('distance', 'ASC');

        $result = $qb->getQuery()->getResult();
        return $result;
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
