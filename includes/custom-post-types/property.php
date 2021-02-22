<?php

/**
 * Property Custom Post Type
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('cre_register_property_post_type')) {

	/**
	 * Register Property CPT
	 */
	function cre_register_property_post_type()
	{

		if (post_type_exists('property')) {
			return;
		}

		$property_post_type_labels = array(
			'name'               => esc_html__('Properties', 'crucial-real-estate'),
			'singular_name'      => esc_html__('Property', 'crucial-real-estate'),
			'add_new'            => esc_html__('Add New', 'crucial-real-estate'),
			'add_new_item'       => esc_html__('Add New Property', 'crucial-real-estate'),
			'edit_item'          => esc_html__('Edit Property', 'crucial-real-estate'),
			'new_item'           => esc_html__('New Property', 'crucial-real-estate'),
			'view_item'          => esc_html__('View Property', 'crucial-real-estate'),
			'search_items'       => esc_html__('Search Property', 'crucial-real-estate'),
			'not_found'          => esc_html__('No Property found', 'crucial-real-estate'),
			'not_found_in_trash' => esc_html__('No Property found in Trash', 'crucial-real-estate'),
			'parent_item_colon'  => esc_html__('Parent Property', 'crucial-real-estate'),
		);

		$property_post_type_args = array(
			'labels'             => apply_filters('aarambha_property_post_type_labels', $property_post_type_labels),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'crucial-real-estate',
			'query_var'          => true,
			'has_archive'        => true,
			'capability_type'    => 'post',
			'hierarchical'       => true,
			'menu_icon'          => 'dashicons-building',
			'menu_position'      => 5,
			'supports'           => array(
				'title',
				'editor',
				'thumbnail',
				'revisions',
				'author',
				'page-attributes',
				'excerpt',
				'comments'
			),
			'rewrite'            => array(
				'slug' => apply_filters('aarambha_property_slug', __('property', 'crucial-real-estate')),
			),
			'show_in_rest'       => true,
			'rest_base'          => apply_filters('aarambha_property_rest_base', 'properties'),
		);

		$property_post_type_args = apply_filters('aarambha_property_post_type_args', $property_post_type_args);
		register_post_type('property', $property_post_type_args);
	}

	add_action('init', 'cre_register_property_post_type');
}


if (!function_exists('cre_set_property_slug')) :
	/**
	 * This function set property's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property slug.
	 *
	 * @return string
	 */
	function cre_set_property_slug($existing_slug)
	{
		$new_slug = get_option('aarambha_property_slug');
		if (!empty($new_slug)) {
			return $new_slug;
		}

		return $existing_slug;
	}

	add_filter('aarambha_property_slug', 'cre_set_property_slug');
endif;


if (!function_exists('cre_register_property_taxonomies')) {
	/**
	 * Register Property related custom taxonomies
	 */
	function cre_register_property_taxonomies()
	{
		cre_register_property_feature_taxonomy();
		cre_register_property_type_taxonomy();
		cre_register_property_city_taxonomy();
	}

	add_action('init', 'cre_register_property_taxonomies', 0);
}


