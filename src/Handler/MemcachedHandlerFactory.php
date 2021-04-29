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
            [$host, $port] = [parse_url($path, PHP_URL_HOST) ?: '127.0.0.1', parse_url($path, PHP_URL_PORT) ?: 11211];
        } elseif (is_array($path)) {
            [$host, $port] = [$path[0] ?? '127.0.0.1', $path[1] ?: 11211];
        } else {
            throw new InvalidArgumentException('Invalid type of \'session.options.path\'');
        }

        $configure = new Config([
            'host' => $host,
            'port' => $port,
        ]);

        return new MemcachedHandler($configure, $gcMaxLifetime);
    }
}
