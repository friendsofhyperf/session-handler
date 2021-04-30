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

class Standard implements StrategyInterface
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
        if ($weight < 0) {
            $weight = 0;
        }

        for ($i = 0; $i < $weight; ++$i) {
            $this->servers[] = [$host, $port];
        }
    }

    public function findServer(string $str): array
    {
        if (count($this->servers) > 1) {
            $index = $this->hasher->hash($str) % count($this->servers);

            return $this->servers[$index];
        }

        return $this->servers[0];
    }
}