if (!function_exists('cre_register_property_feature_taxonomy')) :
	function cre_register_property_feature_taxonomy()
	{
		if (taxonomy_exists('property-feature')) {
			return;
		}

		$feature_labels = array(
			'name'                       => esc_html__('Property Features', 'crucial-real-estate'),
			'singular_name'              => esc_html__('Property Feature', 'crucial-real-estate'),
			'search_items'               => esc_html__('Search Property Features', 'crucial-real-estate'),
			'popular_items'              => esc_html__('Popular Property Features', 'crucial-real-estate'),
			'all_items'                  => esc_html__('All Property Features', 'crucial-real-estate'),
			'parent_item'                => esc_html__('Parent Property Feature', 'crucial-real-estate'),
			'parent_item_colon'          => esc_html__('Parent Property Feature:', 'crucial-real-estate'),
			'edit_item'                  => esc_html__('Edit Property Feature', 'crucial-real-estate'),
			'update_item'                => esc_html__('Update Property Feature', 'crucial-real-estate'),
			'add_new_item'               => esc_html__('Add New Property Feature', 'crucial-real-estate'),
			'new_item_name'              => esc_html__('New Property Feature Name', 'crucial-real-estate'),
			'separate_items_with_commas' => esc_html__('Separate Property Features with commas', 'crucial-real-estate'),
			'add_or_remove_items'        => esc_html__('Add or remove Property Features', 'crucial-real-estate'),
			'choose_from_most_used'      => esc_html__('Choose from the most used Property Features', 'crucial-real-estate'),
			'menu_name'                  => esc_html__('Property Features', 'crucial-real-estate'),
		);

		register_taxonomy(
			'property-feature',
			array('property'),
			array(
				'hierarchical' => true,
				'labels'       => apply_filters('aarambha_property_feature_labels', $feature_labels),
				'show_ui'      => true,
				'show_in_menu' => 'crucial-real-estate',
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => apply_filters('aarambha_property_feature_slug', __('property-feature', 'crucial-real-estate')),
				),
				'show_in_rest' => true,
				'rest_base'    => apply_filters('aarambha_property_feature_rest_base', __('property-features', 'crucial-real-estate'))
			)
		);
	}
endif;


if (!function_exists('cre_register_property_type_taxonomy')) :
	function cre_register_property_type_taxonomy()
	{
		if (taxonomy_exists('property-type')) {
			return;
		}

		$type_labels = array(
			'name'                       => esc_html__('Property Types', 'crucial-real-estate'),
			'singular_name'              => esc_html__('Property Type', 'crucial-real-estate'),
			'search_items'               => esc_html__('Search Property Types', 'crucial-real-estate'),
			'popular_items'              => esc_html__('Popular Property Types', 'crucial-real-estate'),
			'all_items'                  => esc_html__('All Property Types', 'crucial-real-estate'),
			'parent_item'                => esc_html__('Parent Property Type', 'crucial-real-estate'),
			'parent_item_colon'          => esc_html__('Parent Property Type:', 'crucial-real-estate'),
			'edit_item'                  => esc_html__('Edit Property Type', 'crucial-real-estate'),
			'update_item'                => esc_html__('Update Property Type', 'crucial-real-estate'),
			'add_new_item'               => esc_html__('Add New Property Type', 'crucial-real-estate'),
			'new_item_name'              => esc_html__('New Property Type Name', 'crucial-real-estate'),
			'separate_items_with_commas' => esc_html__('Separate Property Types with commas', 'crucial-real-estate'),
			'add_or_remove_items'        => esc_html__('Add or remove Property Types', 'crucial-real-estate'),
			'choose_from_most_used'      => esc_html__('Choose from the most used Property Types', 'crucial-real-estate'),
			'menu_name'                  => esc_html__('Property Types', 'crucial-real-estate'),
		);

		register_taxonomy(
			'property-type',
			array('property'),
			array(
				'hierarchical' => true,
				'labels'       => apply_filters('aarambha_property_type_labels', $type_labels),
				'show_ui'      => true,
				'show_in_menu' => 'crucial-real-estate',
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => apply_filters('aarambha_property_type_slug', __('property-type', 'crucial-real-estate')),
				),
				'show_in_rest' => true,
				'rest_base'    => apply_filters('aarambha_property_type_rest_base', __('property-types', 'crucial-real-estate'))
			)
		);
	}
endif;


