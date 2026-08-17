<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * WP-CLI commands class.
 *
 * @package   ICC_GG_Redis_Object_Cache_Enabler
 * @category  General
 * @author    Ivan Carlos
 * @copyright 2007-2026 Ivan Carlos Consultoria
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 */

/**
 * Enables, disabled and checks the status of the object cache.
 * To flush call `wp cache flush`.
 *
 * @package wp-cli
 */
class ICC_GG_Redis_Object_Cache_Enabler_CLI_Commands extends WP_CLI_Command
{
	/**
	 * Show the Redis object cache status and (when possible) client.
	 *
	 * ## EXAMPLES
	 *
	 *     wp icc-gg-redis-object-cache-enabler status
	 */
	public function status()
	{
		$roc = ICC_GG_Redis_Object_Cache_Enabler_Plugin::instance();

		require_once __DIR__ . '/diagnostics.php';
	}

	/**
	 * Enables the Redis object cache.
	 *
	 * Default behavior is to create the object cache drop-in,
	 * unless an unknown object cache drop-in is present.
	 *
	 * ## EXAMPLES
	 *
	 *     wp icc-gg-redis-object-cache-enabler enable
	 */
	public function enable()
	{
		global $wp_filesystem;

		$plugin = ICC_GG_Redis_Object_Cache_Enabler_Plugin::instance();

		if ( $plugin->object_cache_dropin_exists() ) {

			if ( $plugin->validate_object_cache_dropin() ) {
				WP_CLI::line( __( 'Redis object cache already enabled.', 'icc-gg-redis-object-cache-enabler' ) );
			} else {
				WP_CLI::error( __( 'A foreign object cache drop-in was found. To use Redis for object caching, run: `wp icc-gg-redis-object-cache-enabler update-dropin`.', 'icc-gg-redis-object-cache-enabler' ) );
			}
		} else {
			$flush = $this->flush_redis();

			if ( is_string( $flush ) ) {
				// translators: %s = The Redis connection error message.
				WP_CLI::error( sprintf( __( "Object cache could not be enabled. Redis server is unreachable: %s", 'icc-gg-redis-object-cache-enabler' ), $flush ) );
			}

			WP_Filesystem();

			$copy = $wp_filesystem->copy(
				ICC_GG_REDIS_OBJECT_CACHE_ENABLER_PLUGIN_PATH . '/includes/object-cache.php',
				WP_CONTENT_DIR . '/object-cache.php',
				true,
				FS_CHMOD_FILE
			);

			/**
			 * Fires on cache enable event
			 *
			 * @since 1.3.5
			 * @param bool $result Whether the filesystem event (copy of the `object-cache.php` file) was successful.
			 */
			do_action( 'icc_gg_redis_object_cache_enabler_enable', $copy );

			if ( $copy ) {
				WP_CLI::success( __( 'Object cache enabled.', 'icc-gg-redis-object-cache-enabler' ) );
			} else {
				WP_CLI::error( __( 'Object cache could not be enabled.', 'icc-gg-redis-object-cache-enabler' ) );
			}
		}

	}

	/**
	 * Disables the Redis object cache.
	 *
	 * Default behavior is to delete the object cache drop-in,
	 * unless an unknown object cache drop-in is present.
	 *
	 * ## EXAMPLES
	 *
	 *     wp icc-gg-redis-object-cache-enabler disable
	 */
	public function disable()
	{
		global $wp_filesystem;

		$plugin = ICC_GG_Redis_Object_Cache_Enabler_Plugin::instance();

		if ( ! $plugin->object_cache_dropin_exists() ) {

			WP_CLI::error( __( 'No object cache drop-in found.', 'icc-gg-redis-object-cache-enabler' ) );

		} else {

			if ( ! $plugin->validate_object_cache_dropin() ) {

				WP_CLI::error( __( 'A foreign object cache drop-in was found. To use Redis for object caching, run: `wp icc-gg-redis-object-cache-enabler update-dropin`.', 'icc-gg-redis-object-cache-enabler' ) );

			} else {

				WP_Filesystem();

				$result = $wp_filesystem->delete( WP_CONTENT_DIR . '/object-cache.php' );

				/**
				 * Fires on cache disable event
				 *
				 * @param bool $result Whether the deletion of the `object-cache.php` drop-in was successful.
				 * @since 1.3.5
				 */
				do_action( 'icc_gg_redis_object_cache_enabler_disable', $result );

				if ( $result ) {
					$this->flush_redis();

					WP_CLI::success( __( 'Object cache disabled.', 'icc-gg-redis-object-cache-enabler' ) );
				} else {
					WP_CLI::error( __( 'Object cache could not be disabled.', 'icc-gg-redis-object-cache-enabler' ) );
				}
			}
		}

	}

	/**
	 * Updates the Redis object cache drop-in.
	 *
	 * Default behavior is to overwrite any existing object cache drop-in.
	 *
	 * ## EXAMPLES
	 *
	 *     wp icc-gg-redis-object-cache-enabler update-dropin
	 *
	 * @subcommand update-dropin
	 */
	public function update_dropin()
	{
		global $wp_filesystem;

		WP_Filesystem();

		$copy = $wp_filesystem->copy(
			ICC_GG_REDIS_OBJECT_CACHE_ENABLER_PLUGIN_PATH . '/includes/object-cache.php',
			WP_CONTENT_DIR . '/object-cache.php',
			true,
			FS_CHMOD_FILE
		);

		/**
		 * Fires on cache update-dropin event
		 *
		 * @param bool $result Whether the `object-cache.php` drop-in was updated successful.
		 * @since 1.3.5
		 */
		do_action( 'icc_gg_redis_object_cache_enabler_update_dropin', $copy );

		if ( $copy ) {
			$flush = $this->flush_redis();

			if ( is_string( $flush ) ) {
				// translators: %s = The Redis connection error message.
				WP_CLI::error( sprintf( __( "Object cache drop-in could not be updated. Redis server is unreachable: %s", 'icc-gg-redis-object-cache-enabler' ), $flush ) );
			}

			WP_CLI::success( __( 'Updated object cache drop-in and enabled Redis object cache.', 'icc-gg-redis-object-cache-enabler' ) );
		} else {
			WP_CLI::error( __( 'Object cache drop-in could not be updated.', 'icc-gg-redis-object-cache-enabler' ) );
		}

	}

	/**
	 * Flush the Redis cache via Predis.
	 *
	 * @return bool|string
	 */
	protected function flush_redis()
	{
		try {
			return (new ICC_GG_Redis_Object_Cache_Enabler_Predis)->flushOrFail();
		} catch ( Exception $exception ) {
			error_log( $exception ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log

			return $exception->getMessage();
		}
	}
}
