# session-handler

[![Latest Stable Version](https://poser.pugx.org/friendsofhyperf/session-handler/version.png)](https://packagist.org/packages/friendsofhyperf/session-handler)
[![Total Downloads](https://poser.pugx.org/friendsofhyperf/session-handler/d/total.png)](https://packagist.org/packages/friendsofhyperf/session-handler)
[![GitHub license](https://img.shields.io/github/license/friendsofhyperf/session-handler)](https://github.com/friendsofhyperf/session-handler)

## Installation

```bash
composer require friendsofhyperf/session-handler
```

- memcache

```bash
composer require huizhang/memcache
```

- memcached

```bash
composer require easyswoole/memcache
```

## Configure

- Singleton

```php
// config/session.php

return [
    'handler' => FriendsOfHyperf\SessionHandler\Handler\MemcacheHandler::class,
    // or
    'handler' => FriendsOfHyperf\SessionHandler\Handler\MemcachedHandler::class,
    'options' => [
        // tcp://host:port
        'path' => 'tcp://127.0.0.1:11211',
        // or
        // [host, port]
        'path' => ['127.0.0.1', 11211],
        'gc_maxlifetime' => 1200,
        'session_name' => 'HYPERF_SESSION_ID',
        'domain' => null,
        'cookie_lifetime' => 5 * 60 * 60,
    ],
];
```

- Cluster `beta`

```php
// config/session.php

return [
    'handler' => FriendsOfHyperf\SessionHandler\Handler\MemcacheHandler::class,
    // or
    'handler' => FriendsOfHyperf\SessionHandler\Handler\MemcachedHandler::class,
    'options' => [
        'cluster' => true,
        'path' => [
            // [host, port, weight]
            ['127.0.0.1', 11211, 1],
            ['127.0.0.1', 11212, 1],
        ],
        // or
        // ['tcp://host:port#weight']
        'path' => [
            'tcp://127.0.0.1:11211#1',
            'tcp://127.0.0.1:11212#1',
        ],
        'gc_maxlifetime' => 1200,
        'session_name' => 'HYPERF_SESSION_ID',
        'domain' => null,
        'cookie_lifetime' => 5 * 60 * 60,
    ],
];
```

## Support drivers

- [x] Memcache
- [x] Memcached
