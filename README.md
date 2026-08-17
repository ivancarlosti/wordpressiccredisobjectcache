# ICC.gg Redis Object Cache Enabler

A WordPress plugin that provides a persistent object cache backend powered by Redis®¹. It supports Predis, PhpRedis, Relay, replication, sentinels, clustering and WP-CLI.

<!-- buttons -->
[![Stars](https://img.shields.io/github/stars/ivancarlosti/wordpressiccredisobjectcache?label=⭐%20Stars&color=gold&style=flat)](https://github.com/ivancarlosti/wordpressiccredisobjectcache/stargazers)
[![Watchers](https://img.shields.io/github/watchers/ivancarlosti/wordpressiccredisobjectcache?label=Watchers&style=flat&color=red)](https://github.com/sponsors/ivancarlosti)
[![Forks](https://img.shields.io/github/forks/ivancarlosti/wordpressiccredisobjectcache?label=Forks&style=flat&color=ff69b4)](https://github.com/sponsors/ivancarlosti)
[![Downloads](https://img.shields.io/github/downloads/ivancarlosti/wordpressiccredisobjectcache/total?label=Downloads&color=success)](https://github.com/ivancarlosti/wordpressiccredisobjectcache/releases)
[![GitHub commit activity](https://img.shields.io/github/commit-activity/m/ivancarlosti/wordpressiccredisobjectcache?label=Activity)](https://github.com/ivancarlosti/wordpressiccredisobjectcache/pulse)
[![GitHub Issues](https://img.shields.io/github/issues/ivancarlosti/wordpressiccredisobjectcache?label=Issues&color=orange)](https://github.com/ivancarlosti/wordpressiccredisobjectcache/issues)  
[![License](https://img.shields.io/github/license/ivancarlosti/wordpressiccredisobjectcache?label=License)](LICENSE.md)
[![GitHub last commit](https://img.shields.io/github/last-commit/ivancarlosti/wordpressiccredisobjectcache?label=Last%20Commit)](https://github.com/ivancarlosti/wordpressiccredisobjectcache/commits)
[![Security](https://img.shields.io/badge/Security-View%20Here-purple)](https://github.com/ivancarlosti/wordpressiccredisobjectcache/security)
[![Code of Conduct](https://img.shields.io/badge/Code%20of%20Conduct-2.1-4baaaa)](https://github.com/ivancarlosti/wordpressiccredisobjectcache?tab=coc-ov-file)
<!-- endbuttons -->

## Features

- **Redis Object Cache Backend** — A drop-in [`object-cache.php`](includes/object-cache.php:1) replacement that stores WordPress object cache data in Redis
- **Multiple Clients** — Works with [Predis](https://github.com/predis/predis/) (bundled), [PhpRedis (PECL)](https://github.com/phpredis/phpredis) and [Relay](https://relaycache.com)
- **High Availability** — Supports replication, sentinels, clustering and sharding
- **One-Click Management** — Enable, disable, flush and update the object cache drop-in from **Settings → Redis**
- **Metrics Dashboard** — Track hit ratio, hits, misses, cache size, calls and response time with charts
- **Diagnostics** — Inspect the Redis server, client, connection and key configuration
- **Dashboard Widget** — View cache performance directly from the WordPress dashboard
- **Admin Bar Integration** — See cache status and flush the cache from the admin bar
- **Query Monitor Integration** — Inspect cache activity with the Query Monitor plugin
- **WP-CLI Support** — Enable, disable, update and inspect the object cache from the command line
- **Multisite Support** — Network-aware settings and cache groups
- **Graceful Degradation** — Optionally fall back to the default cache when Redis is unreachable

## Requirements

- WordPress 5.0+
- PHP 8.1+
- A running Redis server
- One of the following clients:
  - [Predis](https://github.com/predis/predis/) (bundled with the plugin)
  - [PhpRedis](https://github.com/phpredis/phpredis) (PECL extension)
  - [Relay](https://relaycache.com) (extension)

## Installation

1. Download the plugin or clone this repository into `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin panel
3. Go to **Settings → Redis** to configure and enable the object cache

## Quick Setup

1. Activate the plugin and open **Settings → Redis**
2. (Optional) Define your connection settings in `wp-config.php` — see the [Configuration](#configuration) section below
3. Click **Enable Object Cache** to install the `object-cache.php` drop-in
4. Verify the status shows **Connected** in the **Overview** tab

The plugin defaults to connecting to `127.0.0.1:6379` with database `0` when no connection constants are defined.

## Configuration

All settings can be defined as PHP constants in `wp-config.php` for added security and CI/CD support.

### Connection

| Constant | Description | Default |
|---|---|---|
| `WP_REDIS_HOST` | The Redis server hostname or IP address | `127.0.0.1` |
| `WP_REDIS_PORT` | The Redis server port | `6379` |
| `WP_REDIS_DATABASE` | The Redis database index | `0` |
| `WP_REDIS_PASSWORD` | The Redis password (optional) | `null` |
| `WP_REDIS_USERNAME` | The Redis ACL username (optional) | `null` |
| `WP_REDIS_SCHEME` | The connection scheme (`tcp`, `unix`, `tls`, `rediss`, etc.) | `tcp` |
| `WP_REDIS_PATH` | The socket path when using a Unix socket | `null` |
| `WP_REDIS_TIMEOUT` | Connection timeout in seconds | `1` |
| `WP_REDIS_READ_TIMEOUT` | Read timeout in seconds | `1` |
| `WP_REDIS_RETRY_INTERVAL` | Retry interval in milliseconds | `null` |

### Replication, Clustering & Sharding

| Constant | Description |
|---|---|
| `WP_REDIS_SERVERS` | Array of servers for replication (e.g., `['tcp://127.0.0.1:6379', 'tcp://127.0.0.1:6380']`) |
| `WP_REDIS_SHARDS` | Array of shard groups for client-side sharding |
| `WP_REDIS_CLUSTER` | Array of cluster nodes for Redis Cluster |
| `WP_REDIS_SENTINEL` | Array of sentinel nodes for high availability |

### Keys & Expiration

| Constant | Description |
|---|---|
| `WP_REDIS_PREFIX` | Key prefix for this site's cache |
| `WP_REDIS_SELECTIVE_FLUSH` | Flush only keys with `WP_REDIS_PREFIX` when set to `true` |
| `WP_REDIS_MAXTTL` | Maximum time-to-live for cache keys, in seconds |

### Groups

| Constant | Description |
|---|---|
| `WP_REDIS_GLOBAL_GROUPS` | Array of groups that are shared across a multisite network |
| `WP_REDIS_IGNORED_GROUPS` | Array of groups that are ignored by Redis |
| `WP_REDIS_UNFLUSHABLE_GROUPS` | Array of groups that are not flushed on `wp_cache_flush()` |

### Behavior

| Constant | Description |
|---|---|
| `WP_REDIS_CLIENT` | Force the Redis client (`predis`, `phpredis` or `relay`) |
| `WP_REDIS_DISABLED` | Disable the object cache entirely when set to `true` |
| `WP_REDIS_GRACEFUL` | Fail gracefully to the default cache when Redis is unreachable |
| `WP_REDIS_DISABLE_DROPIN_BANNERS` | Hide drop-in related admin notices |
| `WP_REDIS_DISABLE_DROPIN_AUTOUPDATE` | Disable automatic drop-in updates |
| `WP_REDIS_DISABLE_DROPIN_CHECK` | Skip filesystem write checks for the drop-in |
| `WP_REDIS_DISABLE_ADMINBAR` | Hide the admin bar menu item |
| `WP_REDIS_DISABLE_COMMENT` | Disable the HTML performance comment in the page source |
| `WP_REDIS_MANAGER_CAPABILITY` | Override the capability required to manage Redis |
| `WP_REDIS_SSL_CONTEXT` | SSL context options for TLS connections |
| `WP_REDIS_FLUSH_TIMEOUT` | Read timeout in seconds used when flushing the cache | `5` |

Example:

```php
define( 'WP_REDIS_HOST', '127.0.0.1' );
define( 'WP_REDIS_PORT', 6379 );
define( 'WP_REDIS_DATABASE', 0 );
define( 'WP_REDIS_PASSWORD', 'your-redis-password' );
define( 'WP_REDIS_CLIENT', 'phpredis' );
define( 'WP_REDIS_PREFIX', 'mysite' );
define( 'WP_REDIS_MAXTTL', 86400 );
define( 'WP_REDIS_GRACEFUL', true );
```

## WP-CLI

The plugin registers the `icc-gg-redis-object-cache-enabler` command:

```bash
wp icc-gg-redis-object-cache-enabler status
wp icc-gg-redis-object-cache-enabler enable
wp icc-gg-redis-object-cache-enabler disable
wp icc-gg-redis-object-cache-enabler update-dropin
```

To flush the cache from the command line, use the built-in `wp cache flush` command.

## Hooks & Filters

The plugin provides actions and filters for customization. See [`object-cache.php`](includes/object-cache.php:1) for the complete list including:

**Actions**

- `icc_gg_redis_object_cache_enabler_enable` — Fired after the object cache is enabled
- `icc_gg_redis_object_cache_enabler_disable` — Fired after the object cache is disabled
- `icc_gg_redis_object_cache_enabler_update_dropin` — Fired after the drop-in is updated
- `icc_gg_redis_object_cache_enabler_delete` — Fired when a key is deleted
- `icc_gg_redis_object_cache_enabler_get` — Fired when a key is retrieved
- `icc_gg_redis_object_cache_enabler_get_multiple` — Fired when multiple keys are retrieved
- `icc_gg_redis_object_cache_enabler_set` — Fired when a key is stored
- `icc_gg_redis_object_cache_enabler_flush` — Fired when the cache is flushed
- `icc_gg_redis_object_cache_enabler_flush_group` — Fired when a cache group is flushed
- `icc_gg_redis_object_cache_enabler_error` — Fired when an error occurs

**Filters**

- `icc_gg_redis_object_cache_enabler_expiration` — Modify the expiration of a cache key
- `icc_gg_redis_object_cache_enabler_get_value` — Modify a value before it is returned
- `icc_gg_redis_object_cache_enabler_add_non_persistent_groups` — Modify non-persistent groups
- `icc_gg_redis_object_cache_enabler_validate_dropin` — Modify the drop-in validation state
- `icc_gg_redis_object_cache_enabler_manager_capability` — Modify the capability required to manage Redis

## Troubleshooting

Answers to common questions and troubleshooting of common errors can be found in the upstream [Redis Object Cache FAQ](https://github.com/rhubarbgroup/redis-cache/blob/develop/FAQ.md).

¹ Redis is a registered trademark of Redis Ltd. Any rights therein are reserved to Redis Ltd. Any use by ICC.gg Redis Object Cache Enabler is for referential purposes only and does not indicate any sponsorship, endorsement or affiliation between Redis and ICC.gg Redis Object Cache Enabler.

## Credits

**ICC.gg Redis Object Cache Enabler** is maintained by [Ivan Carlos](https://github.com/ivancarlosti).

This plugin is a fork of [Redis Object Cache](https://github.com/rhubarbgroup/redis-cache).

<!-- footer -->
---

## 🧑‍💻 Consulting and technical support
* For personal support and queries, please submit a new issue to have it addressed.
* For commercial related questions, please [**contact me**][ivancarlos] for consulting costs.

[cc]: https://docs.github.com/en/communities/setting-up-your-project-for-healthy-contributions/adding-a-code-of-conduct-to-your-project
[contributing]: https://docs.github.com/en/articles/setting-guidelines-for-repository-contributors
[security]: https://docs.github.com/en/code-security/getting-started/adding-a-security-policy-to-your-repository
[support]: https://docs.github.com/en/articles/adding-support-resources-to-your-project
[it]: https://docs.github.com/en/communities/using-templates-to-encourage-useful-issues-and-pull-requests/configuring-issue-templates-for-your-repository#configuring-the-template-chooser
[prt]: https://docs.github.com/en/communities/using-templates-to-encourage-useful-issues-and-pull-requests/creating-a-pull-request-template-for-your-repository
[funding]: https://docs.github.com/en/articles/displaying-a-sponsor-button-in-your-repository
[ivancarlos]: https://ivancarlos.com.br
