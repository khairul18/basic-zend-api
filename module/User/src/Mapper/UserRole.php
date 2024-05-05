<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * Account Mapper
 */
class UserRole extends AbstractMapper implements MapperInterface
{

    protected $data = [];

    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\UserRole');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('userRole');
        $cacheKey = 'user_role_';

        // filter by name
        if (isset($params['name'])) {
            // var_dump($params['name']);exit;
            $qb->andWhere('userRole.name = :name')
            ->setParameter('name', $params['name']);
        }

        // filter by account
        if (isset($params['account'])) {
            $qb->andWhere('userRole.account = :account')
            ->setParameter('account', $params['account']);
        }

        // filter by parent
        if (isset($params['parent'])) {
            $qb->andWhere('userRole.parent = :parent')
            ->setParameter('parent', $params['parent']);
        }

        $sort = ($asc === false) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('userRole.createdAt', $sort);
        } else {
            $qb->orderBy('userRole.' . $order, $sort);
        }

        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600, $cacheKey);
        // $result = $query->getResult();
        return $query;
    }

    public function getRoleUpStream($roleUuid, array $roleData = [])
    {
        global $data;
        $data = $roleData;
        $roleEntity = $this->fetchOne($roleUuid);
        if (! is_null($roleEntity)) {
            array_push($data, $roleEntity->getName());
        }
        if (! is_null($roleEntity->getParent())) {
            $pid = $roleEntity->getParent()->getUuid();
            $this->getRoleUpStream($pid, $data);
        } 
        return $data;
    }

    public function getRoleDownStream($roleUuid, array $roleData = [])
    {
        global $data;
        $data = $roleData;
        $roleEntity = $this->fetchOne($roleUuid);
        if (! is_null($roleEntity)) {
            array_push($data, $roleEntity->getName());
        }
        $queryParams = [
            'parent' => $roleUuid,
            'account'=> $roleEntity->getAccount()->getUuid()
        ];
        $childEntity = $this->fetchOneBy($queryParams);
        
        if (! is_null($childEntity)) {
            $pid = $childEntity->getUuid();
            $this->getRoleDownStream($pid, $data);
        } 
        
        return $data;
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
