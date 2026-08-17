<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Diagnostics tab template.
 *
 * @package   ICC_GG_Redis_Object_Cache_Enabler
 * @category  General
 * @author    Ivan Carlos
 * @copyright 2007-2026 Ivan Carlos Consultoria
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 */

?>

<div class="card" id="icc-gg-redis-object-cache-enabler-diagnostics"><?php require __DIR__ . '/../../diagnostics.php'; ?></div>

<p id="icc-gg-redis-object-cache-enabler-copy-button">
	<span class="copy-button-wrapper">
		<button type="button" class="button copy-button" data-clipboard-target="#icc-gg-redis-object-cache-enabler-diagnostics">
			<?php esc_html_e( 'Copy diagnostics to clipboard', 'icc-gg-redis-object-cache-enabler' ); ?>
		</button>
		<span class="success hidden" aria-hidden="true"><?php esc_html_e( 'Copied!', 'icc-gg-redis-object-cache-enabler' ); ?></span>
	</span>
</p>
