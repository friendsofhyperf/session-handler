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

use FriendsOfHyperf\SessionHandler\Strategy\StrategyInterface;
use Huizhang\Memcache\Config;
use Huizhang\Memcache\Memcache;

/**
 * @mixin \Huizhang\Memcache\Memcache
 */
class MemcacheProxy
{
    /**
     * @var Memcache[]
     */
    private $clients;

    /**
     * @var StrategyInterface
     */
    private $strategy;

    public function __construct(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function __call($name, $arguments)
    {
        $key = $arguments[0] ?? '';
        [$host, $port] = $this->strategy->findServer($key);
        $hash = sprintf('%s:%s', $host, $port);

        if (! isset($this->clients[$hash])) {
            $config = new Config();
            $config->setServers([[$host, $port]]);
            $this->clients[$hash] = new Memcache($config);
        }

        return $this->clients[$hash]->{$name}(...$arguments);
    }
}
