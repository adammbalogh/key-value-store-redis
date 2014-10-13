<?php namespace AdammBalogh\KeyValueStore;

use AdammBalogh\KeyValueStore\Adapter\RedisAdapter;
use Predis\Client as RedisClient;

abstract class AbstractKvsRedisTestCase extends \PHPUnit_Framework_TestCase
{
    public function getDummyPredis()
    {
        return \Mockery::mock('Predis\Client');
    }

    public function getDummyRedisAdapter(RedisClient $predis)
    {
        return new RedisAdapter($predis);
    }

    public function kvsProvider()
    {
        $dummyPredis = $this->getDummyPredis();
        $dummyRedisAdapter = $this->getDummyRedisAdapter($dummyPredis);

        return [
            [
                new KeyValueStore($dummyRedisAdapter),
                $dummyRedisAdapter,
                $dummyPredis
            ]
        ];
    }
}
