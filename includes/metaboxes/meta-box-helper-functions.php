<?php

/**
 * Meta boxes helper functions
 *
 */

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
