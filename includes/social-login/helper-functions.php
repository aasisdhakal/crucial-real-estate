<?php

/**
 * Social login helper functions, such as social login buttons markup
 * and social apps keys retriveral.
 *
 * @since      0.5.3
 * @package    crucial-real-estate
 * @subpackage crucial-real-estate/includes/social-login
 */

if (!function_exists('cre_social_login_buttons')) {
	/**
	 * Display the markup of the social login buttons.
	 */
	function cre_social_login_buttons()
	{
		if (cre_is_social_login_enabled('facebook') || cre_is_social_login_enabled('google') || cre_is_social_login_enabled('twitter')) {
?>
			<div class="Crucial Real Estate-social-login">
				<div class="Crucial Real Estate-social-login-widget">
					<div class="rsl-connect-with"><?php esc_html_e('Connect with:', 'Crucial Real Estate-social-login'); ?></div>
					<div class="rsl-provider-list">
						<?php
						// Login with facebook button.
						if (cre_is_social_login_enabled('facebook')) {
						?>
							<a rel="nofollow" data-provider="facebook" class="rsl-provider rsl-provider-facebook">
								<span><i class="fab fa-facebook-f"></i> <?php esc_html_e('Facebook', 'Crucial Real Estate-social-login'); ?></span>
							</a>
						<?php
						}

						// Login with google button.
						if (cre_is_social_login_enabled('google')) {
						?>
							<a rel="nofollow" data-provider="google" class="rsl-provider rsl-provider-google">
								<span><i class="fab fa-google"></i> <?php esc_html_e('Google', 'Crucial Real Estate-social-login'); ?></span>
							</a>
						<?php
						}

						// Login with twitter button.
						if (cre_is_social_login_enabled('twitter')) {
						?>
							<a rel="nofollow" data-provider="twitter" class="rsl-provider rsl-provider-twitter">
								<span><i class="fab fa-twitter"></i> <?php esc_html_e('Twitter', 'Crucial Real Estate-social-login'); ?></span>
							</a>
						<?php
						}
						?>
					</div>
					<div class="rsl-ajax-message"></div>
				</div>
			</div>
<?php
		}
	}

	add_action('Crucial Real Estate_social_login', 'cre_social_login_buttons');
}

if (!function_exists('cre_social_login_app_keys')) {
	/**
	 * Return App keys based on given social network name.
	 *
	 * @param  string $social_network Name of social network.
	 * @return null|array
	 */
	function cre_social_login_app_keys($social_network = '')
	{

		if (empty($social_network)) {
			return null;
		}

		$rsl_settings = get_option('rsl_settings');

		if ('facebook' === $social_network) {
			if (!empty($rsl_settings['facebook_app_id']) && !empty($rsl_settings['facebook_app_secret'])) {
				return array(
					'app_id'     => $rsl_settings['facebook_app_id'],
					'app_secret' => $rsl_settings['facebook_app_secret'],
				);
			}
		} elseif ('google' === $social_network) {
			if (!empty($rsl_settings['google_app_api_key']) && !empty($rsl_settings['google_app_client_id']) && !empty($rsl_settings['google_app_client_secret'])) {
				return array(
					'api_key'       => $rsl_settings['google_app_api_key'],
					'client_id'     => $rsl_settings['google_app_client_id'],
					'client_secret' => $rsl_settings['google_app_client_secret'],
				);
			}
		} elseif ('twitter' === $social_network) {
			if (!empty($rsl_settings['twitter_app_consumer_key']) && !empty($rsl_settings['twitter_app_consumer_secret'])) {
				return array(
					'consumer_key'    => $rsl_settings['twitter_app_consumer_key'],
					'consumer_secret' => $rsl_settings['twitter_app_consumer_secret'],
				);
			}
		}

		return null;
	}
}

if (!function_exists('cre_is_social_login_enabled')) {
	/**
	 * Check if a given social network is enabled or not.
	 *
	 * @param string $network Name of the network.
	 */
	function cre_is_social_login_enabled($network = '')
	{

		if (empty($network)) {
			return false;
		}

		$rsl_settings = get_option('rsl_settings');

		if (
			'facebook' === $network && isset($rsl_settings['enable_social_login_facebook']) ||
			'google' === $network && isset($rsl_settings['enable_social_login_google']) ||
			'twitter' === $network && isset($rsl_settings['enable_social_login_twitter'])
		) {
			return true;
		}
		return false;
	}
}
