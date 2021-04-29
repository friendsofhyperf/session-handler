<?php

declare(strict_types=1);
/**
 * This file is part of session-handler.
 *
 * @link     https://github.com/friendsofhyperf/session-handler
 * @document https://github.com/friendsofhyperf/session-handler/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\ModelObserver;

use FriendsOfHyperf\SessionHandler\Handler\MemcachedHandler;
use FriendsOfHyperf\SessionHandler\Handler\MemcachedHandlerFactory;
use FriendsOfHyperf\SessionHandler\Handler\MemcacheHandler;
use FriendsOfHyperf\SessionHandler\Handler\MemcacheHandlerFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        defined('BASE_PATH') or define('BASE_PATH', '');

        return [
            'dependencies' => [
                MemcacheHandler::class => MemcacheHandlerFactory::class,
                MemcachedHandler::class => MemcachedHandlerFactory::class,
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'commands' => [],
            'listeners' => [],
            'publish' => [],
        ];
    }
}
