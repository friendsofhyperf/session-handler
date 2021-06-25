<?php

declare(strict_types=1);
/**
 * This file is part of session-handler.
 *
 * @link     https://github.com/friendsofhyperf/session-handler
 * @document https://github.com/friendsofhyperf/session-handler/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\SessionHandler\Hashing;

class HashingFactory
{
    public const DEFAULT_FUNCTION = 'crc32';

    public function get($function = self::DEFAULT_FUNCTION): HashingInterface
    {
        return new Crc32();
    }
}
