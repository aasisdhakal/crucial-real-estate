<?php

/**
 * Social login callbacks catcher functions.
 * These functions also manage user registeration and sign-in.
 *
 * @since      0.5.3
 * @package    crucial-real-estate
 * @subpackage crucial-real-estate/includes/social-login
 */

if (cre_is_social_login_enabled('facebook') && (isset($_GET['code']) && isset($_GET['state']))) {
	add_action('init', 'cre_facebook_oauth_login');
} elseif (cre_is_social_login_enabled('google') && isset($_GET['code'])) {
	add_action('init', 'cre_google_oauth_login');
} elseif (cre_is_social_login_enabled('twitter') && isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
	add_action('init', 'cre_twitter_oauth_login');
}

if (!function_exists('cre_facebook_oauth_login')) {
	/**
	 * Facebook profile login.
	 */
	function cre_facebook_oauth_login()
	{

		// Facebook library.
		require_once CRE_PLUGIN_DIR . 'includes/social-login/libs/facebook/autoload.php';

		if (class_exists('Facebook\Facebook') && null !== cre_social_login_app_keys('facebook')) {

			$fb_app_keys = cre_social_login_app_keys('facebook');
			$fb_args     = array(
				'app_id'                => $fb_app_keys['app_id'],
				'app_secret'            => $fb_app_keys['app_secret'],
				'default_graph_version' => 'v2.10',
			);

			$fb = new Facebook\Facebook($fb_args);

			$helper = $fb->getRedirectLoginHelper();

			if (isset($_GET['state'])) {
				$helper->getPersistentDataHandler()->set('state', $_GET['state']);
			}

			try {
				$access_token_obj = $helper->getAccessToken();
			} catch (Facebook\Exception\ResponseException $e) {
				// When Graph returns an error.
				echo esc_html__('Graph returned an error: ', 'Crucial Real Estate-social-login') . esc_html($e->getMessage());
				exit;
			} catch (Facebook\Exception\SDKException $e) {
				// When validation fails or other local issues.
				echo esc_html__('Facebook SDK returned an error: ', 'Crucial Real Estate-social-login') . esc_html($e->getMessage());
				exit;
			}

			if (!isset($access_token_obj)) {
				if ($helper->getError()) {
					header('HTTP/1.0 401 Unauthorized');
					echo esc_html__('Error: ', 'Crucial Real Estate-social-login') . esc_html($helper->getError()) . '\n';
					echo esc_html__('Error Code: ', 'Crucial Real Estate-social-login') . esc_html($helper->getErrorCode()) . '\n';
					echo esc_html__('Error Reason: ', 'Crucial Real Estate-social-login') . esc_html($helper->getErrorReason()) . '\n';
					echo esc_html__('Error Description: ', 'Crucial Real Estate-social-login') . esc_html($helper->getErrorDescription()) . '\n';
				} else {
					header('HTTP/1.0 400 Bad Request');
					esc_html_e('Bad request', 'Crucial Real Estate-social-login');
				}
				exit;
			}

			$access_token = (string) $access_token_obj->getValue();

			$fb = new Facebook\Facebook(
				array(
					'app_id'                => esc_html($fb_app_keys['app_id']),
					'app_secret'            => esc_html($fb_app_keys['app_secret']),
					'default_graph_version' => 'v2.10',
					'default_access_token'  => $access_token,
				)
			);

			try {
				// Returns a `Facebook\Response` object.
				$response = $fb->get('/me?fields=id,email,name,first_name,last_name');
			} catch (Facebook\Exception\ResponseException $e) {
				echo esc_html__('Graph returned an error: ', 'Crucial Real Estate-social-login') . esc_html($e->getMessage());
				exit;
			} catch (Facebook\Exception\SDKException $e) {
				echo esc_html__('Facebook SDK returned an error: ', 'Crucial Real Estate-social-login') . esc_html($e->getMessage());
				exit;
			}

			$user = $response->getGraphUser();

			$register_cred['user_email']    = $user['email'];
			$register_cred['user_login']    = explode('@', $user['email']);
			$register_cred['user_login']    = $register_cred['user_login'][0];
			$register_cred['display_name']  = $user['name'];
			$register_cred['first_name']    = $user['first_name'];
			$register_cred['last_name']     = $user['last_name'];
			$register_cred['profile_image'] = 'https://graph.facebook.com/' . $user['id'] . '/picture?width=300&height=300';
			$register_cred['user_pass']     = $user['id'];

			// Register the user, if succcessfull then login the user.
			cre_social_register($register_cred);
		}
	}
}

