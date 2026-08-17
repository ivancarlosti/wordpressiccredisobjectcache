<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Admin settings page template.
 *
 * @package   ICC_GG_Redis_Object_Cache_Enabler
 * @category  General
 * @author    Ivan Carlos
 * @copyright 2007-2026 Ivan Carlos Consultoria
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 */
?>
<div id="icc-gg-redis-object-cache-enabler" class="wrap">

	<h1>
		<?php esc_html_e( 'ICC.gg Redis Object Cache Enabler', 'icc-gg-redis-object-cache-enabler' ); ?>
	</h1>

	<?php is_network_admin() && settings_errors(); ?>

	<div class="columns">

		<div class="content-column">

			<h2 class="nav-tab-wrapper">
				<?php foreach ( ICC_GG_Redis_Object_Cache_Enabler_UI::get_tabs() as $ui_tab ) : ?>
					<?php if ( $ui_tab->is_disabled() ) : ?>

						<span
							class="<?php echo esc_attr( $ui_tab->nav_classes() ); ?>"
							title="<?php echo esc_attr( $ui_tab->disabled_notice() ); ?>"
						>
							<?php echo esc_html( $ui_tab->label() ); ?>
						</span>

					<?php else : ?>

						<a
							id="<?php echo esc_attr( $ui_tab->nav_id() ); ?>"
							class="<?php echo esc_attr( $ui_tab->nav_classes() ); ?>"
							data-toggle="<?php echo esc_attr( $ui_tab->slug() ); ?>"
							href="#<?php echo esc_attr( $ui_tab->slug() ); ?>"
						>
							<?php echo esc_html( $ui_tab->label() ); ?>
						</a>

					<?php endif; ?>
				<?php endforeach; ?>
			</h2>

			<div class="tab-content">
				<?php foreach ( ICC_GG_Redis_Object_Cache_Enabler_UI::get_tabs() as $ui_tab ) : ?>
					<?php if ( ! $ui_tab->is_disabled() ) : ?>
						<div id="<?php echo esc_attr( $ui_tab->id() ); ?>"
							class="<?php echo esc_attr( $ui_tab->classes() ); ?>"
						>
							<?php $ui_tab->display(); ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>

		</div>

	</div>

	<hr style="margin-top: 30px;">
	<p style="text-align: center; color: #666; font-size: 12px;">
		<?php esc_html_e( 'ICC.gg Redis Object Cache Enabler - A persistent object cache backend powered by Redis. Supports Predis, PhpRedis, Relay, replication, sentinels, clustering and WP-CLI.', 'icc-gg-redis-object-cache-enabler' ); ?><br>
		<a href="https://github.com/ivancarlosti/wordpressiccredisobjectcache" target="_blank" rel="noopener noreferrer">
			github.com/ivancarlosti/wordpressiccredisobjectcache
		</a><br>
		<?php echo esc_html( sprintf( 'v%s', ICC_GG_REDIS_OBJECT_CACHE_ENABLER_VERSION ) ); ?>
		&mdash;
		<?php esc_html_e( 'Based on Redis Object Cache by rhubarbgroup', 'icc-gg-redis-object-cache-enabler' ); ?>
	</p>

</div>