if (!function_exists('cre_register_property_city_taxonomy')) :
	function cre_register_property_city_taxonomy()
	{
		if (taxonomy_exists('property-city')) {
			return;
		}

		$city_labels = array(
			'name'                       => esc_html__('Property Locations', 'crucial-real-estate'),
			'singular_name'              => esc_html__('Property Location', 'crucial-real-estate'),
			'search_items'               => esc_html__('Search Property Locations', 'crucial-real-estate'),
			'popular_items'              => esc_html__('Popular Property Locations', 'crucial-real-estate'),
			'all_items'                  => esc_html__('All Property Locations', 'crucial-real-estate'),
			'parent_item'                => esc_html__('Parent Property Location', 'crucial-real-estate'),
			'parent_item_colon'          => esc_html__('Parent Property Location:', 'crucial-real-estate'),
			'edit_item'                  => esc_html__('Edit Property Location', 'crucial-real-estate'),
			'update_item'                => esc_html__('Update Property Location', 'crucial-real-estate'),
			'add_new_item'               => esc_html__('Add New Property Location', 'crucial-real-estate'),
			'new_item_name'              => esc_html__('New Property Location Name', 'crucial-real-estate'),
			'separate_items_with_commas' => esc_html__('Separate Property Locations with commas', 'crucial-real-estate'),
			'add_or_remove_items'        => esc_html__('Add or remove Property Locations', 'crucial-real-estate'),
			'choose_from_most_used'      => esc_html__('Choose from the most used Property Locations', 'crucial-real-estate'),
			'menu_name'                  => esc_html__('Property Locations', 'crucial-real-estate'),
		);

		register_taxonomy(
			'property-city',
			array('property'),
			array(
				'hierarchical' => true,
				'labels'       => apply_filters('aarambha_property_city_labels', $city_labels),
				'show_ui'      => true,
				'show_in_menu' => 'crucial-real-estate',
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => apply_filters('aarambha_property_city_slug', __('property-city', 'crucial-real-estate')),
				),
				'show_in_rest' => true,
				'rest_base'    => apply_filters('aarambha_property_city_rest_base', __('property-cities', 'crucial-real-estate'))
			)
		);
	}
endif;



if (!function_exists('cre_set_property_city_slug')) :
	/**
	 * This function set property location's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property location slug.
	 *
	 * @return string
	 */
	function cre_set_property_city_slug($existing_slug)
	{
		$new_slug = get_option('aarambha_property_city_slug');
		if (!empty($new_slug)) {
			return $new_slug;
		}

		return $existing_slug;
	}

	add_filter('aarambha_property_city_slug', 'cre_set_property_city_slug');
	add_filter('aarambha_property_city_rest_base', 'cre_set_property_city_slug');
endif;


if (!function_exists('cre_set_property_type_slug')) :
	/**
	 * This function set property type's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property type slug.
	 *
	 * @return string
	 */
	function cre_set_property_type_slug($existing_slug)
	{
		$new_slug = get_option('aarambha_property_type_slug');
		if (!empty($new_slug)) {
			return $new_slug;
		}

		return $existing_slug;
	}

	add_filter('aarambha_property_type_slug', 'cre_set_property_type_slug');
	add_filter('aarambha_property_type_rest_base', 'cre_set_property_type_slug');
endif;


if (!function_exists('cre_set_property_feature_slug')) :
	/**
	 * This function set property feature's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing property feature slug.
	 *
	 * @return string
	 */
	function cre_set_property_feature_slug($existing_slug)
	{
		$new_slug = get_option('aarambha_property_feature_slug');
		if (!empty($new_slug)) {
			return $new_slug;
		}

		return $existing_slug;
	}

	add_filter('aarambha_property_feature_slug', 'cre_set_property_feature_slug');
	add_filter('aarambha_property_feature_rest_base', 'cre_set_property_feature_slug');
endif;


if (!function_exists('cre_property_edit_columns')) {
	/**
	 * Custom columns for properties
	 *
	 * @param array $columns - Columns array.
	 *
	 * @return array
	 */
	function cre_property_edit_columns($columns)
	{

		$columns = array(
			'cb'                 => '<input type="checkbox" />',
			'title'              => esc_html__('Property Title', 'crucial-real-estate'),
			'property-thumbnail' => esc_html__('Thumbnail', 'crucial-real-estate'),
			'city'               => esc_html__('Location', 'crucial-real-estate'),
			'type'               => esc_html__('Type', 'crucial-real-estate'),
			'price'              => esc_html__('Price', 'crucial-real-estate'),
			'id'                 => esc_html__('Property ID', 'crucial-real-estate'),
			'date'               => esc_html__('Publish Time', 'crucial-real-estate'),
		);

		// WPML Support
		if (defined('ICL_SITEPRESS_VERSION')) {
			global $sitepress;
			$wpml_columns = new WPML_Custom_Columns($sitepress);
			$columns      = $wpml_columns->add_posts_management_column($columns);
		}

		// Reverse the array for RTL
		if (is_rtl()) {
			$columns = array_reverse($columns);
		}

		return $columns;
	}

	add_filter('manage_edit-property_columns', 'cre_property_edit_columns');
}


