<?php namespace AdammBalogh\KeyValueStore\Adapter\RedisAdapter;

use AdammBalogh\KeyValueStore\AbstractKvsRedisTestCase;
use AdammBalogh\KeyValueStore\Adapter\RedisAdapter;
use AdammBalogh\KeyValueStore\KeyValueStore;
use Predis\Client as RedisClient;
use Predis\Response\Status;

class StringTraitTest extends AbstractKvsRedisTestCase
{
    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testAppend(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(1);
        $dummyPredis->shouldReceive('append')->with('key-e', 'appended')->andReturn(13);

        $this->assertEquals(13, $kvs->append('key-e', 'appended'));
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
    public function testAppendKeyNotFound(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(0);
        $dummyPredis->shouldReceive('append')->with('key-e', 'appended')->andReturn(13);

        $kvs->append('key-e', 'appended');
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testDecrement(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(1);
        $dummyPredis->shouldReceive('decr')->with('key-e')->andReturn(2);

        $this->assertEquals(2, $kvs->decrement('key-e'));
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
    public function testDecrementKeyNotFound(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(0);
        $dummyPredis->shouldReceive('decr')->with('key-e')->andReturn(2);

        $kvs->decrement('key-e');
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testDecrementBy(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(1);
        $dummyPredis->shouldReceive('decrby')->with('key-e', 5)->andReturn(2);

        $this->assertEquals(2, $kvs->decrementBy('key-e', 5));
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
    public function testDecrementByKeyNotFound(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(0);
        $dummyPredis->shouldReceive('decrby')->with('key-e', 5)->andReturn(2);

        $kvs->decrementBy('key-e', 5);
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testGet(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('get')->with('key-e')->andReturn('value');

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
    public function testGetValueLenght(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('strlen')->with('key-e')->andReturn(7);

        $this->assertEquals(7, $kvs->getValueLength('key-e'));
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
    public function testGetValueLengthKeyNotFound(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('strlen')->with('key-e')->andReturn(0);

        $kvs->getValueLength('key-e');
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testIncrement(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(1);
        $dummyPredis->shouldReceive('incr')->with('key-e')->andReturn(2);

        $this->assertEquals(2, $kvs->increment('key-e'));
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
    public function testIncrementKeyNotFound(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(0);
        $dummyPredis->shouldReceive('incr')->with('key-e')->andReturn(2);

        $kvs->increment('key-e');
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testIncrementBy(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(1);
        $dummyPredis->shouldReceive('incrby')->with('key-e', 5)->andReturn(2);

        $this->assertEquals(2, $kvs->incrementBy('key-e', 5));
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
    public function testIncrementByKeyNotFound(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('exists')->with('key-e')->andReturn(0);
        $dummyPredis->shouldReceive('incrby')->with('key-e', 5)->andReturn(2);

        $kvs->incrementBy('key-e', 5);
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

        $dummyPredis->shouldReceive('set')->with('key-e', 'value')->andReturn($status);

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

        $dummyPredis->shouldReceive('set')->with('key-ne', 'value')->andReturn($status);

        $this->assertFalse($kvs->set('key-ne', 'value'));
    }

    /**
     * @dataProvider kvsProvider
     *
     * @param KeyValueStore $kvs
     * @param RedisAdapter $dummyRedisAdapter
     * @param RedisClient $dummyPredis
     */
    public function testSetIfNotExists(KeyValueStore $kvs, RedisAdapter $dummyRedisAdapter, RedisClient $dummyPredis)
    {
        $dummyPredis->shouldReceive('setnx')->with('key-e', 'value')->andReturn(1);
        $dummyPredis->shouldReceive('setnx')->with('key-ne', 'value')->andReturn(0);

        $this->assertTrue($kvs->setIfNotExists('key-e', 'value'));
        $this->assertFalse($kvs->setIfNotExists('key-ne', 'value'));
    }
}
