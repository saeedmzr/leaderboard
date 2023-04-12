<?php

namespace App\Services;

use Redis;
use RedisException;

class ScoreService
{
    private Redis $redisClient;

    /**
     * @throws RedisException
     */
    public function __construct()
    {
        $this->redisClient = new Redis();
        $this->redisClient->connect('localhost', 6379);
    }

    /**
     * @throws RedisException
     */
    public function getTopList(): array|\Redis
    {
        return $this->redisClient->zRevRange('leaderboard', 0, 99, array('withscores' => true));
    }

    /**
     * @throws RedisException
     */
    public function getAround($userId, $number = 5): array|Redis
    {
        $rank = $this->redisClient->zRevRank('leaderboard', $userId);
        if ($number - $rank > 0) {
            $min = 0;
        } else {
            $min = $rank - $number;
        }
        return $this->redisClient->zRevRange('leaderboard',$min , $rank + $number,
            array('withscores' => true));
    }

}
