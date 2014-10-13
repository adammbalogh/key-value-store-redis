<?php namespace AdammBalogh\KeyValueStore\Adapter\RedisAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsRedisTestCase;
use AdammBalogh\KeyValueStore\Adapter\RedisAdapter;
use AdammBalogh\KeyValueStore\KeyValueStore;
use Predis\Client as RedisClient;

class KeyTraitTest extends AbstractKvsRedisTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testDelete(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('del')->with(['key-e'])->andReturn(1);
        $dummyPredis->shouldReceive('del')->with(['key-ne'])->andReturn(0);

        $this->assertTrue($kvs->delete('key-e'));
        $this->assertFalse($kvs->delete('key-ne'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testExpire(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('expire')->with('key-e', 5)->andReturn(1);
        $dummyPredis->shouldReceive('expire')->with('key-ne', 5)->andReturn(0);

        $this->assertTrue($kvs->expire('key-e', 5));
        $this->assertFalse($kvs->expire('key-ne', 5));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testGetKeys(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('keys')->andReturn(['a', 'b']);

        $this->assertCount(2, $kvs->getKeys());
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testGetTtl(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('ttl')->with('key-e')->andReturn(11);

        $this->assertEquals(11, $kvs->getTtl('key-e'));
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
    public function testGetTtlKeyNotFound(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('ttl')->with('key-ne')->andReturn(-2);

        $kvs->getTtl('key-ne');
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
    public function testGetTtlNoExpire(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('ttl')->with('key-ne')->andReturn(-1);

        $kvs->getTtl('key-ne');
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testHas(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(1);
        $dummyPredis->shouldReceive('exists')->with('key-ne')->andReturn(0);

        $this->assertTrue($kvs->has('key-e'));
        $this->assertFalse($kvs->has('key-ne'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testPersist(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('persist')->with('key-e')->andReturn(1);
        $dummyPredis->shouldReceive('persist')->with('key-ne')->andReturn(0);

        $this->assertTrue($kvs->persist('key-e'));
        $this->assertFalse($kvs->persist('key-ne'));
    }
}
