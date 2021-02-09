<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}
?>
<div class="wrap">
	<h1 class="screen-reader-text"><?php esc_html_e('Crucial Real Estate', 'crucial-real-estate'); ?></h1>
	<div class="aarambha-cre-page">
		<header class="aarambha-cre-page-header">
			<h2 class="title"><span class="theme-title"><?php esc_html_e('Crucial Real Estate', 'crucial-real-estate'); ?></span></h2>
			<!-- <p class="credit">
				<a class="aarambha-cre-logo-wrap" href="<?php echo esc_url('https://themeforest.net/user/inspirythemes/portfolio?order_by=sales'); ?>" target="_blank">
					<img src="<?php echo CRE_PLUGIN_URL . '/images/logo.png'; ?>" alt=""><?php esc_html_e('Inspiry Themes', 'crucial-real-estate'); ?>
				</a>
			</p> -->
		</header>
		<?php
		if (!current_user_can('manage_options')) {
			wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'crucial-real-estate'));
		}

		$current_tab = 'price';
		if (isset($_GET['tab']) && array_key_exists($_GET['tab'], $this->tabs())) {
			$current_tab = $_GET['tab'];
		}

		$this->tabs_nav($current_tab);

		if (file_exists(CRE_PLUGIN_DIR . 'includes/settings/' . $current_tab . '.php')) {
			require_once CRE_PLUGIN_DIR . 'includes/settings/' . $current_tab . '.php';
		}
		?>
		<footer class="aarambha-cre-page-footer">
			<p><?php printf(esc_html__('Version  %s', 'crucial-real-estate'), esc_html($this->version)); ?></p>
		</footer>
	</div><!-- /.aarambha-cre-page -->
</div><!-- /.wrap -->