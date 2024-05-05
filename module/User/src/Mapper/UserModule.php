<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserModule Mapper
 */
class UserModule extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('User\\Entity\\UserModule');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('userModule');
        $cacheKey = 'user_module_';

        // filter by name of module
        if (isset($params['name'])) {
            $name = '%'.$params['name'].'%';
            $qb->andWhere('userModule.name LIKE :name')
            ->setParameter('name', $name);
        }

        // filter by parent
        if (isset($params['parent'])) {
            $qb->andWhere('userModule.parent = :parent')
            ->setParameter('parent', $params['parent']);
        }

        $sort = ($asc === false) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('userModule.createdAt', $sort);
        } else {
            $qb->orderBy('userModule.' . $order, $sort);
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
