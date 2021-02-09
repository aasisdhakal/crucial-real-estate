<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$theme_show_reCAPTCHA        = $this->get_option('theme_show_reCAPTCHA', 'false');
$theme_recaptcha_public_key  = $this->get_option('theme_recaptcha_public_key');
$theme_recaptcha_private_key = $this->get_option('theme_recaptcha_private_key');
$theme_recaptcha_type        = $this->get_option('aarambha_reCAPTCHA_type', 'v2');

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'aarambha_cre_settings')) {
    update_option('theme_show_reCAPTCHA', $theme_show_reCAPTCHA);
    update_option('theme_recaptcha_public_key', $theme_recaptcha_public_key);
    update_option('theme_recaptcha_private_key', $theme_recaptcha_private_key);
    update_option('aarambha_reCAPTCHA_type', $theme_recaptcha_type);
    $this->notice();
}
?>
<div class="aarambha-cre-page-content">
    <div class="description">
        <p><?php esc_html_e('For spam protection on agent and contact forms!', 'crucial-real-estate'); ?></p>
    </div>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php esc_html_e('Google reCAPTCHA', 'crucial-real-estate'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php esc_html_e('Google reCAPTCHA', 'crucial-real-estate'); ?></span></legend>
                            <label>
                                <input type="radio" name="theme_show_reCAPTCHA" value="true" <?php checked($theme_show_reCAPTCHA, 'true') ?>>
                                <span><?php esc_html_e('Enable', 'crucial-real-estate'); ?></span>
                            </label>
                            <br>
                            <label>
                                <input type="radio" name="theme_show_reCAPTCHA" value="false" <?php checked($theme_show_reCAPTCHA, 'false') ?>>
                                <span><?php esc_html_e('Disable', 'crucial-real-estate'); ?></span>
                            </label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Google reCAPTCHA Type', 'crucial-real-estate'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php esc_html_e('Google reCAPTCHA Type', 'crucial-real-estate'); ?></span></legend>
                            <label>
                                <input type="radio" name="aarambha_reCAPTCHA_type" value="v2" <?php checked($theme_recaptcha_type, 'v2') ?>>
                                <span><?php esc_html_e('V2', 'crucial-real-estate'); ?></span>
                            </label>
                            <br>
                            <label>
                                <input type="radio" name="aarambha_reCAPTCHA_type" value="v3" <?php checked($theme_recaptcha_type, 'v3') ?>>
                                <span><?php esc_html_e('V3', 'crucial-real-estate'); ?></span>
                            </label>
                        </fieldset>
                        <p class="description"><?php esc_html_e('Get new keys for V3 as V2 keys will not work!', 'crucial-real-estate'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="theme_recaptcha_public_key"><?php esc_html_e('Site Key', 'crucial-real-estate'); ?></label></th>
                    <td>
                        <input name="theme_recaptcha_public_key" type="text" id="theme_recaptcha_public_key" value="<?php echo esc_attr($theme_recaptcha_public_key); ?>" class="regular-text code">
                        <p class="description"><?php printf(esc_html__('You can get new keys for your website by %s signing in here %s', 'crucial-real-estate'), '<a href="https://www.google.com/recaptcha/admin#whyrecaptcha" target="_blank">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="theme_recaptcha_public_key"><?php esc_html_e('Secret Key', 'crucial-real-estate'); ?></label></th>
                    <td><input name="theme_recaptcha_private_key" type="text" id="theme_recaptcha_private_key" value="<?php echo esc_attr($theme_recaptcha_private_key); ?>" class="regular-text code"></td>
                </tr>
            </tbody>
        </table>
        <div class="submit">
            <?php wp_nonce_field('aarambha_cre_settings'); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'crucial-real-estate'); ?>">
        </div>
    </form>
</div>