if (!function_exists('cre_property_custom_columns')) {
	/**
	 * Property custom columns
	 *
	 * @param $column
	 */
	function cre_property_custom_columns($column)
	{
		global $post;
		switch ($column) {
			case 'property-thumbnail':
				if (has_post_thumbnail($post->ID)) {
?>
					<a href="<?php the_permalink(); ?>" target="_blank">
						<?php the_post_thumbnail(array(130, 130)); ?>
					</a>
		<?php
				} else {
					_e('No Thumbnail', 'crucial-real-estate');
				}
				break;
			case 'id':
				$Prop_id = get_post_meta($post->ID, 'cre_property_id', true);
				if (!empty($Prop_id)) {
					echo esc_html($Prop_id);
				} else {
					_e('NA', 'crucial-real-estate');
				}
				break;
			
			case 'city':
				echo cre_admin_taxonomy_terms($post->ID, 'property-city', 'property');
				break;
			case 'address':
				$address = get_post_meta($post->ID, 'cre_property_address', true);
				if (!empty($address)) {
					echo esc_html($address);
				} else {
					_e('No Address Provided!', 'crucial-real-estate');
				}
				break;
			case 'type':
				echo cre_admin_taxonomy_terms($post->ID, 'property-type', 'property');
				break;
			
			case 'price':
				cre_property_price();
				break;
			case 'bed':
				$bed = get_post_meta($post->ID, 'cre_property_bedrooms', true);
				if (!empty($bed)) {
					echo esc_html($bed);
				} else {
					_e('NA', 'crucial-real-estate');
				}
				break;
			case 'bath':
				$bath = get_post_meta($post->ID, 'cre_property_bathrooms', true);
				if (!empty($bath)) {
					echo esc_html($bath);
				} else {
					_e('NA', 'crucial-real-estate');
				}
				break;
			case 'garage':
				$garage = get_post_meta($post->ID, 'cre_property_garage', true);
				if (!empty($garage)) {
					echo esc_html($garage);
				} else {
					_e('NA', 'crucial-real-estate');
				}
				break;
			case 'features':
				echo get_the_term_list($post->ID, 'property-feature', '', ', ', '');
				break;
		}
	}
	add_action('manage_pages_custom_column', 'cre_property_custom_columns');
}


if (!function_exists('cre_add_payment_meta_box')) {
	/**
	 * Add Metabox to Display Property Payment Information
	 */
	function cre_add_payment_meta_box()
	{
		if ((function_exists('rpp_is_enabled') && rpp_is_enabled()) || (function_exists('isp_is_enabled') && isp_is_enabled())) {
			add_meta_box('payment-meta-box', esc_html__('Payment Information', 'crucial-real-estate'), 'cre_payment_meta_box', 'property', 'normal', 'default');
		}
	}
	add_action('add_meta_boxes', 'cre_add_payment_meta_box');
}


