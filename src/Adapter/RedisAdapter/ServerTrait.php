<?php namespace AdammBalogh\KeyValueStore\Adapter\RedisAdapter;

trait ServerTrait
{
    use ClientTrait;

    /**
     * Removes all keys.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function flush()
    {
        /* @var \Predis\Response\Status $status */
        $status = $this->getClient()->flushdb();

        if ($status->getPayload() !== 'OK') {
            throw new \Exception($status->getPayload());
        }
    }
}
