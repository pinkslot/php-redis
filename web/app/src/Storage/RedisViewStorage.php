<?php

namespace App\Acme\Storage;

use App\Acme\Service\ViewService\Exception\StorageException;
use App\Acme\Service\ViewService\ViewStorageInterface;
use Redis;
use Throwable;

class RedisViewStorage implements ViewStorageInterface
{
    private const HASH_KEY = 'viewsByCountries';

    private ?Redis $redisClient = null;
    private string $host;
    private int $port;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    private function getRedisClient(): Redis
    {
        $redisClient = new Redis();
        $redisClient->connect($this->host, 6379);

        $this->redisClient = $redisClient;

        return $this->redisClient;
    }

    public function increase(string $countryCode): void
    {
        try {
            $this->getRedisClient()->hIncrBy(static::HASH_KEY, $countryCode, 1);
        } catch (Throwable $exception) {
            throw new StorageException("Error occurred during accessing redis storage: {$exception->getMessage()}");
        }
    }

    public function getAll(): array
    {
        try {
            return $this->getRedisClient()->hGetAll(static::HASH_KEY);
        } catch (Throwable $exception) {
            throw new StorageException("Error occurred during accessing redis storage: {$exception->getMessage()}");
        }
    }
}
