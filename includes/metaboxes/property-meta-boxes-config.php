<?php
// Basic information meta boxes
include_once CRE_PLUGIN_DIR . 'includes/metaboxes/property/basic-metaboxes.php';

// Location map meta boxes
include_once CRE_PLUGIN_DIR . 'includes/metaboxes/property/location-metaboxes.php';

// Gallery meta boxes
include_once CRE_PLUGIN_DIR . 'includes/metaboxes/property/gallery-metaboxes.php';

// Custom taxonomy meta boxes
include_once CRE_PLUGIN_DIR . 'includes/metaboxes/property/custom-taxonomy-metaboxes.php';

if (!function_exists('cre_property_meta_boxes')) :
	/**
	 * Contains property related meta box declarations
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 */
	function cre_property_meta_boxes($meta_boxes)
	{

		// tabs are added using filter hooks
		$meta_tabs = array();

		// fields are added using filter hooks
		$meta_fields = array();

		// Property meta boxes
		$meta_boxes[] = array(
			'id'         => 'property-meta-box',
			'title'      => esc_html__('Property', 'crucial-real-estate'),
			'post_types' => array('property'),
			'tabs'       => apply_filters('cre_property_metabox_tabs', $meta_tabs),
			'tab_style'  => 'left',
			'fields'     => apply_filters('cre_property_metabox_fields', $meta_fields),
		);

		return apply_filters('cre_property_meta_boxes', $meta_boxes);
	}

	add_filter('rwmb_meta_boxes', 'cre_property_meta_boxes');

endif;
