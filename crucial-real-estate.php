<?php

/**
 * Plugin Name: Crucial Real Estate
 * Plugin URI: http://aarambhathemes.com
 * Description: Provides real estate functionality for Crucial Real Estate theme.
 * Version: 0.0.1
 * Author: Aarambha Themes
 * Author URI: http://aarambhathemes.com
 * Text Domain: crucial-real-estate
 * Domain Path: /languages
 *
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Crucial_Real_Estate')) :

	final class Crucial_Real_Estate
	{

		/**
		 * Plugin's current version
		 *
		 * @var string
		 */
		public $version;

		/**
		 * Plugin Name
		 *
		 * @var string
		 */
		public $plugin_name;

		/**
		 * Plugin's singleton instance.
		 *
		 * @var Crucial_Real_Estate
		 */
		protected static $_instance;

		/**
		 * Constructor function.
		 */
		public function __construct()
		{

			$this->plugin_name = 'crucial-real-estate';
			$this->version     = '0.0.1';

			$this->define_constants();

			$this->includes();

			$this->initialize_custom_post_types();

			$this->initialize_meta_boxes();

			$this->initialize_admin_menu();

			$this->init_hooks();

			do_action('cre_loaded');  // Crucial Real Estate plugin loaded action hook.
		}

		/**
		 * Provides singleton instance.
		 */
		public static function instance()
		{
			if (is_null(self::$_instance)) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Defines constants.
		 */
		protected function define_constants()
		{

			if (!defined('CRE_VERSION')) {
				define('CRE_VERSION', $this->version);
			}

			// Full path and filename.
			if (!defined('CRE_PLUGIN_FILE')) {
				define('CRE_PLUGIN_FILE', __FILE__);
			}

			// Plugin directory path.
			if (!defined('CRE_PLUGIN_DIR')) {
				define('CRE_PLUGIN_DIR', plugin_dir_path(__FILE__));
			}

			// Plugin directory URL.
			if (!defined('CRE_PLUGIN_URL')) {
				define('CRE_PLUGIN_URL', plugin_dir_url(__FILE__));
			}

			// Plugin file path relative to plugins directory.
			if (!defined('CRE_PLUGIN_BASENAME')) {
				define('CRE_PLUGIN_BASENAME', plugin_basename(__FILE__));
			}

			// Crucial Real Estate selected design variation.
			if (!defined('INSPIRY_DESIGN_VARIATION')) {
				define('INSPIRY_DESIGN_VARIATION', get_option('aarambha_design_variation', 'modern'));
			}
		}

		/**
		 * Includes files required on admin and on frontend.
		 */
		public function includes()
		{
			$this->include_functions();
		}
		

		/**
		 * Functions
		 */
		public function include_functions()
		{
			require_once CRE_PLUGIN_DIR . 'includes/functions/basic.php';
			require_once CRE_PLUGIN_DIR . 'includes/functions/settings.php';
			require_once CRE_PLUGIN_DIR . 'includes/functions/price.php';   // price functions.
			require_once CRE_PLUGIN_DIR . 'includes/functions/real-estate.php';   // real estate functions.
		}

		/**
		 * Admin menu.
		 */
		public function initialize_admin_menu()
		{
			require_once CRE_PLUGIN_DIR . 'includes/admin-menu/class-cre-admin-menu.php';
		}

		/**
		 * Custom Post Types
		 */
		public function initialize_custom_post_types()
		{
			// Post Type:: property
			include_once CRE_PLUGIN_DIR . 'includes/custom-post-types/property.php';
		}

		/**
		 * Meta boxes
		 */
		public function initialize_meta_boxes()
		{
			include_once CRE_PLUGIN_DIR . 'includes/metaboxes/class-cre-meta-boxes.php';
		}

		/**
		 * Initialize hooks.
		 */
		public function init_hooks()
		{
			add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
			add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));  // plugin's admin styles.
			add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts')); // plugin's admin scrips.
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts')); // plugin's scripts.
		}

		/**
		 * Load text domain for translation.
		 */
		public function load_plugin_textdomain()
		{
			load_plugin_textdomain('crucial-real-estate', false, dirname(CRE_PLUGIN_BASENAME) . '/languages');
		}

		/**
		 * Enqueue admin styles
		 */
		public function enqueue_admin_styles()
		{
			wp_enqueue_style('crucial-real-estate-admin', CRE_PLUGIN_URL . 'css/cre-admin.css', array(), $this->version, 'all');
		}

		/**
		 * Enqueue Admin JavaScript
		 */
		public function enqueue_admin_scripts()
		{
			wp_enqueue_script(
				'crucial-real-estate-admin',
				CRE_PLUGIN_URL . 'js/cre-admin.js',
				array(
					'jquery',
					'jquery-ui-sortable',
				),
				$this->version
			);

			$cre_social_links_strings = array(
				'title'       => esc_html__('Title', 'crucial-real-estate'),
				'profileURL'  => esc_html__('Profile URL', 'crucial-real-estate'),
				'iconClass'   => esc_html__('Icon Class', 'crucial-real-estate'),
				'iconExample' => esc_html__('Example: fas fa-flicker', 'crucial-real-estate'),
				'iconLink'    => esc_html__('Get icon!', 'crucial-real-estate'),
			);
			wp_localize_script('crucial-real-estate-admin', 'ereSocialLinksL10n', $cre_social_links_strings);
		}

		/**
		 * Enqueue JavaScript
		 */
		public function enqueue_scripts()
		{

			// ERE frontend script.
			wp_register_script('jquery-validate', CRE_PLUGIN_URL . 'js/jquery.validate.min.js', array('jquery', 'jquery-form'), $this->version, true);
			wp_register_script('cre-frontend', CRE_PLUGIN_URL . 'js/cre-frontend.js', array('jquery-validate'), $this->version, true);
			wp_localize_script('cre-frontend', 'cre_social_login_data', array('ajax_url' => admin_url('admin-ajax.php')));
			wp_enqueue_script('cre-frontend');
		}

		/**
		 * Tabs
		 */
		public function tabs()
		{

			$tabs = array(
				'price'              => esc_html__('Price Format', 'crucial-real-estate'),
				'slug'               => esc_html__('URL Slugs', 'crucial-real-estate'),
			);

			return $tabs;
		}

		/**
		 * Generates tabs navigation
		 */
		public function tabs_nav($current_tab)
		{

			$tabs = $this->tabs();
?>
			<div id="aarambha-cre-tabs" class="aarambha-cre-tabs">
				<?php
				if (!empty($tabs) && is_array($tabs)) {
					foreach ($tabs as $slug => $title) {
						if (file_exists(CRE_PLUGIN_DIR . 'includes/settings/' . $slug . '.php')) {
							$active_tab = ($current_tab === $slug) ? ' aarambha-is-active-tab' : '';
							$admin_url  = ($current_tab === $slug) ? '#' : admin_url('admin.php?page=cre-settings&tab=' . $slug);
							echo '<a class="aarambha-cre-tab ' . esc_attr($active_tab) . '" href="' . esc_url_raw($admin_url) . '" data-tab="' . esc_attr($slug) . '">' . esc_html($title) . '</a>';
						}
					}
				}
				?>
			</div>
		<?php
		}

		/**
		 * Settings page callback
		 */
		public function settings_page()
		{
			require_once CRE_PLUGIN_DIR . 'includes/settings/settings.php';
		}

		/**
		 * Retrieves an option value based on an option name.
		 *
		 * @param string $option_name
		 * @param bool   $default
		 * @param string $type
		 *
		 * @return mixed|string
		 */
		public function get_option($option_name, $default = false, $type = 'text')
		{

			if (isset($_POST[$option_name])) {
				$value = $_POST[$option_name];

				switch ($type) {
					case 'textarea':
						$value = wp_kses($value, array(
							'a'      => array(
								'class'  => array(),
								'href'   => array(),
								'target' => array(),
								'title'  => array(),
							),
							'br'     => array(),
							'em'     => array(),
							'strong' => array(),
						));
						break;

					default:
						$value = sanitize_text_field($value);
				}

				return $value;
			}

			return get_option($option_name, $default);
		}

		/**
		 * Sanitize additional social networks array.
		 */
		public function sanitize_social_networks($social_networks)
		{

			// Initialize the new array that will hold the sanitize values.
			$sanitized_social_networks = array();

			foreach ($social_networks as $index => $social_network) {
				foreach ($social_network as $key => $value) {
					$sanitized_social_networks[$index][$key] = sanitize_text_field($value);
				}
			}

			return $sanitized_social_networks;
		}

		/**
		 * Add notice when settings are saved.
		 */
		public function notice()
		{
		?>
			<div id="setting-error-cre_settings_updated" class="updated notice is-dismissible">
				<p><strong><?php esc_html_e('Settings saved successfully!', 'crucial-real-estate'); ?></strong></p>
			</div>
<?php
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone()
		{
			_doing_it_wrong(__FUNCTION__, esc_html__('Cloning is forbidden!', 'crucial-real-estate'), CRE_VERSION);
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup()
		{
			_doing_it_wrong(__FUNCTION__, esc_html__('Unserializing is forbidden!', 'crucial-real-estate'), CRE_VERSION);
		}
	}

endif; // End if class_exists check.


/**
 * Main instance of Crucial_Real_Estate.
 *
 * Returns the main instance of Crucial_Real_Estate to prevent the need to use globals.
 *
 * @return Crucial_Real_Estate
 */
function ERR()
{
	return Crucial_Real_Estate::instance();
}

// Get ERR Running.
ERR();
