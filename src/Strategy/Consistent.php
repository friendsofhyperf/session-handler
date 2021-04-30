<?php

declare(strict_types=1);
/**
 * This file is part of session-handler.
 *
 * @link     https://github.com/friendsofhyperf/session-handler
 * @document https://github.com/friendsofhyperf/session-handler/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\SessionHandler\Strategy;

use FriendsOfHyperf\SessionHandler\Hashing\HashingInterface;

class Consistent implements StrategyInterface
{
    /**
     * @var HashingInterface
     */
    private $hasher;

    /**
     * @var array
     */
    private $servers = [];

    public function __construct(HashingInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function addServer(string $host, int $port, int $weight): void
    {
        $hash = $this->hasher->hash(sprintf('%s:%s', $host, $port));
        $this->servers[$hash] = [$host, $port];
        ksort($this->servers);
    }

    public function findServer(string $str): array
    {
        if (count($this->servers) > 1) {
            foreach ($this->servers as $hash => $server) {
                if ($this->hasher->hash($str) <= $hash) {
                    return $server;
                }
            }
        }

        return current($this->servers);
    }
}
