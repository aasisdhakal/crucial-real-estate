<?php

/**
 * Columns Shortcodes
 */

// columns wrapper
if (!function_exists('cre_show_columns')) {
	function cre_show_columns($atts, $content = null)
	{
		return '<div class="row-fluid">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('columns', 'cre_show_columns');

// single column
if (!function_exists('cre_show_single_column')) {
	function cre_show_single_column($atts, $content = null)
	{
		return '<div class="span12">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('single_column', 'cre_show_single_column');

// two columns
if (!function_exists('cre_show_two_column')) {
	function cre_show_two_column($atts, $content = null)
	{
		return '<div class="span6">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('one_half', 'cre_show_two_column');

// three columns
if (!function_exists('cre_show_one_third')) {
	function cre_show_one_third($atts, $content = null)
	{
		return '<div class="span4">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('one_third', 'cre_show_one_third');


// four columns
if (!function_exists('cre_show_one_fourth')) {
	function cre_show_one_fourth($atts, $content = null)
	{
		return '<div class="span3">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('one_fourth', 'cre_show_one_fourth');

// six columns
if (!function_exists('cre_show_one_sixth')) {
	function cre_show_one_sixth($atts, $content = null)
	{
		return '<div class="span2">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('one_sixth', 'cre_show_one_sixth');

// three columns
if (!function_exists('cre_show_three_fourth')) {
	function cre_show_three_fourth($atts, $content = null)
	{
		return '<div class="span9">' . do_shortcode($content) . '</div>';
	}
}
add_shortcode('three_fourth', 'cre_show_three_fourth');
