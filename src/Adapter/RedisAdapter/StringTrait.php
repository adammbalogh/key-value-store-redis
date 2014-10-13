<?php namespace AdammBalogh\KeyValueStore\Adapter\RedisAdapter;

use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
trait StringTrait
{
    use ClientTrait;

    /**
     * @param string $key
     * @param string $value
     *
     * @return int The length of the string after the append operation.
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function append($key, $value)
    {
        if (!$this->has($key)) {
            throw new KeyNotFoundException();
        }

        return $this->getClient()->append($key, $value);
    }

    /**
     * @param string $key
     *
     * @return int The value of key after the decrement
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function decrement($key)
    {
        if (!$this->has($key)) {
            throw new KeyNotFoundException();
        }

        return $this->getClient()->decr($key);
    }

    /**
     * @param string $key
     * @param int $decrement
     *
     * @return int The value of key after the decrement
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function decrementBy($key, $decrement)
    {
        if (!$this->has($key)) {
            throw new KeyNotFoundException();
        }

        return $this->getClient()->decrby($key, $decrement);
    }

    /**
     * @param string $key
     *
     * @return string The value of the key
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function get($key)
    {
        $getResult = $this->getClient()->get($key);
        if (is_null($getResult)) {
            throw new KeyNotFoundException();
        }

        return $getResult;
    }

    /**
     * @param string $key
     *
     * @return int
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function getValueLength($key)
    {
        $length = $this->getClient()->strlen($key);
        if ($length === 0) {
            throw new KeyNotFoundException();
        }

        return $length;
    }

    /**
     * @param string $key
     *
     * @return int The value of key after the increment
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function increment($key)
    {
        if (!$this->has($key)) {
            throw new KeyNotFoundException();
        }

        return $this->getClient()->incr($key);
    }

    /**
     * @param string $key
     * @param int $increment
     *
     * @return int The value of key after the increment
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function incrementBy($key, $increment)
    {
        if (!$this->has($key)) {
            throw new KeyNotFoundException();
        }

        return $this->getClient()->incrby($key, $increment);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool True if the set was successful, false if it was unsuccessful
     *
     * @throws \Exception
     */
    public function set($key, $value)
    {
        /* @var \Predis\Response\Status $status */
        $status = $this->getClient()->set($key, $value);

        if ($status->getPayload() !== 'OK') {
            return false;
        }

        return true;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool True if the set was successful, false if it was unsuccessful
     *
     * @throws \Exception
     */
    public function setIfNotExists($key, $value)
    {
        return (bool)$this->getClient()->setnx($key, $value);
    }
}
