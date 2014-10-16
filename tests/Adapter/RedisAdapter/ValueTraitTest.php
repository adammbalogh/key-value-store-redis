<?php namespace AdammBalogh\KeyValueStore\Adapter\RedisAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsRedisTestCase;
use AdammBalogh\KeyValueStore\Adapter\RedisAdapter;
use AdammBalogh\KeyValueStore\KeyValueStore;
use Predis\Client as RedisClient;
use Predis\Response\Status;

class ValueTraitTest extends AbstractKvsRedisTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testGet(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('get')->with('key-e')->andReturn(serialize('value'));

        $this->assertEquals('value', $kvs->get('key-e'));
    }

    /**
     * @expectedException \AdammBalogh\KeyValueStore\Exception\KeyNotFoundException
     *
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testGetKeyNotFound(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('get')->with('key-e')->andReturn(null);

        $kvs->get('key-e');
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testSet(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $status = new Status('OK');

        $dummyPredis->shouldReceive('set')->with('key-e', serialize('value'))->andReturn($status);

        $this->assertTrue($kvs->set('key-e', 'value'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testSetError(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $status = new Status('QUEUED');

        $dummyPredis->shouldReceive('set')->with('key-ne', serialize('value'))->andReturn($status);

        $this->assertFalse($kvs->set('key-ne', 'value'));
    }
}
