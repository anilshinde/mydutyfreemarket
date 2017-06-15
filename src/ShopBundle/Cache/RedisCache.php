<?php

namespace ShopBundle\Cache;

use Redis;

/**
 * Redis cache
 */
class RedisCache
{

    /**
     * Redis host
     */
    private $host;

    /**
     * Redis port
     */
    private $port;

    /**
     * Redis timeout
     */
    private $timeout;

    /**
     * Redis db
     *
     * @var int
     */
    private $db;

    /**
     * Redis connection
     */
    private $connection;

    /**
     */
    public function __construct($host, $port, $timeout, $db)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
        $this->db = $db;

        if (!$this->connection instanceof Redis) {
            $this->connect();
        }
    }

    private function connect()
    {
        $this->connection = new Redis();
        $this->connection->pconnect($this->host, $this->port, $this->timeout);
        $this->connection->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_NONE);
        $this->connection->select($this->db);
    }

    /**
     * Fetch content of key
     */
    public function fetch($key)
    {
        $value = $this->connection->get($key);
        $content = unserialize($value);
        return $content;
    }

    /**
     * Members of list
     */
    public function members($list)
    {
        return $this->connection->sMembers($list);
    }

    /**
     * Check key exists
     */
    public function exist($key)
    {
        return $this->connection->exists($key);
    }

    /**
     * Add member to list
     */
    public function add($list, $member)
    {
        return $this->connection->sAdd($list, $member);
    }

    /**
     * Save key content
     */
    public function save($key, $content, $expiration = 30)
    {
        if ($expiration > 0) {
            return $this->connection->setex($key, $expiration, serialize($content));
        } else {
            return $this->connection->set($key, serialize($content));
        }
    }

    /**
     * Remove member from a list
     */
    public function remove($list, $member)
    {
        return $this->connection->sRem($list, $member);
    }

    /**
     * Drop a key and its content
     */
    public function drop($key)
    {
        return $this->connection->delete($key) > 0;
    }

    /**
     * Flush all Redis database content
     */
    public function flushall()
    {
        return $this->connection->flushDb();
    }
}
