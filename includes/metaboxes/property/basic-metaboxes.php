<?php

/**
 * Add basic metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function cre_basic_metabox_tab($property_metabox_tabs)
{
	if (is_array($property_metabox_tabs)) {
		$property_metabox_tabs['details'] = array(
			'label' => esc_html__('Basic Information', 'crucial-real-estate'),
			'icon'  => 'dashicons-admin-home',
		);
	}
	return $property_metabox_tabs;
}
add_filter('cre_property_metabox_tabs', 'cre_basic_metabox_tab', 10);


/**
 * Add basic metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function cre_basic_metabox_fields($property_metabox_fields)
{


	/*
	 * Migration code related to additional details improvements in version 3.11.2
	 */
	$post_id = false;
	if (isset($_GET['post'])) {
		$post_id = intval($_GET['post']);
	} elseif (isset($_POST['post_ID'])) {
		$post_id = intval($_POST['post_ID']);
	}

	if ($post_id && $post_id > 0) {
		cre_additional_details_migration($post_id); // Migrate property additional details from old metabox key to new key.
	}



	$cre_basic_fields = array(
		array(
			'id'      => "cre_property_price",
			'name'    => esc_html__('Sale or Rent Price ( Only digits )', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: 12500', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'      => 'cre_property_price_prefix',
			'name'    => esc_html__('Price Prefix', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: From', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'      => "cre_property_price_postfix",
			'name'    => esc_html__('Price Postfix', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: Monthly or Per Night', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'type'    => 'divider',
			'columns' => 12,
			'id'      => 'price_divider',
			'tab'     => 'details',
		),
		array(
			'id'      => "cre_property_size",
			'name'    => esc_html__('Area Size ( Only digits )', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: 2500', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'      => "cre_property_size_postfix",
			'name'    => esc_html__('Area Size Postfix', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: sq ft', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'      => "cre_property_lot_size",
			'name'    => esc_html__('Lot Size ( Only digits )', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: 3000', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'      => "cre_property_lot_size_postfix",
			'name'    => esc_html__('Lot Size Postfix', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: sq ft', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'      => "cre_property_bedrooms",
			'name'    => esc_html__('Bedrooms', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: 4', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'      => "cre_property_bathrooms",
			'name'    => esc_html__('Bathrooms', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: 2', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'      => "cre_property_garage",
			'name'    => esc_html__('Garages or Parking Spaces', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: 1', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),
		array(
			'id'         => "cre_property_id",
			'name'       => esc_html__('Property ID', 'crucial-real-estate'),
			'desc'       => esc_html__('It will help you search a property directly.', 'crucial-real-estate'),
			'type'       => 'text',
			'std'        => ('true' === get_option('aarambha_auto_property_id_check')) ? get_option('aarambha_auto_property_id_pattern') : '',
			'columns'    => 12,
			'tab'        => 'details',
			'attributes' => array(
				'readonly' => ('true' === get_option('aarambha_auto_property_id_check')) ? true : false,
			),
		),
		array(
			'id'      => "cre_property_year_built",
			'name'    => esc_html__('Year Built', 'crucial-real-estate'),
			'desc'    => esc_html__('Example: 2017', 'crucial-real-estate'),
			'type'    => 'text',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'details',
		),

	);

	return array_merge($property_metabox_fields, $cre_basic_fields);
}
add_filter('cre_property_metabox_fields', 'cre_basic_metabox_fields', 10);
