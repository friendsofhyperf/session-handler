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

use FriendsOfHyperf\SessionHandler\Hashing\HashingFactory;
use FriendsOfHyperf\SessionHandler\PathParser;
use FriendsOfHyperf\SessionHandler\Strategy\StrategyFactory;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

class MemcacheHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);
        /** @var StrategyFactory $strategyFactory */
        $strategyFactory = $container->get(StrategyFactory::class);
        /** @var HashingFactory $hashFactory */
        $hashFactory = $container->get(HashingFactory::class);
        /** @var PathParser $parser */
        $parser = $container->get(PathParser::class);

        $gcMaxLifetime = $config->get('session.options.gc_maxlifetime', 1200);
        /** @var array|string $path */
        $path = $config->get('session.options.path', '');
        $cluster = (bool) $config->get('session.options.cluster', false);
        $hashStrategy = (bool) $config->get('session.options.hash_strategy', 'consistent');
        $hashFunction = (bool) $config->get('session.options.hash_function', 'crc32');
        $strategy = $strategyFactory->get($hashStrategy, $hashFactory->get($hashFunction));
        $servers = $parser->parse($path, $cluster);

        foreach ($servers as [$host, $port, $weight]) {
            $strategy->addServer($host, $port, $weight);
        }

        return new MemcacheHandler($strategy, $gcMaxLifetime);
    }
}
