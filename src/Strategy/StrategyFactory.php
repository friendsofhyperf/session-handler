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

class StrategyFactory
{
    const DEFAULT_STRATEGY = 'consistent';

    public function get($type = self::DEFAULT_STRATEGY, HashingInterface $hasher): StrategyInterface
    {
        if ($type == self::DEFAULT_STRATEGY) {
            return new Consistent($hasher);
        }

        return new Standard($hasher);
    }
}
