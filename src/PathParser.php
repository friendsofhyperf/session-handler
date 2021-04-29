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
    /**
     * @param array|string $path
     * @param bool $cluster
     */
    public static function parse($path, $cluster = false): array
    {
        if ($cluster) {
            /** @var array $servers [[host,port,weight],[host,port,weight]] or ['tcp://host:port#weight', 'tcp://host:port#weight'] */
            $servers = [];

            foreach ($path as $server) {
                if (is_array($server)) {
                    $server = self::fromArray($server);
                } elseif (is_string($server)) {
                    $server = self::fromUrl($server);
                }
                $servers[] = $server;
            }
        } else {
            /** @var array|string $path tcp://host:port or [host, port] */
            if (is_string($path)) {
                [$host, $port] = self::fromUrl($path);
            } elseif (is_array($path)) {
                [$host, $port] = self::fromArray($path);
            } else {
                throw new \InvalidArgumentException('Invalid type of \'session.options.path\'');
            }

            $servers = [
                [
                    'host' => $host,
                    'port' => $port,
                ],
            ];
        }

        return $servers;
    }

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