if (!function_exists('cre_google_oauth_login')) {
	/**
	 * Google oauth login.
	 */
	function cre_google_oauth_login()
	{

		// Google Client and Oauth libraries.
		require_once CRE_PLUGIN_DIR . 'includes/social-login/libs/google/Google_Client.php';
		require_once CRE_PLUGIN_DIR . 'includes/social-login/libs/google/contrib/Google_Oauth2Service.php';

		if (class_exists('Google_Client') && class_exists('Google_Oauth2Service') && null !== cre_social_login_app_keys('google')) {

			$google_app_creds     = cre_social_login_app_keys('google');
			$google_client_id     = $google_app_creds['client_id'];
			$google_client_secret = $google_app_creds['client_secret'];
			$google_developer_key = $google_app_creds['api_key'];
			$google_redirect_url  = home_url();

			$google_client = new Google_Client();
			$google_client->setApplicationName(esc_html__('Login to', 'Crucial Real Estate-social-login') . get_bloginfo('name'));
			$google_client->setClientId($google_client_id);
			$google_client->setClientSecret($google_client_secret);
			$google_client->setDeveloperKey($google_developer_key);
			$google_client->setRedirectUri($google_redirect_url);
			$google_client->setScopes(array('email', 'profile'));

			$google_oauth_v2 = new Google_Oauth2Service($google_client);
			$code            = sanitize_text_field(wp_unslash($_GET['code']));
			$google_client->authenticate($code);

			if ($google_client->getAccessToken()) {

				$user = $google_oauth_v2->userinfo->get();

				$register_cred['user_email']    = $user['email'];
				$register_cred['user_login']    = explode('@', $user['email']);
				$register_cred['user_login']    = $register_cred['user_login'][0];
				$register_cred['display_name']  = $user['name'];
				$register_cred['first_name']    = isset($user['given_name']) ? $user['given_name'] : '';
				$register_cred['last_name']     = isset($user['family_name']) ? $user['family_name'] : '';
				$register_cred['profile_image'] = $user['picture'];
				$register_cred['user_pass']     = $user['id'];

				// Register the user, if succcessfull then login the user.
				cre_social_register($register_cred);
			}
		}
	}
}

if (!function_exists('cre_twitter_oauth_login')) {
	/**
	 * Twitter oauth login.
	 */
	function cre_twitter_oauth_login()
	{

		// Twitter library.
		require_once CRE_PLUGIN_DIR . 'includes/social-login/libs/twitter/autoload.php';

		if (class_exists('Abraham\TwitterOAuth\TwitterOAuth') && null !== cre_social_login_app_keys('twitter')) {

			$twitter_app_keys = cre_social_login_app_keys('twitter');
			$consumer_key     = $twitter_app_keys['consumer_key'];
			$consumer_secret  = $twitter_app_keys['consumer_secret'];

			$connection    = new Abraham\TwitterOAuth\TwitterOAuth($consumer_key, $consumer_secret);
			$request_token = $connection->oauth('oauth/access_token', array('oauth_consumer_key' => $consumer_key, 'oauth_token' => $_GET['oauth_token'], 'oauth_verifier' => $_GET['oauth_verifier']));

			$connection = new Abraham\TwitterOAuth\TwitterOAuth($consumer_key, $consumer_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);
			$user       = (array) $connection->get('account/verify_credentials', array('include_email' => 'true'));

			$register_cred['user_email']    = $user['email'];
			$register_cred['user_login']    = explode('@', $user['email']);
			$register_cred['user_login']    = $register_cred['user_login'][0];
			$register_cred['display_name']  = $user['name'];
			$register_cred['first_name']    = explode(' ', $user['name']);
			$register_cred['last_name']     = isset($register_cred['first_name'][1]) ? $register_cred['first_name'][1] : '';
			$register_cred['first_name']    = $register_cred['first_name'][0];
			$register_cred['profile_image'] = str_replace('_normal', '_400x400', $user['profile_image_url_https']);
			$register_cred['user_pass']     = $user['id'];

			// Register the user, if succcessfull then login the user.
			cre_social_register($register_cred);
		}
	}
}

