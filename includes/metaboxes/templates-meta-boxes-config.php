<?php


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
