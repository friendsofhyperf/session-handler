<?php

declare(strict_types=1);
/**
 * This file is part of session-handler.
 *
 * @link     https://github.com/friendsofhyperf/session-handler
 * @document https://github.com/friendsofhyperf/session-handler/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\SessionHandler\Handler;

use EasySwoole\Memcache\Config;
use EasySwoole\Memcache\Memcache;

/**
 * @mixin \EasySwoole\Memcache\Memcache
 */
class MemcachedProxy
{
    /**
     * @var Memcache[]
     */
    private $clients;

    public function __construct(array $servers = [], int $gcMaxLifeTime = 1200)
    {
        foreach ($servers as $server) {
            [$host, $port] = $server;
            $this->clients[] = new Memcache(new Config([
                'host' => $host,
                'port' => $port,
            ]));
        }
    }

    public function __call($name, $arguments)
    {
        $index = random_int(0, count($this->clients) - 1);

        return $this->clients[$index]->{$name}(...$arguments);
    }
}
