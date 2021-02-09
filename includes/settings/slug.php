<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$aarambha_property_slug         = $this->get_option('aarambha_property_slug', esc_html__('property', 'crucial-real-estate'));
$aarambha_agent_slug            = $this->get_option('aarambha_agent_slug', esc_html__('agent', 'crucial-real-estate'));
$aarambha_agency_slug           = $this->get_option('aarambha_agency_slug', esc_html__('agency', 'crucial-real-estate'));
$aarambha_property_city_slug    = $this->get_option('aarambha_property_city_slug', esc_html__('property-location', 'crucial-real-estate'));
$aarambha_property_status_slug  = $this->get_option('aarambha_property_status_slug', esc_html__('property-status', 'crucial-real-estate'));
$aarambha_property_type_slug    = $this->get_option('aarambha_property_type_slug', esc_html__('property-type', 'crucial-real-estate'));
$aarambha_property_feature_slug = $this->get_option('aarambha_property_feature_slug', esc_html__('property-feature', 'crucial-real-estate'));

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'aarambha_cre_settings')) {
    update_option('aarambha_property_slug', $aarambha_property_slug);
    update_option('aarambha_agent_slug', $aarambha_agent_slug);
    update_option('aarambha_agency_slug', $aarambha_agency_slug);
    update_option('aarambha_property_city_slug', $aarambha_property_city_slug);
    update_option('aarambha_property_status_slug', $aarambha_property_status_slug);
    update_option('aarambha_property_type_slug', $aarambha_property_type_slug);
    update_option('aarambha_property_feature_slug', $aarambha_property_feature_slug);
    $this->notice();
}
?>
<div class="aarambha-cre-page-content">
    <h2 class="title"><?php esc_html_e('Important Note for URL Slugs', 'crucial-real-estate'); ?></h2>
    <div class="description">
        <p><?php esc_html_e('Make sure to re-save permalinks settings after every change in URL slugs to avoid 404 errors. You can do that from [ Settings > Permalinks ]', 'crucial-real-estate'); ?></p>
    </div>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="aarambha_property_slug"><?php esc_html_e('Property Slug', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_property_slug" type="text" id="aarambha_property_slug" value="<?php echo esc_attr($aarambha_property_slug); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_agent_slug"><?php esc_html_e('Agent Slug', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_agent_slug" type="text" id="aarambha_agent_slug" value="<?php echo esc_attr($aarambha_agent_slug); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_agency_slug"><?php esc_html_e('Agency Slug', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_agency_slug" type="text" id="aarambha_agency_slug" value="<?php echo esc_attr($aarambha_agency_slug); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_property_city_slug"><?php esc_html_e('Property Location Slug', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_property_city_slug" type="text" id="aarambha_property_city_slug" value="<?php echo esc_attr($aarambha_property_city_slug); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_property_status_slug"><?php esc_html_e('Property Status Slug', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_property_status_slug" type="text" id="aarambha_property_status_slug" value="<?php echo esc_attr($aarambha_property_status_slug); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_property_type_slug"><?php esc_html_e('Property Type Slug', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_property_type_slug" type="text" id="aarambha_property_type_slug" value="<?php echo esc_attr($aarambha_property_type_slug); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="aarambha_property_feature_slug"><?php esc_html_e('Property Feature Slug', 'crucial-real-estate'); ?></label></th>
                    <td><input name="aarambha_property_feature_slug" type="text" id="aarambha_property_feature_slug" value="<?php echo esc_attr($aarambha_property_feature_slug); ?>" class="regular-text code"></td>
                </tr>
            </tbody>
        </table>
        <div class="submit">
            <?php wp_nonce_field('aarambha_cre_settings'); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'crucial-real-estate'); ?>">
        </div>
    </form>
</div>