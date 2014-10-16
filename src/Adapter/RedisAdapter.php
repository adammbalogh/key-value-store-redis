<?php namespace AdammBalogh\KeyValueStore\Adapter;

use AdammBalogh\KeyValueStore\Adapter\RedisAdapter\ClientTrait;
use AdammBalogh\KeyValueStore\Adapter\RedisAdapter\KeyTrait;
use AdammBalogh\KeyValueStore\Adapter\RedisAdapter\ValueTrait;
use AdammBalogh\KeyValueStore\Adapter\RedisAdapter\ServerTrait;
use Predis\Client as RedisClient;

class RedisAdapter extends AbstractAdapter
{
    use ClientTrait, KeyTrait, ValueTrait, ServerTrait {
        ClientTrait::getClient insteadof KeyTrait;
        ClientTrait::getClient insteadof ValueTrait;
        ClientTrait::getClient insteadof ServerTrait;
    }

    /**
     * @var RedisClient
     */
    protected $client;

    /**
     * @param RedisClient $client
     */
    public function __construct(RedisClient $client)
    {
        $this->client = $client;
    }
}
