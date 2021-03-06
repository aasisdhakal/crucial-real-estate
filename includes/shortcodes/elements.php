<?php

/**
 * Properties shortcode
 */

if (!function_exists('cre_properties')) {

	/**
	 * Properties.
	 *
	 * @param  array $attributes - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return html - properties.
	 */
	function cre_properties($attributes, $content = null)
	{
		extract(shortcode_atts(
			array(
				'count'     => 3,
				'layout'    => 'grid',
				'orderby'   => 'date',
				'order'     => 'DESC',
				'locations' => null,
				'statuses'  => null,
				'types'     => null,
				'features'  => null,
				'relation'  => 'AND',
				'min_beds'  => null,
				'max_beds'  => null,
				'min_baths' => null,
				'max_baths' => null,
				'min_price' => null,
				'max_price' => null,
				'min_area'  => null,
				'max_area'  => null,
				'featured'  => 'no',
				'agent'     => null,
			),
			$attributes
		));

		ob_start();

		$paged = 1;
		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) { // if is static front page
			$paged = get_query_var('page');
		}

		$properties_shortcode_args = array(
			'post_type'      => 'property',
			'posts_per_page' => $count,
			'paged'          => $paged,
		);

		// Order By.
		if ('price' == $orderby) {
			$properties_shortcode_args['orderby']  = 'meta_value_num';
			$properties_shortcode_args['meta_key'] = 'REAL_HOMES_property_price';
		} else {
			$properties_shortcode_args['orderby'] = 'date';
		}
		// Order.
		if ('ASC' == $order || 'asc' == $order) {
			$properties_shortcode_args['order'] = 'ASC';
		} else {
			$properties_shortcode_args['order'] = 'DESC';
		}

		/**
		 * Properties Taxonomy Query
		 *
		 * @var array
		 */
		$tax_query = array();

		// Properties types.
		if ($types) {
			$types       = explode(',', $types);
			$tax_query[] = array(
				'taxonomy' => 'property-type',
				'field'    => 'slug',
				'terms'    => $types,
			);
		}

		// Properties statuses.
		if ($statuses) {
			$statuses    = explode(',', $statuses);
			$tax_query[] = array(
				'taxonomy' => 'property-status',
				'field'    => 'slug',
				'terms'    => $statuses,
			);
		}

		// Properties locations.
		if ($locations) {
			$locations   = explode(',', $locations);
			$tax_query[] = array(
				'taxonomy' => 'property-city',
				'field'    => 'slug',
				'terms'    => $locations,
			);
		}

		// Properties features.
		if ($features) {
			$features    = explode(',', $features);
			$tax_query[] = array(
				'taxonomy' => 'property-feature',
				'field'    => 'slug',
				'terms'    => $features,
			);
		}

		// Taxonomy query relationship only if taxonomies are more than one.
		$tax_count = count($tax_query);
		if ($tax_count > 1) {
			$tax_query['relation'] = 'AND';
		}
		if ($tax_count > 0) {
			$properties_shortcode_args['tax_query'] = $tax_query;
		}

		/**
		 * Properties Meta Query
		 *
		 * @var array
		 */
		$meta_query = array();

		// Bedrooms.
		if (!empty($min_beds) || !empty($max_beds)) {
			$min_beds = abs(intval($min_beds));
			$max_beds = abs(intval($max_beds));
			if ($max_beds > 0) {
				/**
				 * If max beds are greater than 0 then either min beds
				 * are 0 or greater than 0, And in both cases same query will be enough.
				 */
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_bedrooms',
					'value'   => array($min_beds, $max_beds),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN',
				);
			} else {
				// If max beds are 0 then only min beds matters.
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_bedrooms',
					'value'   => $min_beds,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				);
			}
		}

		// Bathrooms.
		if (!empty($min_baths) || !empty($max_baths)) {
			$min_baths = abs(intval($min_baths));
			$max_baths = abs(intval($max_baths));
			if ($max_baths > 0) {
				/**
				 * If max baths are greater than 0 then either min baths
				 * are 0 or greater than 0, And in both cases same query will be enough.
				 */
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_bathrooms',
					'value'   => array($min_baths, $max_baths),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN',
				);
			} else {
				// If max baths are 0 then only min baths matters.
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_bathrooms',
					'value'   => $min_baths,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				);
			}
		}

		// Price.
		if (!empty($min_price) || !empty($max_price)) {
			$min_price = doubleval($min_price);
			$max_price = doubleval($max_price);
			if ($max_price > 0) {
				/**
				 * If max price is greater than 0 then either min price
				 * is 0 or greater than 0, And in both cases same query will be enough.
				 */
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => array($min_price, $max_price),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN',
				);
			} else {
				// If max price is 0 then only min price matters.
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => $min_price,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				);
			}
		}

		// Size.
		if (!empty($min_area) || !empty($max_area)) {
			$min_area = intval($min_area);
			$max_area = intval($max_area);
			if ($max_area > 0) {
				/**
				 * If max area is greater than 0 then either min area
				 * is 0 or greater than 0, And in both cases same query will be enough.
				 */
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_size',
					'value'   => array($min_area, $max_area),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN',
				);
			} else {
				// If max area is 0 then only min area matters.
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_size',
					'value'   => $min_area,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				);
			}
		}

		// Featured Properties.
		$featured = ('yes' == $featured) ? true : false;
		if ($featured) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_featured',
				'value'   => 1,
				'compare' => '=',
				'type'    => 'NUMERIC',
			);
		}

		// agent based properties
		if (!empty($agent)) {
			$agent_ids = explode(',', $agent);
			if (count($agent_ids) >= 1) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_agents',
					'value'   => $agent_ids,
					'compare' => 'IN',
				);
			}
		}

		// if more than one meta query elements exist then specify the relation.
		$meta_count = count($meta_query);
		if ($meta_count > 1) {
			$meta_query['relation'] = 'AND';
		}
		if ($meta_count > 0) {
			$properties_shortcode_args['meta_query'] = $meta_query;
		}

		static $cre_id = 1;

		$properties_shortcode_query = new WP_Query($properties_shortcode_args);

		if ($properties_shortcode_query->have_posts()) :

			echo '<div id="cre_shortcode_' . $cre_id . '"  class="cre_latest_properties_ajax cre_ele_property_ajax_target">';
			echo '<div class="home-properties-section-inner-target">';
			if ('list' == $layout) :
				if ('classic' === INSPIRY_DESIGN_VARIATION) :
					// LIST LAYOUT.
					echo '<div class="listing-layout aarambha-shortcode">';
					echo '<div class="list-container rh_list_shortcode_container clearfix">';

					while ($properties_shortcode_query->have_posts()) :
						$properties_shortcode_query->the_post();
						get_template_part('assets/classic/partials/properties/list-card');
					endwhile;
					echo '</div>';
					echo '</div>';
				elseif ('modern' === INSPIRY_DESIGN_VARIATION) :
					// LIST LAYOUT.
					echo '<div class="listing-layout aarambha-shortcode">';
					echo '<div class="list-container clearfix">';
					while ($properties_shortcode_query->have_posts()) :
						$properties_shortcode_query->the_post();
						get_template_part('assets/modern/partials/properties/shortcode/list-card');
					endwhile;
					echo '</div>';
					echo '</div>';
				endif;
			else :
				if ('classic' === INSPIRY_DESIGN_VARIATION) {
					// GRID LAYOUT.
					echo '<div class="listing-layout property-grid aarambha-shortcode">';
					echo '<div class="list-container rh_grid_shortcode_container clearfix">';
					while ($properties_shortcode_query->have_posts()) :
						$properties_shortcode_query->the_post();
						get_template_part('assets/classic/partials/property/single/similar-property-card');
					endwhile;
					echo '</div>';
					echo '</div>';
				} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
					// GRID LAYOUT.
					echo '<div class="grid-layout property-grid aarambha-shortcode">';
					echo '<div class="list-container clearfix">';
					while ($properties_shortcode_query->have_posts()) :
						$properties_shortcode_query->the_post();
						get_template_part('assets/modern/partials/properties/shortcode/grid-card');
					endwhile;
					echo '</div>';
					echo '</div>';
				}
			endif;

			$cre_id++;

		else :
			alert(esc_html__('Result:', 'crucial-real-estate'), esc_html__('No Properties Found!', 'crucial-real-estate'));
		endif;

		CRE_ajax_pagination($properties_shortcode_query->max_num_pages);
		echo '</div>';
		echo '</div>';

		//		cre_theme_pagination( $properties_shortcode_query->max_num_pages );

		wp_reset_postdata();

		return ob_get_clean();
	}
}
add_shortcode('properties', 'cre_properties');


