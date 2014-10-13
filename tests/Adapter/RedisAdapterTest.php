<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\AbstractKvsRedisTestCase;
use AdammBalogh\KeyValueStore\KeyValueStore;
use Predis\Client as RedisClient;

class RedisAdapterTest extends AbstractKvsRedisTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testInstantiation(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        new RedisAdapter($dummyPredis);
    }
}
