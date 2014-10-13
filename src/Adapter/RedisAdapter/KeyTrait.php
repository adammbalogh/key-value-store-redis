<?php namespace AdammBalogh\KeyValueStore\Adapter\RedisAdapter;

use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
trait KeyTrait
{
    use ClientTrait;

    /**
     * @param string $key
     *
     * @return bool True if the deletion was successful, false if the deletion was unsuccessful.
     *
     * @throws \Exception
     */
    public function delete($key)
    {
        return (bool)$this->getClient()->del([$key]);
    }

    /**
     * @param string $key
     * @param int $seconds
     *
     * @return bool True if the timeout was set, false if the timeout could not be set.
     *
     * @throws \Exception
     */
    public function expire($key, $seconds)
    {
        return (bool)$this->getClient()->expire($key, $seconds);
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getKeys()
    {
        return $this->getClient()->keys('*');
    }

    /**
     * Returns the remaining time to live of a key that has a timeout.
     *
     * @param string $key
     *
     * @return int Ttl in seconds
     *
     * @throws KeyNotFoundException
     * @throws \Exception
     */
    public function getTtl($key)
    {
        $ttl = $this->getClient()->ttl($key);
        if ($ttl === -2) {
            throw new KeyNotFoundException($key);
        } elseif ($ttl === -1) {
            throw new \Exception('Key exists but has no associated expire');
        }

        return $ttl;
    }

    /**
     * @param string $key
     *
     * @return bool True if the key does exist, false if the key does not exist.
     *
     * @throws \Exception
     */
    public function has($key)
    {
        return (bool)$this->getClient()->exists($key);
    }

    /**
     * Remove the existing timeout on key, turning the key from volatile (a key with an expire set)
     * to persistent (a key that will never expire as no timeout is associated).
     *
     * @param string $key
     *
     * @return bool True if the persist was success, false if the persis was unsuccessful.
     *
     * @throws \Exception
     */
    public function persist($key)
    {
        return (bool)$this->getClient()->persist($key);
    }
}
