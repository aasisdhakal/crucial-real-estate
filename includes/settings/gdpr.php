<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$aarambha_gdpr                 = $this->get_option('aarambha_gdpr', '0');
$aarambha_gdpr_label           = $this->get_option('aarambha_gdpr_label', esc_html__('GDPR Agreement', 'crucial-real-estate'));
$aarambha_gdpr_text            = $this->get_option('aarambha_gdpr_text', esc_html__('I consent to having this website store my submitted information so they can respond to my inquiry.', 'crucial-real-estate'), 'textarea');
$aarambha_gdpr_validation_text = $this->get_option('aarambha_gdpr_validation_text', esc_html__('* Please accept GDPR agreement', 'crucial-real-estate'));
$aarambha_gdpr_in_email        = $this->get_option('aarambha_gdpr_in_email', '0');

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'aarambha_cre_settings')) {
    update_option('aarambha_gdpr', $aarambha_gdpr);
    update_option('aarambha_gdpr_label', $aarambha_gdpr_label);
    update_option('aarambha_gdpr_text', $aarambha_gdpr_text);
    update_option('aarambha_gdpr_validation_text', $aarambha_gdpr_validation_text);
    update_option('aarambha_gdpr_in_email', $aarambha_gdpr_in_email);
    $this->notice();
}
?>
<div class="aarambha-cre-page-content">
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php esc_html_e('Add GDPR agreement checkbox in forms across website?', 'crucial-real-estate'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Add GDPR agreement checkbox in forms across website?', 'crucial-real-estate'); ?></span></legend>
                            <label>
                                <input type="radio" name="aarambha_gdpr" value="1" <?php checked($aarambha_gdpr, '1') ?>>
                                <span><?php esc_html_e('Yes', 'crucial-real-estate'); ?></span>
                            </label>
                            <br>
                            <label>
                                <input type="radio" name="aarambha_gdpr" value="0" <?php checked($aarambha_gdpr, '0') ?>>
                                <span><?php esc_html_e('No', 'crucial-real-estate'); ?></span>
                            </label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_gdpr_label"><?php esc_html_e('GDPR agreement checkbox label', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_gdpr_label" type="text" id="aarambha_gdpr_label" value="<?php echo esc_attr($aarambha_gdpr_label); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_gdpr_text"><?php esc_html_e('GDPR agreement checkbox text', 'crucial-real-estate'); ?></label></th>
                    <td><textarea name="aarambha_gdpr_text" rows="6" cols="40" id="aarambha_gdpr_text" class="code"><?php
                                                                                                                    echo wp_kses($aarambha_gdpr_text, array(
                                                                                                                        'a' => array(
                                                                                                                            'class'  => array(),
                                                                                                                            'href'   => array(),
                                                                                                                            'target' => array(),
                                                                                                                            'title'  => array()
                                                                                                                        ),
                                                                                                                        'br' => array(),
                                                                                                                        'em' => array(),
                                                                                                                        'strong' => array(),
                                                                                                                    ));
                                                                                                                    ?></textarea>
                        <p class="description"><?php esc_html_e('You can use <a>,<br>,<em> and <strong> tags in your GDPR agreement text.', 'crucial-real-estate'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_gdpr_validation_text"><?php esc_html_e('GDPR agreement checkbox validation message', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_gdpr_validation_text" type="text" id="aarambha_gdpr_validation_text" value="<?php echo esc_attr($aarambha_gdpr_validation_text); ?>" class="regular-text code"></td>
                </tr>
                <th scope="row"><?php esc_html_e('Add GDPR detail in resulting email?', 'crucial-real-estate'); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php esc_html_e('Add GDPR detail in resulting email?', 'crucial-real-estate'); ?></span></legend>
                        <label>
                            <input type="radio" name="aarambha_gdpr_in_email" value="1" <?php checked($aarambha_gdpr_in_email, '1') ?>>
                            <span><?php esc_html_e('Yes', 'crucial-real-estate'); ?></span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="aarambha_gdpr_in_email" value="0" <?php checked($aarambha_gdpr_in_email, '0') ?>>
                            <span><?php esc_html_e('No', 'crucial-real-estate'); ?></span>
                        </label>
                    </fieldset>
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