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

use FriendsOfHyperf\SessionHandler\PathParser;
use Hyperf\Contract\ConfigInterface;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class MemcachedHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);
        $gcMaxLifetime = $config->get('session.options.gc_maxlifetime', 1200);
        /** @var array|string $path tcp://host:port or [host, port] */
        $path = $config->get('session.options.path', 'tcp://127.0.0.1:11211');

        if (is_string($path)) {
            [$host, $port] = PathParser::fromUrl($path);
        } elseif (is_array($path)) {
            [$host, $port] = PathParser::fromArray($path);
        } else {
            throw new InvalidArgumentException('Invalid type of \'session.options.path\'');
        }

        $servers = [
            [
                'host' => $host,
                'port' => $port,
            ],
        ];

        return new MemcachedHandler($servers, $gcMaxLifetime);
    }
}
