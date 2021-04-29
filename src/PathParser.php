<?php

declare(strict_types=1);
/**
 * This file is part of session-handler.
 *
 * @link     https://github.com/friendsofhyperf/session-handler
 * @document https://github.com/friendsofhyperf/session-handler/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\SessionHandler;

class PathParser
{
    public static function fromUrl(string $path): array
    {
        return [
            parse_url($path, PHP_URL_HOST) ?: '127.0.0.1',
            parse_url($path, PHP_URL_PORT) ?: 11211,
            (int) parse_url($path, PHP_URL_FRAGMENT) ?: 1,
        ];
    }

    public static function fromArray(array $path): array
    {
        return [
            $path[0] ?? '127.0.0.1',
            (int) ($path[1] ?? 11211),
            (int) ($path[2] ?? 1),
        ];
    }
}
