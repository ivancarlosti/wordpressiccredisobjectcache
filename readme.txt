=== ICC.gg Redis Object Cache Enabler ===
Contributors: ivancarlosti
Tags: redis, object cache, caching, performance, relay
Requires at least: 5.0
Tested up to: 7.0
Stable tag: 1.0.0
Requires PHP: 8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A persistent object cache backend powered by Redis®¹. Supports Predis, PhpRedis, Relay, replication, sentinels, clustering and WP-CLI.

== Description ==

A persistent object cache backend powered by Redis®¹. Supports [Predis](https://github.com/predis/predis/), [PhpRedis (PECL)](https://github.com/phpredis/phpredis), [Relay](https://relaycache.com), replication, sentinels, clustering and [WP-CLI](https://wp-cli.org/).

To adjust the connection parameters, prefix cache keys or configure replication/clustering, see the [configuration options](https://github.com/ivancarlosti/icc-gg-redis-object-cache-enabler#configuration).

This plugin is a fork of [Redis Object Cache](https://github.com/rhubarbgroup/redis-cache), with all functional free features preserved.

¹ Redis is a registered trademark of Redis Ltd. Any rights therein are reserved to Redis Ltd. Any use by ICC.gg Redis Object Cache Enabler is for referential purposes only and does not indicate any sponsorship, endorsement or affiliation between Redis and ICC.gg Redis Object Cache Enabler.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to **Settings > Redis** and click **Enable Object Cache**.

== Troubleshooting ==

Answers to common questions and troubleshooting of common errors can be found in the upstream [FAQ](https://github.com/rhubarbgroup/redis-cache/blob/develop/FAQ.md).

== Configuration ==

The plugin comes with a vast set of configuration options that can be defined in `wp-config.php`:

* `WP_REDIS_HOST`, `WP_REDIS_PORT`, `WP_REDIS_DATABASE`, `WP_REDIS_PASSWORD`, `WP_REDIS_USERNAME`
* `WP_REDIS_SCHEME`, `WP_REDIS_PATH`, `WP_REDIS_TIMEOUT`, `WP_REDIS_READ_TIMEOUT`, `WP_REDIS_RETRY_INTERVAL`
* `WP_REDIS_SERVERS`, `WP_REDIS_SHARDS`, `WP_REDIS_CLUSTER`, `WP_REDIS_SENTINEL`
* `WP_REDIS_PREFIX`, `WP_REDIS_SELECTIVE_FLUSH`, `WP_REDIS_MAXTTL`
* `WP_REDIS_GLOBAL_GROUPS`, `WP_REDIS_IGNORED_GROUPS`, `WP_REDIS_UNFLUSHABLE_GROUPS`
* `WP_REDIS_DISABLED`, `WP_REDIS_GRACEFUL`, `WP_REDIS_CLIENT`

== WP CLI commands ==

ICC.gg Redis Object Cache Enabler provides various WP CLI commands. For more information run `wp help icc-gg-redis-object-cache-enabler` after installing the plugin.

== Changelog ==

= 1.0.0 =
* Initial release, forked from Redis Object Cache.
* Removed commercial add-on promotions.
* Rebranded as ICC.gg Redis Object Cache Enabler.
