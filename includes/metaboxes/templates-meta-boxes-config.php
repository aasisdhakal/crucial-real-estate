<?php
if (!function_exists('cre_properties_filter_meta_boxes')) :
	/**
	 * Contains properties filter meta boxes declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function cre_properties_filter_meta_boxes($meta_boxes)
	{

		$locations = array();
		cre_get_terms_array('property-city', $locations);

		$types = array();
		cre_get_terms_array('property-type', $types);

		$statuses = array();
		cre_get_terms_array('property-status', $statuses);

		$features = array();
		cre_get_terms_array('property-feature', $features);

		// removed first element and got the whole remaining array with preserved keys as we do not need 'None' in agents list.
		$agents_for_pages = array_slice(cre_get_agents_array(), 1, null, true);

		$meta_boxes[] = array(
			'id'         => 'properties-list-meta-box',
			'title'      => esc_html__('Properties Filter Settings', 'crucial-real-estate'),
			'post_types' => array('page'),
			'context'    => 'normal',
			'priority'   => 'high',
			'show'       => array(
				'template' => array(
					'templates/list-layout.php',
					'templates/list-layout-full-width.php',
					'templates/grid-layout.php',
					'templates/grid-layout-full-width.php',
					'templates/half-map-layout.php',
				),
			),
			'fields'     => array(
				array(
					'id'      => 'aarambha_posts_per_page',
					'name'    => esc_html__('Number of Properties Per Page', 'crucial-real-estate'),
					'type'    => 'number',
					'step'    => '1',
					'min'     => 1,
					'std'     => 6,
					'columns' => 6,
				),
				array(
					'id'       => 'aarambha_properties_order',
					'name'     => esc_html__('Order Properties By', 'crucial-real-estate'),
					'type'     => 'select',
					'options'  => array(
						'default'    => esc_html__('Global Default', 'crucial-real-estate'),
						'date-desc'  => esc_html__('Date New to Old', 'crucial-real-estate'),
						'date-asc'   => esc_html__('Date Old to New', 'crucial-real-estate'),
						'price-asc'  => esc_html__('Price Low to High', 'crucial-real-estate'),
						'price-desc' => esc_html__('Price High to Low', 'crucial-real-estate'),
					),
					'multiple' => false,
					'std'      => 'default',
					'columns'  => 6,
				),
				array(
					'id'              => 'aarambha_properties_locations',
					'name'            => esc_html__('Locations', 'crucial-real-estate'),
					'type'            => 'select',
					'options'         => $locations,
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'              => 'aarambha_properties_statuses',
					'name'            => esc_html__('Statuses', 'crucial-real-estate'),
					'type'            => 'select',
					'options'         => $statuses,
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'              => 'aarambha_properties_types',
					'name'            => esc_html__('Types', 'crucial-real-estate'),
					'type'            => 'select',
					'options'         => $types,
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'              => 'aarambha_properties_features',
					'name'            => esc_html__('Features', 'crucial-real-estate'),
					'type'            => 'select',
					'options'         => $features,
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'      => 'aarambha_properties_min_beds',
					'name'    => esc_html__('Minimum Beds', 'crucial-real-estate'),
					'type'    => 'number',
					'step'    => 'any',
					'min'     => 0,
					'std'     => 0,
					'columns' => 6,
				),
				array(
					'id'      => 'aarambha_properties_min_baths',
					'name'    => esc_html__('Minimum Baths', 'crucial-real-estate'),
					'type'    => 'number',
					'step'    => 'any',
					'min'     => 0,
					'std'     => 0,
					'columns' => 6,
				),
				array(
					'id'      => 'aarambha_properties_min_price',
					'name'    => esc_html__('Minimum Price', 'crucial-real-estate'),
					'type'    => 'number',
					'step'    => 'any',
					'min'     => 0,
					'std'     => 0,
					'columns' => 6,
				),
				array(
					'id'      => 'aarambha_properties_max_price',
					'name'    => esc_html__('Maximum Price', 'crucial-real-estate'),
					'type'    => 'number',
					'step'    => 'any',
					'min'     => 0,
					'std'     => 0,
					'columns' => 6,
				),
				array(
					'name'            => esc_html__('Properties by Agents', 'crucial-real-estate'),
					'id'              => 'aarambha_properties_by_agents',
					'type'            => 'select',
					'options'         => $agents_for_pages,
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'        => 'aarambha_featured_properties_only',
					'name'      => esc_html__('Display Only Featured Properties', 'crucial-real-estate'),
					'type'      => 'switch',
					'style'     => 'square',
					'on_label'  => esc_html__('Yes', 'framework'),
					'off_label' => esc_html__('No', 'framework'),
					'std'       => 0,
					'columns'   => 6,
				),
			),
		);

		return $meta_boxes;
	}

	add_filter('rwmb_meta_boxes', 'cre_properties_filter_meta_boxes');

endif;


if (!function_exists('cre_gallery_properties_filter_meta_boxes')) :
	/**
	 * Contains partner's meta box declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function cre_gallery_properties_filter_meta_boxes($meta_boxes)
	{

		$locations = array();
		cre_get_terms_array('property-city', $locations);

		$types = array();
		cre_get_terms_array('property-type', $types);

		$statuses = array();
		cre_get_terms_array('property-status', $statuses);

		$features = array();
		cre_get_terms_array('property-feature', $features);

		$meta_boxes[] = array(
			'id'         => 'properties-gallery-meta-box',
			'title'      => esc_html__('Properties Gallery Filter Settings', 'crucial-real-estate'),
			'post_types' => array('page'),
			'context'    => 'normal',
			'priority'   => 'high',
			'show'       => array(
				'template' => array(
					'templates/2-columns-gallery.php',
					'templates/3-columns-gallery.php',
					'templates/4-columns-gallery.php',
				),
			),
			'fields'     => array(
				array(
					'id'   => 'aarambha_gallery_posts_per_page',
					'name' => esc_html__('Number of Properties Per Page', 'crucial-real-estate'),
					'type' => 'number',
					'step' => '1',
					'min'  => 1,
					'std'  => 6,
					'columns' => 12,
				),
				array(
					'id'              => 'aarambha_gallery_properties_locations',
					'name'            => esc_html__('Locations', 'crucial-real-estate'),
					'type'            => 'select',
					'options'         => $locations,
					'multiple'        => true,
					'select_all_none' => true,
					'columns' => 6,
				),
				array(
					'id'              => 'aarambha_gallery_properties_statuses',
					'name'            => esc_html__('Statuses', 'crucial-real-estate'),
					'type'            => 'select',
					'options'         => $statuses,
					'multiple'        => true,
					'select_all_none' => true,
					'columns' => 6,
				),
				array(
					'id'              => 'aarambha_gallery_properties_types',
					'name'            => esc_html__('Types', 'crucial-real-estate'),
					'type'            => 'select',
					'options'         => $types,
					'multiple'        => true,
					'select_all_none' => true,
					'columns' => 6,
				),
				array(
					'id'              => 'aarambha_gallery_properties_features',
					'name'            => esc_html__('Features', 'crucial-real-estate'),
					'type'            => 'select',
					'options'         => $features,
					'multiple'        => true,
					'select_all_none' => true,
					'columns' => 6,
				),
			),
		);

		return $meta_boxes;
	}

	add_filter('rwmb_meta_boxes', 'cre_gallery_properties_filter_meta_boxes');

endif;
