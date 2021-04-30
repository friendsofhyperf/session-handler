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

class Crc32 implements HashingInterface
{
    public function hash(string $str): string
    {
        return sprintf('%u', crc32($str));
    }
}
