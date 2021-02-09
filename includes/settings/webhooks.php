<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$cre_forms_webhook_url                = $this->get_option('cre_forms_webhook_url');
$cre_contact_form_webhook_integration = isset($_POST['cre_contact_form_webhook_integration']) ? $_POST['cre_contact_form_webhook_integration'] : '0';
$cre_agent_form_webhook_integration   = isset($_POST['cre_agent_form_webhook_integration']) ? $_POST['cre_agent_form_webhook_integration'] : '0';
$cre_agency_form_webhook_integration  = isset($_POST['cre_agency_form_webhook_integration']) ? $_POST['cre_agency_form_webhook_integration'] : '0';
if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'aarambha_cre_settings')) {
    update_option('cre_forms_webhook_url', $cre_forms_webhook_url);
    update_option('cre_contact_form_webhook_integration', $cre_contact_form_webhook_integration);
    update_option('cre_agent_form_webhook_integration', $cre_agent_form_webhook_integration);
    update_option('cre_agency_form_webhook_integration', $cre_agency_form_webhook_integration);
    $this->notice();
}
?>
<div class="aarambha-cre-page-content">
    <div class="description">
        <p><?php esc_html_e('You can use the Webhooks settings below to feed forms data to services like Zapier. For example you can use Zapier Webhooks to create leads in Zoho CRM.', 'crucial-real-estate'); ?></p>
    </div>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="cre_forms_webhook_url"><?php esc_html_e('Webhook URL', 'crucial-real-estate'); ?></label></th>
                    <td><input name="cre_forms_webhook_url" type="text" id="cre_forms_webhook_url" value="<?php echo esc_url($cre_forms_webhook_url); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <label for="cre_contact_form_webhook_integration">
                            <input name="cre_contact_form_webhook_integration" type="checkbox" id="cre_contact_form_webhook_integration" value="1" <?php checked('1', get_option('cre_contact_form_webhook_integration', '0')); ?>>
                            <strong><?php esc_html_e('Integrate Contact Form', 'crucial-real-estate'); ?></strong>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <label for="cre_agent_form_webhook_integration">
                            <input name="cre_agent_form_webhook_integration" type="checkbox" id="cre_agent_form_webhook_integration" value="1" <?php checked('1', get_option('cre_agent_form_webhook_integration', '0')); ?>>
                            <strong><?php esc_html_e('Integrate Agent Form', 'crucial-real-estate'); ?></strong>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <label for="cre_agency_form_webhook_integration">
                            <input name="cre_agency_form_webhook_integration" type="checkbox" id="cre_agency_form_webhook_integration" value="1" <?php checked('1', get_option('cre_agency_form_webhook_integration', '0')); ?>>
                            <strong><?php esc_html_e('Integrate Agency Form', 'crucial-real-estate'); ?></strong>
                        </label>
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