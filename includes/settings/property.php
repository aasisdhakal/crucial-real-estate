<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

$aarambha_auto_property_id_check   = $this->get_option('aarambha_auto_property_id_check', 'true');
$aarambha_auto_property_id_pattern = $this->get_option('aarambha_auto_property_id_pattern', 'CRE-{ID}-property');
$aarambha_property_energy_classes  = $this->get_option('aarambha_property_energy_classes');

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'aarambha_cre_settings')) {
	update_option('aarambha_auto_property_id_check', $aarambha_auto_property_id_check);
	update_option('aarambha_auto_property_id_pattern', $aarambha_auto_property_id_pattern);

	// Handling property energy classes data.
	if (isset($_POST['aarambha_property_energy_classes']) && !empty($_POST['aarambha_property_energy_classes'])) {

		foreach ($_POST['aarambha_property_energy_classes'] as $energy_class => $values) {
			if (empty($values['name']) || empty($values['color'])) {
				unset($_POST['aarambha_property_energy_classes'][$energy_class]);
			}
		}

		$aarambha_property_energy_classes = array_values($_POST['aarambha_property_energy_classes']);
		if (is_array($aarambha_property_energy_classes)) {
			update_option('aarambha_property_energy_classes', $aarambha_property_energy_classes);
		}
	} else {
		$aarambha_property_energy_classes = '';
		delete_option('aarambha_property_energy_classes');
	}

	$this->notice();
}
?>
<div class="aarambha-cre-page-content">
	<form method="post" action="" novalidate="novalidate">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e('Enable Auto-Generated Property ID', 'crucial-real-estate'); ?></th>
					<td>
						<fieldset>
							<label>
								<input type="radio" name="aarambha_auto_property_id_check" value="true" <?php checked($aarambha_auto_property_id_check, 'true') ?>>
								<span><?php esc_html_e('Enable', 'crucial-real-estate'); ?></span>
							</label>
							<br>
							<label>
								<input type="radio" name="aarambha_auto_property_id_check" value="false" <?php checked($aarambha_auto_property_id_check, 'false') ?>>
								<span><?php esc_html_e('Disable', 'crucial-real-estate'); ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="aarambha_auto_property_id_pattern"><?php esc_html_e('Auto-Generated Property ID Pattern', 'crucial-real-estate') ?></label>
					</th>
					<td>
						<input name="aarambha_auto_property_id_pattern" type="text" id="aarambha_auto_property_id_pattern" value="<?php echo esc_attr($aarambha_auto_property_id_pattern); ?>" class="regular-text code">
						<p class="description">
							<strong><?php esc_html_e('Important: ', 'crucial-real-estate') ?></strong><?php esc_html_e('Please use {ID} in your pattern as it will be replaced by the Property ID.', 'crucial-real-estate'); ?>
						</p>
					</td>
				</tr>
			</tbody>
		</table>

		<hr>
		<!-- Energy Performance Classes Settings -->
		<div class="energy-classes-settings">
			<h2><?php esc_html_e('Energy Perofrmance Certificate Classes', 'crucial-real-estate'); ?></h2>
			<table class="form-table">
				<tbody>
					<tr>
						<th><?php esc_html_e('Class Name', 'crucial-real-estate'); ?></th>
						<th><?php esc_html_e('Class Color', 'crucial-real-estate'); ?></th>
						<th></th>
						<th></th>
					</tr>
				</tbody>
				<tbody class="epc-classes-sortable">
					<?php

					if (empty($aarambha_property_energy_classes)) {
						$energy_classes = cre_epc_default_fields();
					} else {
						$energy_classes = $aarambha_property_energy_classes;
					}

					foreach ($energy_classes as $index => $energy_class) {
					?>
						<tr class="epc-class draggable">
							<td>
								<a class="reorder-epc-class" draggable="true"></a>
								<input type="text" class="class-name" name="aarambha_property_energy_classes[<?php echo $index; ?>][name]" value="<?php echo esc_attr($energy_class['name']); ?>">
							</td>
							<td>
								<input type="text" class="class-color" name="aarambha_property_energy_classes[<?php echo $index; ?>][color]" value="<?php echo esc_attr($energy_class['color']); ?>">
								<a class="remove-epc-class" href="#"><span class="dashicons dashicons-dismiss"></span></a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<div class="add-epc-class-wrap">
				<a href="#" class="button button-primary add-epc-class">+ Add more</a>
			</div>
		</div>
		<div class="submit">
			<?php wp_nonce_field('aarambha_cre_settings'); ?>
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'crucial-real-estate'); ?>">
		</div>
	</form>
</div>