/* ------------------------------------------------------------------------*
 * Messages Shortcode
 * ------------------------------------------------------------------------*/

// Information
if (!function_exists('cre_show_info')) {
	function cre_show_info($atts, $content = null)
	{
		return '<p class="info">' . do_shortcode($content) . '<i class="icon-remove"></i></p>';
	}
}
add_shortcode('info', 'cre_show_info');

// Tip
if (!function_exists('cre_show_tip')) {
	function cre_show_tip($atts, $content = null)
	{
		return '<p class="tip">' . do_shortcode($content) . '<i class="icon-remove"></i></p>';
	}
}
add_shortcode('tip', 'cre_show_tip');

// Error
if (!function_exists('cre_show_error')) {
	function cre_show_error($atts, $content = null)
	{
		return '<p class="error">' . do_shortcode($content) . '<i class="icon-remove"></i></p>';
	}
}
add_shortcode('error', 'cre_show_error');

// Success
if (!function_exists('cre_show_success')) {
	function cre_show_success($atts, $content = null)
	{
		return '<p class="success">' . do_shortcode($content) . '<i class="icon-remove"></i></p>';
	}
}
add_shortcode('success', 'cre_show_success');


/* ------------------------------------------------------------------------*
 * Lists
 * ------------------------------------------------------------------------*/
