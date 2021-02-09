<?php

/**
 * Add gallery metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function cre_gallery_metabox_tab($property_metabox_tabs)
{
	if (is_array($property_metabox_tabs)) {
		$property_metabox_tabs['gallery'] = array(
			'label' => esc_html__('Gallery Images', 'crucial-real-estate'),
			'icon'  => 'dashicons-format-gallery',
		);
	}

	return $property_metabox_tabs;
}

add_filter('cre_property_metabox_tabs', 'cre_gallery_metabox_tab', 30);


/**
 * Add gallery metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function cre_gallery_metabox_fields($property_metabox_fields)
{




	$cre_gallery_fields = array(
		array(
			'name'             => esc_html__('Property Gallery Images', 'crucial-real-estate'),
			'id'               => "cre_property_images",
			'desc'             => cre_property_gallery_meta_desc(),
			'type'             => 'image_advanced',
			'max_file_uploads' => 4,
			'columns'          => 12,
			'tab'              => 'gallery',
		),
		
	);

	return array_merge($property_metabox_fields, $cre_gallery_fields);
}

add_filter('cre_property_metabox_fields', 'cre_gallery_metabox_fields', 30);
