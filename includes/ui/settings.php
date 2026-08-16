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
 * @copyright 2023-2026 Ivan Carlos
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

		<div class="sidebar-column">

			<h6>
				<?php esc_html_e( 'About', 'icc-gg-redis-object-cache-enabler' ); ?>
			</h6>

			<div class="card">
				<p>
					<?php esc_html_e( 'A persistent object cache backend powered by Redis. Supports Predis, PhpRedis, Relay, replication, sentinels, clustering and WP-CLI.', 'icc-gg-redis-object-cache-enabler' ); ?>
				</p>
				<p>
					<?php
					echo wp_kses_post(
						sprintf(
							/* translators: %1$s is the upstream plugin link, %2$s is the original author. */
							__( 'Based on %1$s by %2$s.', 'icc-gg-redis-object-cache-enabler' ),
							'<a href="https://github.com/rhubarbgroup/redis-cache" target="_blank" rel="noopener">Redis Object Cache</a>',
							'Till Krüss'
						)
					);
					?>
				</p>
			</div>

		</div>

	</div>

</div>
