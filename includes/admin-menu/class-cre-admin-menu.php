<?php

/**
 * Admin Menu Class for ERE
 *
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class CRE_Admin_Menu
{

	public static $_instance;
	public $menu_capability = 'edit_posts';
	public $menu_slug = 'crucial-real-estate';

	public function __construct()
	{

		// initialize menu
		add_action('admin_menu', array($this, 'admin_menu'));

		// Expand ERE admin menu when a sub menu is visited
		add_action('admin_footer', array($this, 'expand_menu'));
	}

	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function admin_menu()
	{

		add_menu_page(
			__('Crucial Real Estate', 'crucial-real-estate'),
			__('Crucial Real Estate', 'crucial-real-estate'),
			$this->menu_capability,
			$this->menu_slug,
			'',
			'dashicons-admin-home',
			'5'
		);

		// Add sub menus
		$sub_menus = [];
		$sub_menus['addnew'] = array(
			$this->menu_slug,
			__('Add New Property', 'crucial-real-estate'),
			__('New Property', 'crucial-real-estate'),
			$this->menu_capability,
			'post-new.php?post_type=property',
		);

		// Getting all taxonomies from property post type.
		$property_tax = get_object_taxonomies('property', 'objects');

		// Looping through the taxonomy object and building array with required format.
		foreach ($property_tax as $single_tax) {
			$sub_menus[$single_tax->name] = array(
				$this->menu_slug,
				$single_tax->labels->add_new_item,
				$single_tax->labels->name,
				$this->menu_capability,
				'edit-tags.php?taxonomy=' . $single_tax->name . '&post_type=property',
			);
		}

		$sub_menus['cre_settings'] = array(
			'crucial-real-estate',
			__('Settings', 'crucial-real-estate'),
			__('Settings', 'crucial-real-estate'),
			'manage_options',
			'cre-settings',
			array(Crucial_Real_Estate::instance(), 'settings_page')
		);

		$sub_menus = apply_filters('aarambha_cre_admin_sub_menu', $sub_menus);

		if ($sub_menus) {
			foreach ($sub_menus as $sub_menu) {
				call_user_func_array('add_submenu_page', $sub_menu);
			}
		}
	}

	public function expand_menu()
	{

		// Get Current Screen.
		$screen    = get_current_screen();

		$tax_names          = get_object_taxonomies('property', 'names');
		$tax_names_prefixed = array_map(function ($item) {
			return 'edit-' . $item;
		}, $tax_names);

		$menu_arr        = apply_filters('cre_expand_menus_slugs', $tax_names_prefixed);

		// Check if the current screen's ID has any of the above menu array items.
		if (in_array($screen->id, $menu_arr)) {

			// Filter $_GET array for security.
			$get_array = filter_input_array(INPUT_GET);
			$current_menu = '';

			foreach ($tax_names as $tax_name) {
				if (isset($get_array['taxonomy']) && ($tax_name === $get_array['taxonomy'])) {
					$current_menu = 'taxonomy=' . $tax_name;
					break;
				}
			}

			if (!empty($current_menu)) {
?>
				<script type="text/javascript">
					(function($) {
						$("body").removeClass("sticky-menu");
						$("#toplevel_page_crucial-real-estate").addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
						$("#toplevel_page_crucial-real-estate > a").addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
						$(document).ready(function() {
							if ('<?php echo esc_html($current_menu); ?>') {
								const anchors = $('#toplevel_page_crucial-real-estate ul').find('li').children('a');
								anchors.each(function() {
									if (this.href.indexOf('<?php echo esc_html($current_menu); ?>') >= 0) {
										$(this).parent('li').addClass("current");
									}
								});
							}
						});
					})(jQuery);
				</script>
<?php
			}
		}
	}
}

/**
 * Initialize ERE admin menu class.
 */
function cre_admin_menu()
{
	return CRE_Admin_Menu::instance();
}

cre_admin_menu();
