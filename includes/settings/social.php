<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

$theme_show_social_menu = $this->get_option('theme_show_social_menu', 'true');
$theme_facebook_link    = $this->get_option('theme_facebook_link');
$theme_twitter_link     = $this->get_option('theme_twitter_link');
$theme_linkedin_link    = $this->get_option('theme_linkedin_link');
$theme_instagram_link   = $this->get_option('theme_instagram_link');
$theme_youtube_link     = $this->get_option('theme_youtube_link');
$theme_pinterest_link   = $this->get_option('theme_pinterest_link');
$theme_rss_link         = $this->get_option('theme_rss_link');
$theme_skype_username   = $this->get_option('theme_skype_username');
$theme_line_id          = $this->get_option('theme_line_id');

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'aarambha_cre_settings')) {

	// Saving Crucial Real Estate Social Login Settings.
	if (isset($_POST['rsl_settings'])) {
		update_option('rsl_settings', $_POST['rsl_settings']);
	}

	// Saving Social Profiles Settings.
	update_option('theme_show_social_menu', $theme_show_social_menu);
	update_option('theme_facebook_link', $theme_facebook_link);
	update_option('theme_twitter_link', $theme_twitter_link);
	update_option('theme_linkedin_link', $theme_linkedin_link);
	update_option('theme_instagram_link', $theme_instagram_link);
	update_option('theme_youtube_link', $theme_youtube_link);
	update_option('theme_pinterest_link', $theme_pinterest_link);
	update_option('theme_rss_link', $theme_rss_link);
	update_option('theme_skype_username', $theme_skype_username);
	update_option('theme_line_id', $theme_line_id);

	// Additional social networks
	if (isset($_POST['aarambha_cre_social_networks']) && !empty($_POST['aarambha_cre_social_networks'])) {

		$additional_social_networks = $_POST['aarambha_cre_social_networks'];
		if (is_array($additional_social_networks)) {
			foreach ($additional_social_networks as $social_network => $values) {
				$r = array_filter($values, 'strlen');
				if (empty($r)) {
					unset($additional_social_networks[$social_network]);
				}
			}

			$additional_social_networks = $this->sanitize_social_networks($additional_social_networks);
			update_option('theme_social_networks', $additional_social_networks);
		}
	} else {
		delete_option('theme_social_networks');
	}

	$this->notice();
}
?>
<div class="aarambha-cre-page-content">
	<form method="post" action="" novalidate="novalidate">
		<table id="aarambha-cre-social-networks-table" class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e('Show or Hide Social Icons', 'crucial-real-estate'); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span><?php esc_html_e('Show or Hide Social Icons', 'crucial-real-estate'); ?></span>
							</legend>
							<label>
								<input type="radio" name="theme_show_social_menu" value="true" <?php checked($theme_show_social_menu, 'true') ?>>
								<span><?php esc_html_e('Show', 'crucial-real-estate'); ?></span>
							</label>
							<br>
							<label>
								<input type="radio" name="theme_show_social_menu" value="false" <?php checked($theme_show_social_menu, 'false') ?>>
								<span><?php esc_html_e('Hide', 'crucial-real-estate'); ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="theme_facebook_link"><?php esc_html_e('Facebook URL', 'crucial-real-estate'); ?></label>
					</th>
					<td><input name="theme_facebook_link" type="url" id="theme_facebook_link" value="<?php echo esc_url($theme_facebook_link); ?>" class="regular-text code"></td>
				</tr>
				<tr>
					<th scope="row"><label for="theme_twitter_link"><?php esc_html_e('Twitter URL', 'crucial-real-estate'); ?></label>
					</th>
					<td><input name="theme_twitter_link" type="url" id="theme_twitter_link" value="<?php echo esc_url($theme_twitter_link); ?>" class="regular-text code"></td>
				</tr>
				<tr>
					<th scope="row"><label for="theme_linkedin_link"><?php esc_html_e('Linkedin URL', 'crucial-real-estate'); ?></label>
					</th>
					<td><input name="theme_linkedin_link" type="url" id="theme_linkedin_link" value="<?php echo esc_url($theme_linkedin_link); ?>" class="regular-text code"></td>
				</tr>
				<tr>
					<th scope="row"><label for="theme_instagram_link"><?php esc_html_e('Instagram URL', 'crucial-real-estate'); ?></label></th>
					<td><input name="theme_instagram_link" type="url" id="theme_instagram_link" value="<?php echo esc_url($theme_instagram_link); ?>" class="regular-text code"></td>
				</tr>
				<tr>
					<th scope="row"><label for="theme_youtube_link"><?php esc_html_e('YouTube URL', 'crucial-real-estate'); ?></label></th>
					<td><input name="theme_youtube_link" type="url" id="theme_youtube_link" value="<?php echo esc_url($theme_youtube_link); ?>" class="regular-text code"></td>
				</tr>
				<tr>
					<th scope="row"><label for="theme_pinterest_link"><?php esc_html_e('Pinterest URL', 'crucial-real-estate'); ?></label></th>
					<td><input name="theme_pinterest_link" type="url" id="theme_pinterest_link" value="<?php echo esc_url($theme_pinterest_link); ?>" class="regular-text code"></td>
				</tr>
				<tr>
					<th scope="row"><label for="theme_rss_link"><?php esc_html_e('RSS URL', 'crucial-real-estate'); ?></label></th>
					<td><input name="theme_rss_link" type="url" id="theme_rss_link" value="<?php echo esc_url($theme_rss_link); ?>" class="regular-text code"></td>
				</tr>
				<tr>
					<th scope="row"><label for="theme_skype_username"><?php esc_html_e('Skype Username', 'crucial-real-estate'); ?></label></th>
					<td><input name="theme_skype_username" type="text" id="theme_skype_username" value="<?php echo esc_attr($theme_skype_username); ?>" class="regular-text code"></td>
				</tr>
				<tr>
					<th scope="row"><label for="Crucial Real Estate_line_link"><?php esc_html_e('LINE ID', 'crucial-real-estate'); ?></label></th>
					<td><input name="theme_line_id" type="url" id="theme_line_id" value="<?php echo esc_attr($theme_line_id); ?>" class="regular-text code"></td>
				</tr>
				<?php
				$theme_social_networks  = get_option('theme_social_networks', array());
				if (is_array($theme_social_networks) && !empty($theme_social_networks)) :
					foreach ($theme_social_networks as $i => $social_network) :
						$title = $social_network['title'];
						$url   = $social_network['url'];
						$icon  = $social_network['icon'];
				?>
						<tr class="aarambha-cre-sn-tr">
							<th scope="row">
								<label for="aarambha-cre-sn-title-<?php echo esc_attr($i); ?>" class="aarambha-cre-sn-title"><?php echo esc_html($title); ?></label>
								<label for="aarambha-cre-sn-title-<?php echo esc_attr($i); ?>" class="aarambha-cre-sn-field hide"><strong><?php esc_html_e('Title', 'crucial-real-estate'); ?></strong></label>
								<input type="text" id="aarambha-cre-sn-title-<?php echo esc_attr($i); ?>" name="aarambha_cre_social_networks[<?php echo esc_attr($i); ?>][title]" value="<?php echo esc_attr($title); ?>" class="aarambha-cre-sn-field hide code">
							</th>
							<td>
								<div>
									<label for="aarambha-cre-sn-url-<?php echo esc_attr($i); ?>" class="aarambha-cre-sn-field hide"><strong><?php esc_html_e('Profile URL', 'crucial-real-estate'); ?></strong></label>
									<input type="text" id="aarambha-cre-sn-url-<?php echo esc_attr($i); ?>" name="aarambha_cre_social_networks[<?php echo esc_attr($i); ?>][url]" value="<?php echo esc_attr($url); ?>" class="regular-text code">
								</div>
								<div>
									<label for="aarambha-cre-sn-icon-<?php echo esc_attr($i); ?>" class="aarambha-cre-sn-field hide"><strong><?php esc_html_e('Icon Class', 'crucial-real-estate'); ?></strong> <small>- <em><?php esc_html_e('Example: fa-flicker', 'crucial-real-estate'); ?></em></small></label>
									<input type="text" id="aarambha-cre-sn-icon-<?php echo esc_attr($i); ?>" name="aarambha_cre_social_networks[<?php echo esc_attr($i); ?>][icon]" value="<?php echo esc_attr($icon); ?>" class="aarambha-cre-sn-field  hide code">
									<div class="aarambha-cre-sn-actions">
										<a href="#" class="aarambha-cre-edit-sn"><?php esc_html_e('Edit', 'crucial-real-estate'); ?></a>
										<a href="#" class="aarambha-cre-update-sn hide"><?php esc_html_e('Ok', 'crucial-real-estate'); ?></a>
										-
										<a href="#" class="aarambha-cre-remove-sn"><?php esc_html_e('Remove', 'crucial-real-estate'); ?></a>
									</div>
								</div>
							</td>
						</tr>
				<?php
					endforeach;
				endif;
				?>
			</tbody>
			<tfoot>
				<tr>
					<th scope="row"></th>
					<td><a href="#" id="aarambha-cre-add-sn" class="aarambha-cre-add-sn"><?php esc_html_e('+ Add New Social Network', 'crucial-real-estate'); ?></a></p>
					</td>
				</tr>
			</tfoot>
		</table>

		<!-- Social Login Settings -->
		<hr>
		<table class="form-table">
			<?php $rsl_settings = get_option('rsl_settings'); ?>
			<tbody>

				<tr>
					<th>
						<h2><?php esc_html_e('Social Login Settings', 'crucial-real-estate'); ?></h2>
					</th>
				</tr>
				<tr>
					<th>
						<h3><?php esc_html_e('Facebook Login', 'crucial-real-estate'); ?></h3>
					</th>
				</tr>

				<!-- Enable Facebook -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Enable Facebook', 'crucial-real-estate'); ?>
					</th>
					<td>
						<?php
						$enable_social_login_facebook = !empty($rsl_settings['enable_social_login_facebook']) ? $rsl_settings['enable_social_login_facebook'] : '';
						?>
						<input id="rsl_settings[enable_social_login_facebook]" name="rsl_settings[enable_social_login_facebook]" type="checkbox" value="1" <?php checked(1, $enable_social_login_facebook); ?> />
						<label class="description" for="rsl_settings[enable_social_login_facebook]"><?php esc_html_e('Enable login/register with facebook on login forms.', 'crucial-real-estate'); ?></label>
					</td>
				</tr>

				<!-- Facebook App ID -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('App ID*', 'crucial-real-estate'); ?>
					</th>
					<td>
						<input id="rsl_settings[facebook_app_id]" name="rsl_settings[facebook_app_id]" type="text" class="regular-text" value="<?php echo esc_attr($rsl_settings['facebook_app_id']); ?>" />
						<p class="description"><label for="rsl_settings[facebook_app_id]"><?php echo sprintf(esc_html__('Learn how to get Facebook APP ID and Secret by %s.', 'crucial-real-estate'), '<a href="https://inspirythemes.com/Crucial Real Estate-social-login-setup/#facebook-login-setup" target="_blank">clicking here</a>'); ?></label></p>
					</td>
				</tr>

				<!-- Facebook App Secret -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('App Secret*', 'crucial-real-estate'); ?>
					</th>
					<td>
						<input id="rsl_settings[facebook_app_secret]" name="rsl_settings[facebook_app_secret]" type="text" class="regular-text" value="<?php echo esc_attr($rsl_settings['facebook_app_secret']); ?>" />
					</td>
				</tr>

				<tr>
					<th>
						<h3><?php esc_html_e('Google Login', 'crucial-real-estate'); ?></h3>
					</th>
				</tr>

				<!-- Enable Google -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Enable Google', 'crucial-real-estate'); ?>
					</th>
					<td>
						<?php
						$enable_social_login_google = !empty($rsl_settings['enable_social_login_google']) ? $rsl_settings['enable_social_login_google'] : '';
						?>
						<input id="rsl_settings[enable_social_login_google]" name="rsl_settings[enable_social_login_google]" type="checkbox" value="1" <?php checked(1, $enable_social_login_google); ?> />
						<label class="description" for="rsl_settings[enable_social_login_google]"><?php esc_html_e('Enable login/register with google on login forms.', 'crucial-real-estate'); ?></label>
					</td>
				</tr>

				<!-- Google API Key -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('API Key*', 'crucial-real-estate'); ?>
					</th>
					<td>
						<input id="rsl_settings[google_app_api_key]" name="rsl_settings[google_app_api_key]" type="text" class="regular-text" value="<?php echo esc_attr($rsl_settings['google_app_api_key']); ?>" />
						<p class="description"><label for="rsl_settings[google_app_api_key]"><?php echo sprintf(esc_html__('Learn how to get Google API Key, Client ID and Client Secret by %s.', 'crucial-real-estate'), '<a href="https://inspirythemes.com/Crucial Real Estate-social-login-setup/#google-login-setup" target="_blank">clicking here</a>'); ?></label></p>
					</td>
				</tr>

				<!-- Google Client ID -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Client ID*', 'crucial-real-estate'); ?>
					</th>
					<td>
						<input id="rsl_settings[google_app_client_id]" name="rsl_settings[google_app_client_id]" type="text" class="regular-text" value="<?php echo esc_attr($rsl_settings['google_app_client_id']); ?>" />
					</td>
				</tr>

				<!-- Google Client Secret -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Client Secret*', 'crucial-real-estate'); ?>
					</th>
					<td>
						<input id="rsl_settings[google_app_client_secret]" name="rsl_settings[google_app_client_secret]" type="text" class="regular-text" value="<?php echo esc_attr($rsl_settings['google_app_client_secret']); ?>" />
					</td>
				</tr>

				<tr>
					<th>
						<h3><?php esc_html_e('Twitter Login', 'crucial-real-estate'); ?></h3>
					</th>
				</tr>

				<!-- Enable Twitter -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Enable Twitter', 'crucial-real-estate'); ?>
					</th>
					<td>
						<?php
						$enable_social_login_twitter = !empty($rsl_settings['enable_social_login_twitter']) ? $rsl_settings['enable_social_login_twitter'] : '';
						?>
						<input id="rsl_settings[enable_social_login_twitter]" name="rsl_settings[enable_social_login_twitter]" type="checkbox" value="1" <?php checked(1, $enable_social_login_twitter); ?> />
						<label class="description" for="rsl_settings[enable_social_login_twitter]"><?php esc_html_e('Enable login/register with twitter on login forms.', 'crucial-real-estate'); ?></label>
					</td>
				</tr>

				<!-- Twitter App Consumer Key -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Consumer Key*', 'crucial-real-estate'); ?>
					</th>
					<td>
						<input id="rsl_settings[twitter_app_consumer_key]" name="rsl_settings[twitter_app_consumer_key]" type="text" class="regular-text" value="<?php echo esc_attr($rsl_settings['twitter_app_consumer_key']); ?>" />
						<p class="description"><label for="rsl_settings[twitter_app_consumer_key]"><?php echo sprintf(esc_html__('Learn how to get Twitter Consumer Key and Consumer Secret by %s.', 'crucial-real-estate'), '<a href="https://inspirythemes.com/Crucial Real Estate-social-login-setup/#twitter-login-setup" target="_blank">clicking here</a>'); ?></label></p>
					</td>
				</tr>

				<!-- Twitter App Consumer Secret -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Consumer Secret*', 'crucial-real-estate'); ?>
					</th>
					<td>
						<input id="rsl_settings[twitter_app_consumer_secret]" name="rsl_settings[twitter_app_consumer_secret]" type="text" class="regular-text" value="<?php echo esc_attr($rsl_settings['twitter_app_consumer_secret']); ?>" />
					</td>
				</tr>

			</tbody>
		</table>

		<div class="submit">
			<?php wp_nonce_field('aarambha_cre_settings'); ?>
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'crucial-real-estate'); ?>">
		</div>
	</form>
</div>