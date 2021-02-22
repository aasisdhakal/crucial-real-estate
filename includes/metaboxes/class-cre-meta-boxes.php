<?php

/**
 * Class CRE_Meta_Boxes
 *
 * Class to handle stuff related to meta boxes.
 */

if (!defined('ABSPATH')) {
	exit;
}

class CRE_Meta_Boxes
{

	/**
	 * Initialize meta boxes
	 *
	 */
	public static function init()
	{
		do_action('cre_before_meta_boxes_init');

		// Deactivate meta box plugin if it is installed and active
		add_action('init', array(__CLASS__, 'deactivate_meta_box_plugin'));

		self::includes();

		// Meta boxes helper functions
		include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/meta-box-helper-functions.php');

		// Property meta boxes declaration
		include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/property-meta-boxes-config.php');

		// Templates meta boxes declaration
		include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/templates-meta-boxes-config.php');

		do_action('cre_meta_boxes_init');
	}

	/**
	 * Include meta box plugin and required extensions
	 *
	 * @since 1.0.0
	 */
	protected static function includes()
	{

		// Include meta box
		if (!class_exists('RW_Meta_Box')) {
			if (file_exists(CRE_PLUGIN_DIR . '/includes/metaboxes/main/meta-box.php')) {
				include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/main/meta-box.php');
			}
		}

		// Include meta box tabs
		if (!class_exists('MB_Tabs')) {
			if (file_exists(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/meta-box-tabs/meta-box-tabs.php')) {
				include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/meta-box-tabs/meta-box-tabs.php');
			}
		}

		// Include 'Include Exclude' extension
		if (!class_exists('MB_Include_Exclude')) {
			if (file_exists(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/meta-box-include-exclude/meta-box-include-exclude.php')) {
				include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/meta-box-include-exclude/meta-box-include-exclude.php');
			}
		}

		// Include show hide extension
		if (!class_exists('MB_Show_Hide')) {
			if (file_exists(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/meta-box-show-hide/meta-box-show-hide.php')) {
				include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/meta-box-show-hide/meta-box-show-hide.php');
			}
		}
		
		// Include group extension
		if (!class_exists('RWMB_Group')) {
			if (file_exists(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/meta-box-group/meta-box-group.php')) {
				include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/meta-box-group/meta-box-group.php');
			}
		}

		// Include term meta extension
		if (!class_exists('MB_Term_Meta_Box')) {
			if (file_exists(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/mb-term-meta/mb-term-meta.php')) {
				include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/mb-term-meta/mb-term-meta.php');
			}
		}

		// Include settings page extension
		if (!class_exists('SettingsPage')) {
			if (file_exists(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/mb-settings-page/mb-settings-page.php')) {
				include_once(CRE_PLUGIN_DIR . '/includes/metaboxes/exts/mb-settings-page/mb-settings-page.php');
			}
		}

		// Include custom 'sorter' field type
		if (!class_exists('RWMB_Sorter_Field')) {
			if (file_exists(CRE_PLUGIN_DIR . '/includes/metaboxes/custom/custom-field-type-sorter.php')) {
				require(CRE_PLUGIN_DIR . '/includes/metaboxes/custom/custom-field-type-sorter.php');
			}
		}
	}

	/**
	 * Deactivate meta box plugin if it is active.
	 */
	public static function deactivate_meta_box_plugin()
	{

		// Meta Box Plugin
		if (is_plugin_active('meta-box/meta-box.php')) {
			deactivate_plugins('meta-box/meta-box.php');
			add_action('admin_notices', function () {
?>
				<div class="update-nag notice is-dismissible">
					<p><strong><?php _e('Meta Box plugin has been deactivated!', 'crucial-real-estate'); ?></strong></p>
					<p><?php _e('As similar functionality is already embedded with in Crucial Real Estate plugin.', 'crucial-real-estate'); ?></p>
					<p>
						<em><?php _e('So, You should completely remove it from your plugins.', 'crucial-real-estate'); ?></em>
					</p>
				</div>
<?php
			});
		}
	}
}

/*
 * Initialize meta boxes.
 */
CRE_Meta_Boxes::init();
