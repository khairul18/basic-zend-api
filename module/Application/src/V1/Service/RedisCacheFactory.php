<?php
namespace Application\V1\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RedisCacheFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $redis = new \Redis();
        $redisConfig = $container->get('Config')['redis'];
        $redis->connect($redisConfig['host'], $redisConfig['port']);
        $cacheDriver = new \Doctrine\Common\Cache\RedisCache();
        $cacheDriver->setRedis($redis);
        return $cacheDriver;
    }
}
