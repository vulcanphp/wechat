<?php

namespace App\Core;

use App\Core\PusherClient\PusherClient;

class Pusher
{
    public static PusherClient $client;

    public function __construct(protected array $config)
    {
        self::$client = new PusherClient($this->config);
    }

    public static function setup(...$args): Pusher
    {
        return new Pusher(...$args);
    }

    public function __call($name, $arguments)
    {
        return call_user_func([self::$client, $name], ...$arguments);
    }
}
