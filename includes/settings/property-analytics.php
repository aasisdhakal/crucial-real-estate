<?php

/**
 * Settings page for the Property Analytics tab.
 *
 * @package Crucial Real Estate
 * @subpackage Property Analytics
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

$aarambha_property_analytics_status      = $this->get_option('aarambha_property_analytics_status', 'disabled');
$aarambha_property_analytics_chart_type  = $this->get_option('aarambha_property_analytics_chart_type', 'line');
$aarambha_property_analytics_time_period = $this->get_option('aarambha_property_analytics_time_period', 14);

if (isset($_POST['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'aarambha_cre_settings')) {
	update_option('aarambha_property_analytics_status', $aarambha_property_analytics_status);
	update_option('aarambha_property_analytics_chart_type', $aarambha_property_analytics_chart_type);
	update_option('aarambha_property_analytics_time_period', $aarambha_property_analytics_time_period);
	$this->notice();
}
?>
<div class="aarambha-cre-page-content">
	<form method="post" action="" novalidate="novalidate">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e('Collect Property Analytics Data', 'crucial-real-estate'); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span><?php esc_html_e('Enabling this option will allow the system to collect each property view from its datail page.', 'crucial-real-estate'); ?></span>
							</legend>
							<label>
								<input type="radio" name="aarambha_property_analytics_status" value="enabled" <?php checked($aarambha_property_analytics_status, 'enabled'); ?>>
								<span><?php esc_html_e('Enable', 'crucial-real-estate'); ?></span>
							</label>
							<br>
							<label>
								<input type="radio" name="aarambha_property_analytics_status" value="disabled" <?php checked($aarambha_property_analytics_status, 'disabled'); ?>>
								<span><?php esc_html_e('Disable', 'crucial-real-estate'); ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Chart Type', 'crucial-real-estate'); ?></th>
					<td>
						<fieldset>
							<label>
								<input type="radio" name="aarambha_property_analytics_chart_type" value="line" <?php checked($aarambha_property_analytics_chart_type, 'line'); ?>>
								<span><?php esc_html_e('Line', 'crucial-real-estate'); ?></span>
							</label>
							<br>
							<label>
								<input type="radio" name="aarambha_property_analytics_chart_type" value="bar" <?php checked($aarambha_property_analytics_chart_type, 'bar'); ?>>
								<span><?php esc_html_e('Bar', 'crucial-real-estate'); ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Display Property Views Of Last', 'crucial-real-estate'); ?></th>
					<td>
						<fieldset>
							<?php
							$time_period = get_option('aarambha_property_analytics_time_period', 14);
							?>
							<select name="aarambha_property_analytics_time_period" id="aarambha_property_analytics_time_period">
								<option value="7" <?php selected($time_period, 7); ?>>1 Week</option>
								<option value="14" <?php selected($time_period, 14); ?>>2 Weeks</option>
								<option value="30" <?php selected($time_period, 30); ?>>1 Month</option>
							</select>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="submit">
			<?php wp_nonce_field('aarambha_cre_settings'); ?>
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'crucial-real-estate'); ?>">
		</div>
	</form>
</div>