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

class MemcacheHandlerClusterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);
        $gcMaxLifetime = $config->get('session.options.gc_maxlifetime', 1200);

        /** @var array $servers [[host,port,weight],[host,port,weight]] or ['tcp://host:port#weight', 'tcp://host:port#weight'] */
        $path = $config->get('session.options.path', []);
        $servers = [];

        foreach ($path as $server) {
            if (is_array($server)) {
                $server = PathParser::fromArray($server);
            } elseif (is_string($server)) {
                $server = PathParser::fromUrl($server);
            }
            $servers[] = $server;
        }

        return new MemcacheHandler($servers, $gcMaxLifetime);
    }
}