if (!function_exists('cre_payment_meta_box')) {
	/**
	 * Payment meta box
	 *
	 * @param $post
	 */
	function cre_payment_meta_box($post)
	{

		$values        = get_post_custom($post->ID);
		$not_available = esc_html__('Not Available', 'crucial-real-estate');

		$txn_id           = isset($values['txn_id']) ? esc_attr($values['txn_id'][0]) : $not_available;
		$payment_date     = isset($values['payment_date']) ? esc_attr($values['payment_date'][0]) : $not_available;
		$payer_email      = isset($values['payer_email']) ? esc_attr($values['payer_email'][0]) : $not_available;
		$first_name       = isset($values['first_name']) ? esc_attr($values['first_name'][0]) : $not_available;
		$last_name        = isset($values['last_name']) ? esc_attr($values['last_name'][0]) : $not_available;
		$payment_status   = isset($values['payment_status']) ? esc_attr($values['payment_status'][0]) : $not_available;
		$payment_gross    = isset($values['payment_gross']) ? esc_attr($values['payment_gross'][0]) : $not_available;
		$payment_currency = isset($values['mc_currency']) ? esc_attr($values['mc_currency'][0]) : $not_available;

		?>
		<table style="width:100%;">
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e('Transaction ID', 'crucial-real-estate'); ?></strong>
				</td>
				<td style="width:75%;"><?php echo esc_html($txn_id); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e('Payment Date', 'crucial-real-estate'); ?></strong>
				</td>
				<td style="width:75%;"><?php echo esc_html($payment_date); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e('First Name', 'crucial-real-estate'); ?></strong>
				</td>
				<td style="width:75%;"><?php echo esc_html($first_name); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e('Last Name', 'crucial-real-estate'); ?></strong>
				</td>
				<td style="width:75%;"><?php echo esc_html($last_name); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e('Payer Email', 'crucial-real-estate'); ?></strong>
				</td>
				<td style="width:75%;"><?php echo esc_html($payer_email); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e('Payment Status', 'crucial-real-estate'); ?></strong>
				</td>
				<td style="width:75%;"><?php echo esc_html($payment_status); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e('Payment Amount', 'crucial-real-estate'); ?></strong>
				</td>
				<td style="width:75%;"><?php echo esc_html($payment_gross); ?></td>
			</tr>
			<tr>
				<td style="width:25%; vertical-align: top;">
					<strong><?php esc_html_e('Payment Currency', 'crucial-real-estate'); ?></strong>
				</td>
				<td style="width:75%;"><?php echo esc_html($payment_currency); ?></td>
			</tr>
		</table>
		<?php
	}
}


if (!function_exists('cre_admin_taxonomy_terms')) {

	/**
	 * Comma separated taxonomy terms with admin side links.
	 *
	 * @param  int $post_id      - Post ID.
	 * @param  string $taxonomy  - Taxonomy name.
	 * @param  string $post_type - Post type.
	 *
	 * @return string|bool
	 * @since  1.0.0
	 */
	function cre_admin_taxonomy_terms($post_id, $taxonomy, $post_type)
	{

		$terms = get_the_terms($post_id, $taxonomy);

		if (!empty($terms)) {
			$out = array();
			/* Loop through each term, linking to the 'edit posts' page for the specific term. */
			foreach ($terms as $term) {
				$out[] = sprintf(
					'<a href="%s">%s</a>',
					esc_url(
						add_query_arg(
							array(
								'post_type' => $post_type,
								$taxonomy   => $term->slug,
							),
							'edit.php'
						)
					),
					esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'display'))
				);
			}

			/* Join the terms, separating them with a comma. */

			return join(', ', $out);
		}

		return false;
	}
}

if (!function_exists('cre_properties_filter_fields_admin')) {
	/**
	 * Add custom filter fields for properties on admin
	 */
	function cre_properties_filter_fields_admin()
	{

		global $post_type;
		if ($post_type == 'property') {

			// Property Location Dropdown Option
			$prop_city_args = array(
				'show_option_all' => esc_html__('All Property Locations', 'crucial-real-estate'),
				'orderby'         => 'NAME',
				'order'           => 'ASC',
				'name'            => 'property_city_admin_filter',
				'taxonomy'        => 'property-city'
			);
			if (isset($_GET['property_city_admin_filter'])) {
				$prop_city_args['selected'] = sanitize_text_field($_GET['property_city_admin_filter']);
			}
			wp_dropdown_categories($prop_city_args);

			// Property Type Dropdown Option
			$prop_type_args = array(
				'show_option_all' => esc_html__('All Property Types', 'crucial-real-estate'),
				'orderby'         => 'NAME',
				'order'           => 'ASC',
				'name'            => 'property_type_admin_filter',
				'taxonomy'        => 'property-type'
			);
			if (isset($_GET['property_type_admin_filter'])) {
				$prop_type_args['selected'] = sanitize_text_field($_GET['property_type_admin_filter']);
			}
			wp_dropdown_categories($prop_type_args);

			// User Dropdown Option
			$user_args = array(
				'show_option_all'  => esc_html__('All Users', 'crucial-real-estate'),
				'orderby'          => 'display_name',
				'order'            => 'ASC',
				'name'             => 'author_admin_filter',
				'who'              => 'authors',
				'include_selected' => true
			);
			if (isset($_GET['author_admin_filter'])) {
				$user_args['selected'] = (int) sanitize_text_field($_GET['author_admin_filter']);
			}
			wp_dropdown_users($user_args);

			// Property ID Input Option
			$value_escaped = '';
			if (isset($_GET['prop_id_admin_filter']) && !empty($_GET['prop_id_admin_filter'])) {
				$value_escaped = esc_attr($_GET['prop_id_admin_filter']);
			}
		?>
			<input id="prop_id_admin_filter" type="text" name="prop_id_admin_filter" placeholder="<?php esc_html_e('Property ID', 'crucial-real-estate'); ?>" value="<?php echo $value_escaped; ?>">
<?php
		}
	}

	add_action('restrict_manage_posts', 'cre_properties_filter_fields_admin');
}

