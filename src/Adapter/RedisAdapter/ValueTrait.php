<?php namespace AdammBalogh\KeyValueStore\Adapter\RedisAdapter;

use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
trait ValueTrait
{
    use ClientTrait;

    /**
     * Gets the value of a key.
     *
     * @param string $key
     *
     * @return mixed The value of the key.
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

        return unserialize($getResult);
    }

    /**
     * Sets the value of a key.
     *
     * @param string $key
     * @param mixed $value Can be any of serializable data type.
     *
     * @return bool True if the set was successful, false if it was unsuccessful.
     *
     * @throws \Exception
     */
    public function set($key, $value)
    {
        /* @var \Predis\Response\Status $status */
        $status = $this->getClient()->set($key, serialize($value));

        if ($status->getPayload() !== 'OK') {
            return false;
        }

        return true;
    }
}
