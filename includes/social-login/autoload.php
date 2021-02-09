<?php

/**
 * Load all required social login files and libraries.
 *
 * @since      0.5.3
 * @package    crucial-real-estate
 * @subpackage crucial-real-estate/includes/social-login
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

require_once CRE_PLUGIN_DIR . 'includes/social-login/helper-functions.php';

if (cre_is_social_login_enabled('facebook') || cre_is_social_login_enabled('google') || cre_is_social_login_enabled('twitter')) {
	require_once CRE_PLUGIN_DIR . 'includes/social-login/ajax-handler.php';
	require_once CRE_PLUGIN_DIR . 'includes/social-login/callbacks.php';
}