// Disc list
if (!function_exists('cre_disc_list')) {
	function cre_disc_list($atts, $content = null)
	{
		return '<div class="disc-list">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('disc_list', 'cre_disc_list');

// small arrow list
if (!function_exists('cre_small_arrow_list')) {
	function cre_small_arrow_list($atts, $content = null)
	{
		return '<div class="small-arrow-list">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('small_arrow_list', 'cre_small_arrow_list');

// Tick list
if (!function_exists('cre_tick_list')) {
	function cre_tick_list($atts, $content = null)
	{
		return '<div class="tick-list">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('tick_list', 'cre_tick_list');

// Arrow list
if (!function_exists('cre_arrow_list')) {
	function cre_arrow_list($atts, $content = null)
	{
		return '<div class="arrow-list">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('arrow_list', 'cre_arrow_list');


/* ------------------------------------------------------------------------*
 * Buttons
 * ------------------------------------------------------------------------*/

if (!function_exists('cre_button_real_mini')) {

	/**
	 * Button Real Mini.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_real_mini($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="real-btn btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--primary btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="real-btn btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_mini', 'cre_button_real_mini');


if (!function_exists('cre_button_real_small')) {

	/**
	 * Button Real Small.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_real_small($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="real-btn btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--primary btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="real-btn btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_small', 'cre_button_real_small');


if (!function_exists('cre_button_real_large')) {

	/**
	 * Button Real Large.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_real_large($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="real-btn btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--primary btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="real-btn btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_large', 'cre_button_real_large');


if (!function_exists('cre_button_blue_mini')) {

	/**
	 * Button blue Mini.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_blue_mini($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="btn-blue btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--secondary btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="btn-blue btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_blue_mini', 'cre_button_blue_mini');


if (!function_exists('cre_button_blue_small')) {

	/**
	 * Button blue Small.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_blue_small($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="btn-blue btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--secondary btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="btn-blue btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_blue_small', 'cre_button_blue_small');


if (!function_exists('cre_button_blue_large')) {

	/**
	 * Button blue Large.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_blue_large($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="btn-blue btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--secondary btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="btn-blue btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_blue_large', 'cre_button_blue_large');


if (!function_exists('cre_button_grey_mini')) {

	/**
	 * Button grey Mini.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_grey_mini($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="btn-grey btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--greybtn btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="btn-grey btn-mini" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_grey_mini', 'cre_button_grey_mini');


if (!function_exists('cre_button_grey_small')) {

	/**
	 * Button grey Small.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_grey_small($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="btn-grey btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--greybtn btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="btn-grey btn-small" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_grey_small', 'cre_button_grey_small');


if (!function_exists('cre_button_grey_large')) {

	/**
	 * Button grey Large.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return button link
	 */
	function cre_button_grey_large($atts, $content = null)
	{

		extract(shortcode_atts(
			array(
				'link'   => '#',
				'target' => '',
			),
			$atts
		));

		if ('classic' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="btn-grey btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} elseif ('modern' === INSPIRY_DESIGN_VARIATION) {
			return '<a class="rh_btn rh_btn--greybtn btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		} else {
			return '<a class="btn-grey btn-large" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
		}
	}
}
add_shortcode('button_grey_large', 'cre_button_grey_large');


if (!function_exists('cre_video_wrapper')) {

	/**
	 * Video Wrapper.
	 *
	 * @param  array $atts - array of attributes.
	 * @param  string $content - string to display as content.
	 *
	 * @return html - video wrapper.
	 */
	function cre_video_wrapper($atts, $content = null)
	{
		return '<div class="post-video"><div class="video-wrapper">' . stripslashes(htmlspecialchars_decode($content)) . '</div></div>';
	}
}
add_shortcode('video_wrapper', 'cre_video_wrapper');


if (!function_exists('cre_theme_pagination')) {
	/**
	 * Pagination
	 *
	 * @param string $pages - number of pages.
	 */
	function cre_theme_pagination($pages = '')
	{

		$paged = 1;
		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) { // if is static front page
			$paged = get_query_var('page');
		}

		$prev       = $paged - 1;
		$next       = $paged + 1;
		$range      = 3; // only change it to show more links
		$show_items = ($range * 2) + 1;

		if ($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if (!$pages) {
				$pages = 1;
			}
		}

		if (1 != $pages) {
			echo "<div class='rh_pagination'>";
			// echo ( $paged > 2 && $paged > $range + 1 && $show_items < $pages ) ? "<a href='" . get_pagenum_link( 1 ) . "' class='real-btn'>&laquo; " . __( 'First', 'crucial-real-estate' ) . "</a> " : "";
			if ($paged > 1 && $show_items < $pages) {
				echo "<a href='" . get_pagenum_link($prev) . "' class='rh_pagination__btn rh_pagination__prev' >";
				include(CRE_PLUGIN_DIR . '/images/icons/icon-left.svg');
				echo "</a>";
			}

			for ($i = 1; $i <= $pages; $i++) {
				if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $show_items)) {
					echo ($paged == $i) ? "<a href='" . get_pagenum_link($i) . "' class='rh_pagination__btn current' >" . $i . "</a> " : "<a href='" . get_pagenum_link($i) . "' class='rh_pagination__btn'>" . $i . "</a> ";
				}
			}

			if ($paged < $pages && $show_items < $pages) {
				echo "<a href='" . get_pagenum_link($next) . "' class='rh_pagination__btn rh_pagination__next' >";
				include(CRE_PLUGIN_DIR . '/images/icons/icon-right.svg');
				echo "</a>";
			}
			echo "</div>";
		}
	}
}

if (!function_exists('CRE_ajax_pagination')) {
	/**
	 * Function for Widgets AJAX pagination
	 *
	 * @param string $pages
	 */
	function CRE_ajax_pagination($pages = '')
	{

		global $wp_query;

		$paged = 1;
		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) { // if is static front page
			$paged = get_query_var('page');
		}

		$prev          = $paged - 1;
		$next          = $paged + 1;
		$range         = 3;                             // change it to show more links
		$pages_to_show = ($range * 2) + 1;

		if ($pages == '') {
			$pages = $wp_query->max_num_pages;
			if (!$pages) {
				$pages = 1;
			}
		}

		if (1 != $pages) {
			echo "<div class='cre_pagination_wrapper'>";
			echo "<div class='pagination cre-pagination-clean'>";

			if (($paged > 2) && ($paged > $range + 1) && ($pages_to_show < $pages)) {
				echo "<a href='" . get_pagenum_link(1) . "' class='real-btn'> " . esc_html__('First', 'Crucial Real Estate-elementor-addon') . "</a> "; // First Page
			}

			if (($paged > 1) && ($pages_to_show < $pages)) {
				echo "<a href='" . get_pagenum_link($prev) . "' class='real-btn'> " . esc_html__('Prev', 'Crucial Real Estate-elementor-addon') . "</a> "; // Previous Page
			}

			$min_page_number = $paged - $range - 1;
			$max_page_number = $paged + $range + 1;

			for ($i = 1; $i <= $pages; $i++) {
				if ((($i > $min_page_number) && ($i < $max_page_number)) || ($pages <= $pages_to_show)) {
					$current_class = 'real-btn';
					$current_class .= ($paged == $i) ? ' current' : '';
					echo "<a href='" . get_pagenum_link($i) . "' class='" . $current_class . "' >" . $i . "</a> ";
				}
			}

			if (($paged < $pages) && ($pages_to_show < $pages)) {
				echo "<a href='" . get_pagenum_link($next) . "' class='real-btn'>" . esc_html__('Next', 'Crucial Real Estate-elementor-addon') . " </a> "; // Next Page
			}

			if (($paged < $pages - 1) && ($paged + $range - 1 < $pages) && ($pages_to_show < $pages)) {
				echo "<a href='" . get_pagenum_link($pages) . "' class='real-btn'>" . esc_html__('Last', 'Crucial Real Estate-elementor-addon') . " </a> "; // Last Page
			}

			echo "</div>";
			echo "</div>";
		}
	}
}