if (!function_exists('cre_properties_filter_admin')) {
	/**
	 * Restrict the properties by the chosen filters
	 *
	 * @param $query
	 */
	function cre_properties_filter_admin($query)
	{

		global $post_type, $pagenow;

		//if we are currently on the edit screen of the property post-type listings
		if ($pagenow == 'edit.php' && $post_type == 'property') {

			$tax_query  = array();
			$meta_query = array();

			// Property ID Filter
			if (isset($_GET['prop_id_admin_filter']) && !empty($_GET['prop_id_admin_filter'])) {

				$meta_query[] = array(
					'key'     => 'cre_property_id',
					'value'   => sanitize_text_field($_GET['prop_id_admin_filter']),
					'compare' => 'LIKE',
				);
			}

			// Property Type Filter
			if (isset($_GET['property_type_admin_filter']) && !empty($_GET['property_type_admin_filter'])) {

				//get the desired property type
				$property_type = sanitize_text_field($_GET['property_type_admin_filter']);

				//if the property type is not 0 (which means all)
				if ($property_type != 0) {

					$tax_query[] = array(
						'taxonomy' => 'property-type',
						'field'    => 'ID',
						'terms'    => array($property_type)
					);
				}
			}

			// Property Location Filter
			if (isset($_GET['property_city_admin_filter']) && !empty($_GET['property_city_admin_filter'])) {

				//get the desired property location
				$property_city = sanitize_text_field($_GET['property_city_admin_filter']);

				//if the property location is not 0 (which means all)
				if ($property_city != 0) {
					$tax_query[] = array(
						'taxonomy' => 'property-city',
						'field'    => 'ID',
						'terms'    => array($property_city)
					);
				}
			}

			// Property Author Filter
			if (isset($_GET['author_admin_filter']) && !empty($_GET['author_admin_filter'])) {

				//set the query variable for 'author' to the desired value
				$author_id = sanitize_text_field($_GET['author_admin_filter']);

				//if the author is not 0 (meaning all)
				if ($author_id != 0) {
					$query->query_vars['author'] = $author_id;
				}
			}

			if (!empty($meta_query)) {
				$query->query_vars['meta_query'] = $meta_query;
			}

			if (!empty($tax_query)) {
				$query->query_vars['tax_query'] = $tax_query;
			}
		}
	}

	add_action('pre_get_posts', 'cre_properties_filter_admin');
}

if (!function_exists('cre_sortable_price_column')) {
	/**
	 * Make property price column sortable
	 *
	 * @param $columns
	 *
	 * @return mixed
	 */
	function cre_sortable_price_column($columns)
	{
		$columns['price'] = 'price';

		return $columns;
	}

	add_filter('manage_edit-property_sortable_columns', 'cre_sortable_price_column');
}

if (!function_exists('cre_price_orderby')) {
	/**
	 * Sort properties based on price
	 *
	 * @param $query
	 */
	function cre_price_orderby($query)
	{
		global $post_type, $pagenow;

		//if we are currently on the edit screen of the property post-type listings
		if ($pagenow == 'edit.php' && $post_type == 'property') {
			$orderby = $query->get('orderby');
			if ('price' == $orderby) {
				$query->set('meta_key', 'cre_property_price');
				$query->set('orderby', 'meta_value_num');
			}
		}
	}

	add_action('pre_get_posts', 'cre_price_orderby');
}
