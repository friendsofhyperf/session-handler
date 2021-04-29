# session-handler

[![Latest Stable Version](https://poser.pugx.org/friendsofhyperf/session-handler/version.png)](https://packagist.org/packages/friendsofhyperf/session-handler)
[![Total Downloads](https://poser.pugx.org/friendsofhyperf/session-handler/d/total.png)](https://packagist.org/packages/friendsofhyperf/session-handler)
[![GitHub license](https://img.shields.io/github/license/friendsofhyperf/session-handler)](https://github.com/friendsofhyperf/session-handler)

## Installation

```bash
composer require friendsofhyperf/session-handler
```

## Configure

- Memcache/Memcached for singleton

```php
// config/session.php

return [
    'handler' => FriendsOfHyperf\SessionHandler\Handler\MemcacheHandler::class,
    // or
    // 'handler' => FriendsOfHyperf\SessionHandler\Handler\MemcachedHandler::class,
    'options' => [
        'path' => 'tcp://127.0.0.1:11211',
        'gc_maxlifetime' => 1200,
        'session_name' => 'HYPERF_SESSION_ID',
        'domain' => null,
        'cookie_lifetime' => 5 * 60 * 60,
    ],
];
```

- Memcache for cluster

```php
// config/session.php

return [
    'handler' => FriendsOfHyperf\SessionHandler\Handler\MemcacheHandler::class,
    'options' => [
        'path' => [
            ['127.0.0.1', 11211, 1],
            ['127.0.0.1', 11212, 1],
        ],
        'gc_maxlifetime' => 1200,
        'session_name' => 'HYPERF_SESSION_ID',
        'domain' => null,
        'cookie_lifetime' => 5 * 60 * 60,
    ],
];
```

Set dependencies

```php
// config/dependencies.php

return [
    FriendsOfHyperf\SessionHandler\Handler\MemcacheHandler::class => FriendsOfHyperf\SessionHandler\Handler\MemcacheHandlerClusterFactory::class,
];
```

## Drivers

- [x] Memcache `singleton`/`cluster`
- [x] Memcached `singleton`
