<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Metrics tab template.
 *
 * @package   ICC_GG_Redis_Object_Cache_Enabler
 * @category  General
 * @author    Ivan Carlos
 * @copyright 2007-2026 Ivan Carlos Consultoria
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 */

?>

<div id="widget-redis-stats" class="card">

	<ul>
		<li>
			<a href="#" class="active" data-chart="time" title="<?php esc_attr_e( 'The total amount of time (in milliseconds) it took Redis to return cache data.', 'icc-gg-redis-object-cache-enabler' ); ?>">
				<?php esc_html_e( 'Time', 'icc-gg-redis-object-cache-enabler' ); ?>
			</a>
		</li>
		<li>
			<a href="#" data-chart="bytes" title="<?php esc_attr_e( 'The total amount of bytes that was retrieved from Redis.', 'icc-gg-redis-object-cache-enabler' ); ?>">
				<?php esc_html_e( 'Bytes', 'icc-gg-redis-object-cache-enabler' ); ?>
			</a>
		</li>
		<li>
			<a href="#" data-chart="ratio" title="<?php esc_attr_e( 'The hit/miss ratio of cache data that was already cached.', 'icc-gg-redis-object-cache-enabler' ); ?>">
				<?php esc_html_e( 'Ratio', 'icc-gg-redis-object-cache-enabler' ); ?>
			</a>
		</li>
		<li>
			<a href="#" data-chart="calls" title="<?php esc_attr_e( 'The total amount of commands sent to Redis.', 'icc-gg-redis-object-cache-enabler' ); ?>">
				<?php esc_html_e( 'Calls', 'icc-gg-redis-object-cache-enabler' ); ?>
			</a>
		</li>
	</ul>

	<div id="redis-stats-chart"></div>

</div>
