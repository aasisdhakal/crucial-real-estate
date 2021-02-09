<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$theme_currency_sign     = $this->get_option('theme_currency_sign', '$');
$theme_currency_position = $this->get_option('theme_currency_position', 'before');
$theme_decimals          = $this->get_option('theme_decimals', '0');
$theme_dec_point         = $this->get_option('theme_dec_point', '.');
$theme_thousands_sep     = $this->get_option('theme_thousands_sep', ',');
$theme_no_price_text     = $this->get_option('theme_no_price_text');

if (isset($_POST['_wpnonce']) &&  wp_verify_nonce($_POST['_wpnonce'], 'aarambha_cre_settings')) {
    update_option('theme_currency_sign', $theme_currency_sign);
    update_option('theme_currency_position', $theme_currency_position);
    update_option('theme_decimals', $theme_decimals);
    update_option('theme_dec_point', $theme_dec_point);
    update_option('theme_thousands_sep', $theme_thousands_sep);
    update_option('theme_no_price_text', $theme_no_price_text);
    $this->notice();
}
?>
<div class="aarambha-cre-page-content">

    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="theme_currency_sign"><?php esc_html_e('Currency Sign', 'crucial-real-estate'); ?></label></th>
                    <td>
                        <input name="theme_currency_sign" type="text" id="theme_currency_sign" value="<?php echo esc_attr($theme_currency_sign); ?>" class="regular-text code">
                        <p class="description"><?php esc_html_e('Provide currency sign. For Example: $', 'crucial-real-estate'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Position of Currency Sign', 'crucial-real-estate'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Position of Currency Sign', 'crucial-real-estate'); ?></span></legend>
                            <label>
                                <input type="radio" name="theme_currency_position" value="before" <?php checked($theme_currency_position, 'before') ?>>
                                <span><?php esc_html_e('Before the numbers', 'crucial-real-estate'); ?></span>
                            </label>
                            <br>
                            <label>
                                <input type="radio" name="theme_currency_position" value="after" <?php checked($theme_currency_position, 'after') ?>>
                                <span><?php esc_html_e('After the numbers', 'crucial-real-estate'); ?></span>
                            </label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="theme_decimals"><?php esc_html_e('Number of Decimals Points', 'crucial-real-estate'); ?></label></th>
                    <td>
                        <select name="theme_decimals" id="theme_decimals">
                            <option value="0" <?php selected($theme_decimals, '0'); ?>><?php esc_html_e('0', 'crucial-real-estate'); ?></option>
                            <option value="1" <?php selected($theme_decimals, '1'); ?>><?php esc_html_e('1', 'crucial-real-estate'); ?></option>
                            <option value="2" <?php selected($theme_decimals, '2'); ?>><?php esc_html_e('2', 'crucial-real-estate'); ?></option>
                            <option value="3" <?php selected($theme_decimals, '3'); ?>><?php esc_html_e('3', 'crucial-real-estate'); ?></option>
                            <option value="4" <?php selected($theme_decimals, '4'); ?>><?php esc_html_e('4', 'crucial-real-estate'); ?></option>
                            <option value="5" <?php selected($theme_decimals, '5'); ?>><?php esc_html_e('5', 'crucial-real-estate'); ?></option>
                            <option value="6" <?php selected($theme_decimals, '6'); ?>><?php esc_html_e('6', 'crucial-real-estate'); ?></option>
                            <option value="7" <?php selected($theme_decimals, '7'); ?>><?php esc_html_e('7', 'crucial-real-estate'); ?></option>
                            <option value="8" <?php selected($theme_decimals, '8'); ?>><?php esc_html_e('8', 'crucial-real-estate'); ?></option>
                            <option value="9" <?php selected($theme_decimals, '9'); ?>><?php esc_html_e('9', 'crucial-real-estate'); ?></option>
                            <option value="10" <?php selected($theme_decimals, '10'); ?>><?php esc_html_e('10', 'crucial-real-estate'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="theme_dec_point"><?php esc_html_e('Decimal Point Separator', 'crucial-real-estate'); ?></label></th>
                    <td><input name="theme_dec_point" type="text" id="theme_dec_point" value="<?php echo esc_attr($theme_dec_point); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="theme_thousands_sep"><?php esc_html_e('Thousands Separator', 'crucial-real-estate'); ?></label></th>
                    <td><input name="theme_thousands_sep" type="text" id="theme_thousands_sep" value="<?php echo esc_attr($theme_thousands_sep); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="theme_no_price_text"><?php esc_html_e('Empty Price Text', 'crucial-real-estate'); ?></label></th>
                    <td>
                        <input name="theme_no_price_text" type="text" id="theme_no_price_text" value="<?php echo esc_attr($theme_no_price_text); ?>" class="regular-text code">
                        <p class="description"><?php esc_html_e('Text to display when no price is provided.', 'crucial-real-estate'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="submit">
            <?php wp_nonce_field('aarambha_cre_settings'); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'crucial-real-estate'); ?>">
            <p><?php esc_html_e('Note: If you have enabled Crucial Real Estate Currency Switcher then default format of selected base currency will override above settings.', 'crucial-real-estate'); ?></p>
        </div>
    </form>
</div>