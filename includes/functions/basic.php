<?php

/**
 * Contains Basic Functions for Crucial Real Estate plugin.
 */

/**
 * Get template part for ERE plugin.
 *
 * @access public
 *
 * @param mixed $slug Template slug.
 * @param string $name Template name (default: '').
 */
function cre_get_template_part($slug, $name = '')
{
	$template = '';

	// Get slug-name.php.
	if (!$template && $name && file_exists(CRE_PLUGIN_DIR . "/{$slug}-{$name}.php")) {
		$template = CRE_PLUGIN_DIR . "/{$slug}-{$name}.php";
	}

	// Get slug.php.
	if (!$template && file_exists(CRE_PLUGIN_DIR . "/{$slug}.php")) {
		$template = CRE_PLUGIN_DIR . "/{$slug}.php";
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters('cre_get_template_part', $template, $slug, $name);

	if ($template) {
		load_template($template, false);
	}
}

if (!function_exists('cre_exclude_CPT_meta_keys_from_rest_api')) {

	add_filter('cre_property_rest_api_meta', 'cre_exclude_CPT_meta_keys_from_rest_api');
	add_filter('cre_agency_rest_api_meta', 'cre_exclude_CPT_meta_keys_from_rest_api');
	add_filter('cre_agent_rest_api_meta', 'cre_exclude_CPT_meta_keys_from_rest_api');

	function cre_exclude_CPT_meta_keys_from_rest_api($post_meta)
	{

		$exclude_keys = array(
			//'_thumbnail_id',
			'_vc_post_settings',
			'_dp_original',
			'_edit_lock',
			'_wp_old_slug',
			'slide_template',
			'cre_banner_sub_title',
		);

		// excluding keys
		foreach ($exclude_keys as $key) {
			if (key_exists($key, $post_meta)) {
				unset($post_meta[$key]);
			}
		}

		// return the post meta
		return $post_meta;
	}
}

if (!function_exists('cre_get_current_user_ip')) {
	/**
	 * Return current user IP
	 *
	 * @return string|string[]|null
	 */
	function cre_get_current_user_ip()
	{
		return preg_replace('/[^0-9a-fA-F:., ]/', '', $_SERVER['REMOTE_ADDR']);
	}
}

if (!function_exists('cre_generate_posts_list')) {
	/**
	 * Generates options list for given post arguments
	 *
	 * @param $post_args
	 * @param int $selected
	 */
	function cre_generate_posts_list($post_args, $selected = 0)
	{

		$defaults = array('posts_per_page' => -1, 'suppress_filters' => true);

		if (is_array($post_args)) {
			$post_args = wp_parse_args($post_args, $defaults);
		} else {
			$post_args = wp_parse_args(array('post_type' => $post_args), $defaults);
		}

		$posts = get_posts($post_args);

		if (isset($selected) && is_array($selected)) {
			foreach ($posts as $post) :
?><option value="<?php echo esc_attr($post->ID); ?>" <?php if (in_array($post->ID, $selected)) {
															echo "selected";
														} ?>><?php echo esc_html($post->post_title); ?></option><?php
													endforeach;
												} else {
													foreach ($posts as $post) :
														?><option value="<?php echo esc_attr($post->ID); ?>" <?php if (isset($selected) && ($selected == $post->ID)) {
															echo "selected";
														} ?>><?php echo esc_html($post->post_title); ?></option><?php
													endforeach;
												}
											}
										}

										if (!function_exists('cre_display_property_label')) {
											/**
											 * Display property label
											 *
											 * @param $post_id
											 */
											function cre_display_property_label($post_id)
											{

												$label_text = get_post_meta($post_id, 'aarambha_property_label', true);
												$color      = get_post_meta($post_id, 'aarambha_property_label_color', true);
												if (!empty($label_text)) {
														?>
			<span <?php if (!empty($color)) { ?>style="background: <?php echo esc_attr($color); ?>" <?php } ?> class='property-label'><?php echo esc_html($label_text); ?></span>
<?php

												}
											}
										}

										if (!function_exists('cre_include_compare_icon')) {
											/**
											 * Include compare icon
											 */
											function cre_include_compare_icon()
											{

												if (defined('INSPIRY_THEME_DIR')) {
													include(INSPIRY_THEME_DIR . '/images/icons/icon-compare.svg');
												} else {
													include(CRE_PLUGIN_DIR . '/images/icons/icon-compare.svg');
												}
											}
										}

										if (!function_exists('cre_framework_excerpt')) {
											/**
											 * Output custom excerpt of required length
											 *
											 * @param int $len number of words
											 * @param string $trim string to appear after excerpt
											 */
											function cre_framework_excerpt($len = 15, $trim = "&hellip;")
											{
												echo cre_get_framework_excerpt($len, $trim);
											}
										}

										if (!function_exists('cre_get_framework_excerpt')) {
											/**
											 * Returns custom excerpt of required length
											 *
											 * @param int $len number of words
											 * @param string $trim string after excerpt
											 *
											 * @return array|string
											 */
											function cre_get_framework_excerpt($len = 15, $trim = "&hellip;")
											{
												$limit     = $len + 1;
												$excerpt   = explode(' ', get_the_excerpt(), $limit);
												$num_words = count($excerpt);
												if ($num_words >= $len) {
													array_pop($excerpt);
												} else {
													$trim = "";
												}
												$excerpt = implode(" ", $excerpt) . "$trim";

												return $excerpt;
											}
										}
										
										if (is_admin() && !function_exists('aarambha_remove_revolution_slider_meta_boxes')) {
											/**
											 * Remove Rev Slider Metabox
											 */
											function aarambha_remove_revolution_slider_meta_boxes()
											{

												$post_types = apply_filters(
													'aarambha_remove_revolution_slider_meta_boxes',
													array(
														'page',
														'post',
														'property',
														'agency',
														'agent',
														'partners',
														'slide',
													)
												);

												remove_meta_box('mymetabox_revslider_0', $post_types, 'normal');
											}

											add_action('do_meta_boxes', 'aarambha_remove_revolution_slider_meta_boxes');
										}


										if (!function_exists('cre_epc_default_fields')) {
											/**
											 * Return Enenergy Performance Certificate default fields.
											 */
											function cre_epc_default_fields()
											{

												return apply_filters(
													'cre_epc_default_fields',
													array(
														array(
															'name'  => 'A+',
															'color' => '#00845a',
														),
														array(
															'name'  => 'A',
															'color' => '#18b058',
														),
														array(
															'name'  => 'B',
															'color' => '#8dc643',
														),
														array(
															'name'  => 'C',
															'color' => '#ffcc01',
														),
														array(
															'name'  => 'D',
															'color' => '#f6ac63',
														),
														array(
															'name'  => 'E',
															'color' => '#f78622',
														),
														array(
															'name'  => 'F',
															'color' => '#ef1d3a',
														),
														array(
															'name'  => 'G',
															'color' => '#d10400',
														),
													)
												);
											}
										}
