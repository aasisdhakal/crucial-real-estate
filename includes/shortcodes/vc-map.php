<?php

/**
 * @package Crucial Real Estate
 * @subpackage shortcodes
 * This file contains code related to properties shortcode integration with visual composer.
 */


/**
 * Integrates properties shortcode with Visual Composer
 */
if (!function_exists('cre_shortcodes_integration')) {

	function cre_shortcodes_integration()
	{
		/*
		 * Locations
		 */
		$property_cities_array = array();
		$property_cities       = get_terms(array('taxonomy' => 'property-city'));
		if (!empty($property_cities) && !is_wp_error($property_cities)) {
			foreach ($property_cities as $property_city) {
				$property_cities_array[$property_city->name] = $property_city->slug;
			}
		}

		/*
		 * Statuses
		 */
		$property_statuses_array = array();
		$property_statuses       = get_terms(array('taxonomy' => 'property-status'));
		if (!empty($property_statuses) && !is_wp_error($property_statuses)) {
			foreach ($property_statuses as $property_status) {
				$property_statuses_array[$property_status->name] = $property_status->slug;
			}
		}

		/*
		 * Types
		 */
		$property_types_array = array();
		$property_types       = get_terms(array('taxonomy' => 'property-type'));
		if (!empty($property_types) && !is_wp_error($property_types)) {
			foreach ($property_types as $property_type) {
				$property_types_array[$property_type->name] = $property_type->slug;
			}
		}

		/*
		 * Features
		 */
		$property_features_array = array();
		$property_features       = get_terms(array('taxonomy' => 'property-feature'));
		if (!empty($property_features) && !is_wp_error($property_features)) {
			foreach ($property_features as $property_feature) {
				$property_features_array[$property_feature->name] = $property_feature->slug;
			}
		}

		/*
		 * Agents
		 */
		$agents_array = array();
		$agents_posts = get_posts(
			array(
				'post_type'        => 'agent',
				'posts_per_page'   => -1,
				'suppress_filters' => 0,
			)
		);
		if (count($agents_posts) > 0) {
			foreach ($agents_posts as $agent_post) {
				$agents_array[$agent_post->post_title] = $agent_post->ID;
			}
		}

		vc_map(array(
			'name'        => esc_html__('Properties', 'crucial-real-estate'),
			'description' => esc_html__('List of Properties', 'crucial-real-estate'),
			'base'        => 'properties',
			'category'    => esc_html__('Crucial Real Estate Theme', 'crucial-real-estate'),
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Layout', 'crucial-real-estate'),
					'param_name'  => 'layout',
					'value'       => array(
						'Grid' => 'grid',
						'List' => 'list',
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Number of Properties', 'crucial-real-estate'),
					'param_name'  => 'count',
					'value'       => array(
						__('All', 'crucial-real-estate') => -1,
						'1'                      => 1,
						'2'                      => 2,
						'3'                      => 3,
						'4'                      => 4,
						'5'                      => 5,
						'6'                      => 6,
						'7'                      => 7,
						'8'                      => 8,
						'9'                      => 9,
						'10'                     => 10,
						'11'                     => 11,
						'12'                     => 12,
						'13'                     => 13,
						'14'                     => 14,
						'15'                     => 15,
						'16'                     => 16,
					),
					'admin_label' => true,
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Order By', 'crucial-real-estate'),
					'param_name' => 'orderby',
					'value'      => array(
						__('Date', 'crucial-real-estate')  => 'date',
						__('Price', 'crucial-real-estate') => 'price',
					),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Order', 'crucial-real-estate'),
					'param_name' => 'order',
					'value'      => array(
						__('Descending', 'crucial-real-estate') => 'DESC',
						__('Ascending', 'crucial-real-estate')  => 'ASC',
					),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__('Agent', 'crucial-real-estate'),
					'param_name'  => 'agent',
					'value'       => $agents_array,
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__('Locations', 'crucial-real-estate'),
					'param_name'  => 'locations',
					'value'       => $property_cities_array,
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__('Statuses', 'crucial-real-estate'),
					'param_name'  => 'statuses',
					'value'       => $property_statuses_array,
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__('Types', 'crucial-real-estate'),
					'param_name'  => 'types',
					'value'       => $property_types_array,
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Minimum Bedrooms', 'crucial-real-estate'),
					'param_name'  => 'min_beds',
					'value'       => array(
						cre_any_text() => null,
						'1'                => 1,
						'2'                => 2,
						'3'                => 3,
						'4'                => 4,
						'5'                => 5,
						'6'                => 6,
						'7'                => 7,
						'8'                => 8,
						'9'                => 9,
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Maximum Bedrooms', 'crucial-real-estate'),
					'param_name'  => 'max_beds',
					'value'       => array(
						cre_any_text() => null,
						'1'                => 1,
						'2'                => 2,
						'3'                => 3,
						'4'                => 4,
						'5'                => 5,
						'6'                => 6,
						'7'                => 7,
						'8'                => 8,
						'9'                => 9,
						'10'               => 10,
						'11'               => 11,
						'12'               => 12,
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Minimum Bathrooms', 'crucial-real-estate'),
					'param_name'  => 'min_baths',
					'value'       => array(
						cre_any_text() => null,
						'1'                => 1,
						'2'                => 2,
						'3'                => 3,
						'4'                => 4,
						'5'                => 5,
						'6'                => 6,
						'7'                => 7,
						'8'                => 8,
						'9'                => 9,
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Maximum Bathrooms', 'crucial-real-estate'),
					'param_name'  => 'max_baths',
					'value'       => array(
						cre_any_text() => null,
						'1'                => 1,
						'2'                => 2,
						'3'                => 3,
						'4'                => 4,
						'5'                => 5,
						'6'                => 6,
						'7'                => 7,
						'8'                => 8,
						'9'                => 9,
						'10'               => 10,
						'11'               => 11,
						'12'               => 12,
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Minimum Price', 'crucial-real-estate'),
					'description' => esc_html__('Only provide digits', 'crucial-real-estate'),
					'param_name'  => 'min_price',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Maximum Price', 'crucial-real-estate'),
					'description' => esc_html__('Only provide digits', 'crucial-real-estate'),
					'param_name'  => 'max_price',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Minimum Area', 'crucial-real-estate'),
					'description' => esc_html__('Only provide digits', 'crucial-real-estate'),
					'param_name'  => 'min_area',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Maximum Area', 'crucial-real-estate'),
					'description' => esc_html__('Only provide digits', 'crucial-real-estate'),
					'param_name'  => 'max_area',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Display Only Featured Properties', 'crucial-real-estate'),
					'param_name'  => 'featured',
					'value'       => array(
						__('No', 'crucial-real-estate')  => 'no',
						__('Yes', 'crucial-real-estate') => 'yes',
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__('Features', 'crucial-real-estate'),
					'param_name'  => 'features',
					'value'       => $property_features_array,
					'admin_label' => true,
				),
			),
		));
	}

	add_action('vc_before_init', 'cre_shortcodes_integration');
}
