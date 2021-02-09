<?php
if (!function_exists('cre_property_type_meta_boxes')) :
	/**
	 * Property type meta boxes declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function cre_property_type_meta_boxes($meta_boxes)
	{

		$meta_boxes[] = array(
			'title'      => esc_html__('Custom Property Type Map Icon', 'crucial-real-estate'),
			'taxonomies' => 'property-type',
			'fields'     => array(
				array(
					'name'             => esc_html__('Icon Image', 'crucial-real-estate'),
					'id'               => 'aarambha_property_type_icon',
					'type'             => 'image_advanced',
					'mime_type'        => 'image/png',
					'max_file_uploads' => 1,
				),
				array(
					'name'             => esc_html__('Retina Icon Image', 'crucial-real-estate'),
					'id'               => 'aarambha_property_type_icon_retina',
					'type'             => 'image_advanced',
					'mime_type'        => 'image/png',
					'max_file_uploads' => 1,
				),
			),
		);

		return $meta_boxes;
	}

	add_filter('rwmb_meta_boxes', 'cre_property_type_meta_boxes');

endif;

if (!function_exists('cre_property_location_meta_boxes')) :
	/**
	 * Property feature meta boxes declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function cre_property_location_meta_boxes($meta_boxes)
	{

		$meta_boxes[] = array(
			'title'      => 'Property Location Image',
			'taxonomies' => 'property-city',
			'fields'     => array(
				array(
					'name'             => esc_html__('Featured Image', 'crucial-real-estate'),
					'id'               => 'aarambha_property_location_image',
					'type'             => 'image_advanced',
					'mime_type'        => 'image/png',
					'max_file_uploads' => 1,
				),
			),
		);

		return $meta_boxes;
	}

	add_filter('rwmb_meta_boxes', 'cre_property_location_meta_boxes');

endif;

if (!function_exists('cre_property_feature_meta_boxes')) :
	/**
	 * Property feature meta boxes declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function cre_property_feature_meta_boxes($meta_boxes)
	{

		$meta_boxes[] = array(
			'title'      => 'Property Feature Icon',
			'taxonomies' => 'property-feature',
			'fields'     => array(
				array(
					'name'             => esc_html__('Icon Image', 'crucial-real-estate'),
					'desc'             => esc_html__('Recommended image size for icon is 64px by 64px.', 'crucial-real-estate'),
					'id'               => 'aarambha_property_feature_icon',
					'type'             => 'image_advanced',
					'mime_type'        => 'image/png',
					'max_file_uploads' => 1,
				),
			),
		);

		return $meta_boxes;
	}

	add_filter('rwmb_meta_boxes', 'cre_property_feature_meta_boxes');

endif;
