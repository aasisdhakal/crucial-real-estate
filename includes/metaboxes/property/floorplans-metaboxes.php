<?php

/**
 * Add floorplans metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function cre_floorplans_metabox_tab($property_metabox_tabs)
{
	if (is_array($property_metabox_tabs)) {
		$property_metabox_tabs['floor-plans'] = array(
			'label' => esc_html__('Floor Plans', 'crucial-real-estate'),
			'icon'  => 'dashicons-layout',
		);
	}

	return $property_metabox_tabs;
}

add_filter('cre_property_metabox_tabs', 'cre_floorplans_metabox_tab', 40);


/**
 * Add floorplans metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function cre_floorplans_metabox_fields($property_metabox_fields)
{

	$cre_floorplans_fields = array(
		array(
			'id'      => 'aarambha_floor_plans',
			'type'    => 'group',
			'columns' => 12,
			'clone'   => true,
			'tab'     => 'floor-plans',
			'fields'  => array(
				array(
					'name' => esc_html__('Floor Name', 'crucial-real-estate'),
					'id'   => 'aarambha_floor_plan_name',
					'desc' => esc_html__('Example: Ground Floor', 'crucial-real-estate'),
					'type' => 'text',
					'columns' => 6,
				),
				array(
					'name' => esc_html__('Description', 'crucial-real-estate'),
					'id'   => 'aarambha_floor_plan_descr',
					'type' => 'textarea',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__('Floor Price ( Only digits )', 'crucial-real-estate'),
					'id'      => 'aarambha_floor_plan_price',
					'desc'    => esc_html__('Example: 4000', 'crucial-real-estate'),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__('Price Postfix', 'crucial-real-estate'),
					'id'      => 'aarambha_floor_plan_price_postfix',
					'desc'    => esc_html__('Example: Per Month or Per Night', 'crucial-real-estate'),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__('Floor Size ( Only digits )', 'crucial-real-estate'),
					'id'      => 'aarambha_floor_plan_size',
					'desc'    => esc_html__('Example: 2500', 'crucial-real-estate'),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__('Size Postfix', 'crucial-real-estate'),
					'id'      => 'aarambha_floor_plan_size_postfix',
					'desc'    => esc_html__('Example: sq ft', 'crucial-real-estate'),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__('Bedrooms', 'crucial-real-estate'),
					'id'      => 'aarambha_floor_plan_bedrooms',
					'desc'    => esc_html__('Example: 4', 'crucial-real-estate'),
					'type'    => 'text',
					'columns' => 6,
				),
				array(
					'name'    => esc_html__('Bathrooms', 'crucial-real-estate'),
					'id'      => 'aarambha_floor_plan_bathrooms',
					'desc'    => esc_html__('Example: 2', 'crucial-real-estate'),
					'type'    => 'text',
					'columns' => 6,
				),

				array(
					'name'             => esc_html__('Floor Plan Image', 'crucial-real-estate'),
					'id'               => 'aarambha_floor_plan_image',
					'desc'             => esc_html__('The recommended minimum width is 770px and height is flexible.', 'crucial-real-estate'),
					'type'             => 'file_input',
					'max_file_uploads' => 1,
					'columns' => 12,
				),
			),
		),
	);

	return array_merge($property_metabox_fields, $cre_floorplans_fields);
}

add_filter('cre_property_metabox_fields', 'cre_floorplans_metabox_fields', 40);
