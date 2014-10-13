<?php namespace AdammBalogh\KeyValueStore\Adapter\RedisAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsRedisTestCase;
use AdammBalogh\KeyValueStore\Adapter\RedisAdapter;
use AdammBalogh\KeyValueStore\KeyValueStore;
use Predis\Client as RedisClient;
use Predis\Response\Status;

class ServerTraitTest extends AbstractKvsRedisTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testFlush(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $status = new Status('OK');

        $dummyPredis->shouldReceive('flushdb')->andReturn($status);

        $this->assertNull($kvs->flush());
    }

    /**
     * @expectedException \Exception
     *
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testFlushError(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $status = new Status('QUEUED');

        $dummyPredis->shouldReceive('flushdb')->andReturn($status);

        $kvs->flush();
    }
}