if (!function_exists('cre_social_login')) {
	/**
	 * Logging in with the social profile credentials.
	 *
	 * @param array $login_creds Login credentials.
	 */
	function cre_social_login($login_creds)
	{

		$user_signon = wp_signon($login_creds, true);

		if (is_wp_error($user_signon)) {
			wp_safe_redirect(home_url());
		} else {
			cre_social_login_redirect(); // Redirect the user to the edit profile page.
		}
		exit;
	}
}

if (!function_exists('cre_social_register')) {
	/**
	 * User registeration with social profile information.
	 *
	 * @param array $register_cred User registeration credentials.
	 */
	function cre_social_register($register_cred)
	{

		/**
		 * Check for the existing user against given email.
		 * If user exists then set it as current user.
		 */
		$existing_user = get_user_by('email', $register_cred['user_email']);
		if ($existing_user) {
			wp_clear_auth_cookie();
			wp_set_current_user($existing_user->ID);
			wp_set_auth_cookie($existing_user->ID);
			cre_social_login_redirect(); // Redirect the user to the edit profile page.
			exit;
		}

		/*
		* Register the user if username doesn't exist already.
		* Otherwise add a random string as suffix and register again.
		*/
		if (username_exists($register_cred['user_login'])) {
			$register_cred['user_login'] = $register_cred['user_login'] . '_' . wp_rand(100, 10000);
		}
		$user_id = wp_insert_user($register_cred);

		if (!is_wp_error($user_id)) {

			$profile_image_id = cre_insert_social_profile_image($register_cred['profile_image'], $register_cred['user_login'] . wp_rand(100, 1000) . '.png');
			update_user_meta($user_id, 'profile_image_id', $profile_image_id);

			// User notification function exists in plugin.
			if (class_exists('Crucial_Real_Estate')) {
				// Send email notification to newly registered user and admin.
				cre_new_user_notification($user_id, $register_cred['user_pass']);
			}

			// Login the user.
			$login_creds['user_login']    = $register_cred['user_login'];
			$login_creds['user_password'] = $register_cred['user_pass'];
			cre_social_login($login_creds);
		}

		wp_safe_redirect(home_url());
	}
}

if (!function_exists('cre_social_login_redirect')) {
	/**
	 * Redirect user to edit profile page if avaiable, otherwise to homepage.
	 */
	function cre_social_login_redirect()
	{
		$edit_profile_page_url = aarambha_get_edit_profile_url();
		if ($edit_profile_page_url) {
			wp_safe_redirect($edit_profile_page_url);
		} else {
			wp_safe_redirect(home_url());
		}
	}
}

if (!function_exists('cre_insert_social_profile_image')) {
	/**
	 * Insert an image to the WordPress library from given image url.
	 *
	 * @param  string $image_url URL of the image that needs to be inserted.
	 * @param  string $filename The name of image file.
	 * @return int    $attached_id ID of the image that has been inserted.
	 */
	function cre_insert_social_profile_image($image_url, $filename = '')
	{

		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);

		if (empty($filename)) {
			$filename = basename($image_url);
		}

		if (wp_mkdir_p($upload_dir['path'])) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}

		file_put_contents($file, $image_data);

		// $wp_filetype = wp_check_filetype( $filename, null );
		$wp_filetype['type'] = 'image/png';

		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name($filename),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		$attach_id = wp_insert_attachment($attachment, $file);
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		wp_update_attachment_metadata($attach_id, $attach_data);
		return $attach_id;
	}
}
