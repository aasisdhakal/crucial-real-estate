<?php

/**
 * Meta boxes helper functions
 *
 */

if (!function_exists('cre_get_google_maps_api_key')) :
	/**
	 * Returns google maps API key if configured, otherwise false.
	 *
	 * @return bool|string
	 */
	function cre_get_google_maps_api_key()
	{
		$google_maps_api_key = get_option('aarambha_google_maps_api_key');
		if (!empty($google_maps_api_key)) {
			$google_maps_api_key = urlencode($google_maps_api_key);

			return $google_maps_api_key;
		}

		return false;
	}
endif;


if (!function_exists('cre_metabox_map_type')) :
	/**
	 * Returns the type of metabox currently available for use.
	 *
	 * @return string
	 */
	function cre_metabox_map_type()
	{
		$google_maps_api_key = cre_get_google_maps_api_key();
		if ($google_maps_api_key) {
			return 'map';   // for google Maps
		}

		return 'osm';   // For OpenStreetMap https://www.openstreetmap.org/
	}
endif;


if (!function_exists('cre_get_agents_array')) :
	/**
	 * Returns an array of Agent ID => Agent Name
	 *
	 * @return array
	 */
	function cre_get_agents_array()
	{

		$agents_array = array(
			-1 => esc_html__('None', 'crucial-real-estate'),
		);

		$agents_posts = get_posts(
			array(
				'post_type'        => 'agent',
				'posts_per_page'   => -1,
				'suppress_filters' => 0,
			)
		);

		if (count($agents_posts) > 0) {
			foreach ($agents_posts as $agent_post) {
				$agents_array[$agent_post->ID] = $agent_post->post_title;
			}
		}

		return $agents_array;
	}
endif;


if (!function_exists('cre_get_agency_array')) :
	/**
	 * Returns an array of Agency ID => Agency Name
	 *
	 * @return array
	 */
	function cre_get_agency_array()
	{

		$agency_array = array(
			-1 => esc_html__('None', 'crucial-real-estate'),
		);

		$agency_posts = get_posts(
			array(
				'post_type'        => 'agency',
				'posts_per_page'   => -1,
				'suppress_filters' => 0,
			)
		);

		if (count($agency_posts) > 0) {
			foreach ($agency_posts as $agency_post) {
				$agency_array[$agency_post->ID] = $agency_post->post_title;
			}
		}

		return $agency_array;
	}
endif;


if (!function_exists('cre_property_gallery_meta_desc')) :
	/**
	 * Function to return gallery meta description.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	function cre_property_gallery_meta_desc()
	{
		if ('modern' === INSPIRY_DESIGN_VARIATION) {
			return esc_html__('Images should have minimum size of 1240px by 720px. Bigger size images will be cropped automatically. Minimum 2 images are required to display gallery.', 'crucial-real-estate');
		}

		// For classic version.
		return esc_html__('Images should have minimum size of 1170px by 648px for thumbnails on right and 830px by 460px for thumbnails on bottom. Bigger size images will be cropped automatically. Minimum 2 images are required to display gallery.', 'crucial-real-estate');
	}
endif;
