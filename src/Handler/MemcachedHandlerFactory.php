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
use Psr\Container\ContainerInterface;

class MemcachedHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);
        $gcMaxLifetime = $config->get('session.options.gc_maxlifetime', 1200);
        /** @var array|string $path */
        $path = $config->get('session.options.path', '');
        $cluster = (bool) $config->get('session.options.cluster', false);
        $servers = PathParser::parse($path, $cluster);

        return new MemcachedHandler($servers, $gcMaxLifetime);
    }
}
