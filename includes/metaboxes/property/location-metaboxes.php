<?php

/**
 * Add Location metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function cre_location_metabox_tab($property_metabox_tabs)
{
	if (is_array($property_metabox_tabs)) {
		$property_metabox_tabs['map-location'] = array(
			'label' => esc_html__('Location on Map', 'crucial-real-estate'),
			'icon'  => 'dashicons-location',
		);
	}

	return $property_metabox_tabs;
}
add_filter('cre_property_metabox_tabs', 'cre_location_metabox_tab', 20);


/**
 * Add Location metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function cre_location_metabox_fields($property_metabox_fields)
{

	$cre_location_fields = array(
		array(
			'id'            => "cre_property_location",
			'name'          => esc_html__('Property Location on Map', 'crucial-real-estate'),
			'desc'          => esc_html__('Drag the map marker to point property location. Address field given above can be used to search location.', 'crucial-real-estate'),
			'type'          => 'osm',
			'api_key'       => false,
			'std'           => get_option('theme_submit_default_location', '25.7308309,-80.44414899999998'),
			'zoom'          => 14,
			'style'         => 'width: 95%; height: 400px',
			'address_field' => "cre_property_address",
			'columns'       => 12,
			'tab'           => 'map-location',
		),
		array(
			'id'      => "cre_property_address",
			'name'    => esc_html__('Property Address', 'crucial-real-estate'),
			'desc'    => esc_html__('Leaving it empty will hide the map on property detail page.', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => get_option('theme_submit_default_address'),
			'columns' => 12,
			'tab'     => 'map-location',
		),
		array(
			'name'    => esc_html__('Hide map on property detail page ?', 'crucial-real-estate'),
			'id'      => "cre_property_map",
			'type'    => 'radio',
			'std'     => '0',
			'options' => array(
				'1' => esc_html__('Yes', 'crucial-real-estate'),
				'0' => esc_html__('No', 'crucial-real-estate'),
			),
			'columns' => 12,
			'tab'     => 'map-location',
		),
		array(
			'id'      => "cre_property_country",
			'name'    => esc_html__('Country', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => get_option('theme_submit_default_address'),
			'columns' => 12,
			'tab'     => 'map-location',
		),
		array(
			'id'      => "cre_property_state",
			'name'    => esc_html__('State', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => get_option('theme_submit_default_address'),
			'columns' => 12,
			'tab'     => 'map-location',
		),
		array(
			'id'      => 'cre_property_area',
			'name'    => esc_html__( 'Area', 'crucial-real-estate' ),
			'type'    => 'text',
			'columns' => 12,
			'tab'     => 'map-location',
		),
		array(
			'id'      => "cre_property_city",
			'name'    => esc_html__('City', 'crucial-real-estate'),
			'type'    => 'text',
			'columns' => 12,
			'tab'     => 'map-location',
		),
		array(
			'id'      => "cre_property_zip",
			'name'    => esc_html__('Zip', 'crucial-real-estate'),
			'type'    => 'text',
			'columns' => 12,
			'tab'     => 'map-location',
		),
		
	);

	return array_merge($property_metabox_fields, $cre_location_fields);
}
add_filter('cre_property_metabox_fields', 'cre_location_metabox_fields', 20);
