<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Overview tab template.
 *
 * @package   ICC_GG_Redis_Object_Cache_Enabler
 * @category  General
 * @author    Ivan Carlos
 * @copyright 2007-2026 Ivan Carlos Consultoria
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 */

/** @var \ICC_GG_Redis_Object_Cache_Enabler_Plugin $roc */
$status = $roc->get_redis_status();
$redis_client = $roc->get_redis_client_name();
$redis_prefix = $roc->get_redis_prefix();
$redis_maxttl = $roc->get_redis_maxttl();
$redis_version = $roc->get_redis_version();
$redis_connection = $roc->check_redis_connection();
$filesystem_allowed = $roc->is_file_mod_allowed();
$filesystem_writable = $roc->test_filesystem_writing();

$diagnostics = $roc->get_diagnostics();

?>

<?php if ( is_string( $redis_connection ) ) : ?>
	<div class="notice notice-error">
		<p>
			<strong><?php esc_html_e( 'Redis is unreachable:', 'icc-gg-redis-object-cache-enabler' ); ?></strong>
			<?php echo esc_html( $redis_connection ); ?>
		</p>
	</div>
<?php endif; ?>

<table class="form-table" style="margin-top: 20px;">

	<tr>
		<th><?php esc_html_e( 'Status:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
		<td>
			<?php if ( $status ) : ?>
				<span class="success">
					<span class="dashicons dashicons-yes-alt"></span>
					<?php echo esc_html( $roc->get_status() ); ?>
				</span>
			<?php else : ?>
				<span class="warning">
					<span class="dashicons dashicons-warning"></span>
					<?php echo esc_html( $roc->get_status() ); ?>
				</span>
			<?php endif; ?>
		</td>
	</tr>

	<tr>
		<th><?php esc_html_e( 'Filesystem:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
		<td>
			<?php if ( $filesystem_writable instanceof \WP_Error ) : ?>
				<?php if ( ! $filesystem_allowed ) : ?>
					<span class="<?php echo $status ? '' : 'error' ?>">
						<span class="dashicons dashicons-dismiss"></span>
						<?php esc_html_e( 'Disabled', 'icc-gg-redis-object-cache-enabler' ); ?>
					</span>
				<?php else : ?>
					<span class="error">
						<span class="dashicons dashicons-dismiss"></span>
						<?php esc_html_e( 'Not writeable', 'icc-gg-redis-object-cache-enabler' ); ?>
					</span>
				<?php endif; ?>
			<?php else : ?>
				<span class="success">
					<span class="dashicons dashicons-yes-alt"></span>
					<?php esc_html_e( 'Writeable', 'icc-gg-redis-object-cache-enabler' ); ?>
				</span>
			<?php endif; ?>
		</td>
	</tr>

	<tr>
		<th><?php esc_html_e( 'Redis:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
		<td>
			<?php if ( $redis_connection === true ) : ?>
				<span class="success">
					<span class="dashicons dashicons-yes-alt"></span>
					<?php esc_html_e( 'Reachable', 'icc-gg-redis-object-cache-enabler' ); ?>
				</span>
			<?php else : ?>
				<span class="error">
					<span class="dashicons dashicons-dismiss"></span>
					<?php esc_html_e( 'Unreachable', 'icc-gg-redis-object-cache-enabler' ); ?>
				</span>
			<?php endif; ?>
		</td>
	</tr>

	<?php if ( ! is_null( $redis_prefix ) && trim( $redis_prefix ) !== '' ) : ?>
		<tr>
			<th><?php esc_html_e( 'Key Prefix:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<code><?php echo esc_html( $redis_prefix ); ?></code>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( ! is_null( $redis_maxttl ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Max. TTL:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<code><?php echo esc_html( $redis_maxttl ); ?></code>

				<?php if ( ! is_int( $redis_maxttl ) && ! ctype_digit( (string) $redis_maxttl ) ) : ?>
					<p class="description is-notice">
						<?php esc_html_e( 'This doesn’t appear to be a valid number.', 'icc-gg-redis-object-cache-enabler' ); ?>
					</p>
				<?php endif; ?>
			</td>
		</tr>
	<?php endif; ?>

</table>

<?php if ( $status ) : ?>

<h2 class="title">
	<?php esc_html_e( 'Connection', 'icc-gg-redis-object-cache-enabler' ); ?>
</h2>

<table class="form-table">

	<?php if ( ! is_null( $redis_client ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Client:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<code><?php echo esc_html( $redis_client ); ?></code>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( ! empty( $diagnostics['host'] ) || ! empty( $diagnostics['path'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Host:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td><code><?php echo esc_html( $diagnostics['host'] ?? $diagnostics['path'] ); ?></code></td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['cluster'] ) && is_array( $diagnostics['cluster'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Cluster:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<ul>
					<?php foreach ( $diagnostics['cluster'] as $node ) : ?>
						<li><code><?php echo esc_html( $node ); ?></code></li>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['shards'] ) && is_array( $diagnostics['shards'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Shards:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<ul>
					<?php foreach ( $diagnostics['shards'] as $node ) : ?>
						<li><code><?php echo esc_html( $node ); ?></code></li>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['servers'] ) && is_array( $diagnostics['servers'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Servers:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<ul>
					<?php foreach ( $diagnostics['servers'] as $node ) : ?>
						<li><code><?php echo esc_html( $roc->obscure_url_secrets( $node ) ); ?></code></li>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( ! empty( $diagnostics['port'] ) && $diagnostics['port'] > 0 ) : ?>
		<tr>
			<th><?php esc_html_e( 'Port:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td><code><?php echo esc_html( $diagnostics['port'] ); ?></code></td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['password'][0] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Username:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td><code><?php echo esc_html( $diagnostics['password'][0] ); ?></code></td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['password'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Password:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<code>••••••••</code>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['database'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Database:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td><code><?php echo esc_html( $diagnostics['database'] ); ?></code></td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['timeout'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Connection Timeout:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<code>
					<?php
						echo sprintf(
							// translators: %s = Redis connection/read timeout in seconds.
							esc_html__( '%ss', 'icc-gg-redis-object-cache-enabler' ),
							esc_html( $diagnostics['timeout'] )
						);
					?>
				</code>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['read_timeout'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Read Timeout:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<code>
					<?php
						echo sprintf(
							// translators: %s = Redis connection/read timeout in seconds.
							esc_html__( '%ss', 'icc-gg-redis-object-cache-enabler' ),
							esc_html( $diagnostics['read_timeout'] )
						);
					?>
				</code>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( isset( $diagnostics['retry_interval'] ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Retry Interval:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td>
				<code>
					<?php
						echo sprintf(
							// translators: %s = Redis retry interval in milliseconds.
							esc_html__( '%sms', 'icc-gg-redis-object-cache-enabler' ),
							esc_html( $diagnostics['retry_interval'] )
						);
					?>
				</code>
			</td>
		</tr>
	<?php endif; ?>

	<?php if ( ! is_null( $redis_version ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'Redis Version:', 'icc-gg-redis-object-cache-enabler' ); ?></th>
			<td><code><?php echo esc_html( $redis_version ) ?: esc_html_e( 'Unknown', 'icc-gg-redis-object-cache-enabler' ); ?></code></td>
		</tr>
	<?php endif; ?>

</table>

<?php endif; ?>

<p class="submit">

	<?php if ( $roc->get_redis_status() ) : ?>
		<a href="<?php echo esc_attr( $roc->action_link( 'flush-cache' ) ); ?>" class="button button-primary button-large">
			<?php esc_html_e( 'Flush Cache', 'icc-gg-redis-object-cache-enabler' ); ?>
		</a> &nbsp;
	<?php endif; ?>

	<?php if ( $roc->validate_object_cache_dropin() ) : ?>
		<?php if ( $filesystem_allowed ) : ?>
			<a href="<?php echo esc_attr( $roc->action_link( 'disable-cache' ) ); ?>" class="button button-secondary button-large">
				<?php esc_html_e( 'Disable Object Cache', 'icc-gg-redis-object-cache-enabler' ); ?>
			</a>
		<?php endif; ?>
	<?php else : ?>
		<?php if ( ! $filesystem_writable instanceof \WP_Error && $redis_connection === true ) : ?>
			<a href="<?php echo esc_attr( $roc->action_link( 'enable-cache' ) ); ?>" class="button button-primary button-large">
				<?php esc_html_e( 'Enable Object Cache', 'icc-gg-redis-object-cache-enabler' ); ?>
			</a>
		<?php else: ?>
			<a href="#!" class="button button-primary button-large" disabled>
				<?php esc_html_e( 'Enable Object Cache', 'icc-gg-redis-object-cache-enabler' ); ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>

</p>
