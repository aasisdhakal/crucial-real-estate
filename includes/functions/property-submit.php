<?php

/**
 * Property Submit Functions
 */
if (!function_exists('cre_guest_property_submission')) {
	/**
	 * Returns guest property submission customizer settings value.
	 *
	 * @return bool
	 * @since 0.5.1
	 */
	function cre_guest_property_submission()
	{

		if ('true' === get_option('aarambha_guest_submission', 'false')) {
			return true;
		}

		return false;
	}
}

if (!function_exists('cre_submit_notice')) {
	/**
	 * Property Submit Notice Email
	 *
	 * @param $property_id
	 */
	function cre_submit_notice($property_id)
	{

		/* get and sanitize target email */
		$target_email = sanitize_email(get_option('theme_submit_notice_email'));
		$target_email = is_email($target_email);
		if ($target_email) {

			/* current user ( submitter ) information */
			$current_user = wp_get_current_user();
			$submitter_name = $current_user->display_name;
			$submitter_email = $current_user->user_email;
			$site_name = get_bloginfo('name');

			/* email subject */
			if (cre_guest_property_submission()) {
				$email_subject = sprintf(esc_html__('A new property is submitted at %s', 'crucial-real-estate'), $site_name);
			} else {
				$email_subject = sprintf(esc_html__('A new property is submitted by %s at %s', 'crucial-real-estate'), $submitter_name, $site_name);
			}

			/* start of email body */
			$email_body = array();

			if (cre_guest_property_submission()) {
				$email_body[] = array(
					'name'  => '',
					'value' => esc_html__('A new property is submitted', 'crucial-real-estate'),
				);
			} else {
				$email_body[] = array(
					'name'  => '',
					'value' => sprintf(esc_html__('A new property is submitted by %s', 'crucial-real-estate'), $submitter_name),
				);
			}

			/* preview link */
			$preview_link = set_url_scheme(get_permalink($property_id));
			$preview_link = esc_url(apply_filters('preview_post_link', add_query_arg('preview', 'true', $preview_link)));
			if (!empty($preview_link)) {
				$email_body[] = array(
					'name'  => esc_html__('Property Preview Link', 'crucial-real-estate'),
					'value' => '<a target="_blank" href="' . $preview_link . '">' . sanitize_text_field($_POST['aarambha_property_title']) . '</a>',
				);
			}

			/* message to reviewer */
			if (isset($_POST['message_to_reviewer'])) {
				$message_to_reviewer = stripslashes($_POST['message_to_reviewer']);
				if (!empty($message_to_reviewer)) {
					$email_body[] = array(
						'name'  => esc_html__('Message to the Reviewer', 'crucial-real-estate'),
						'value' => $message_to_reviewer,
					);
				}
			}

			/* end of message body */
			$email_body[] = array(
				'name'  => esc_html__('Submitter Email', 'crucial-real-estate'),
				'value' => $submitter_email,
			);

			$email_body = cre_email_template($email_body, 'property_submit_form');

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();
			$headers[] = "Reply-To: $submitter_name <$submitter_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers = apply_filters("aarambha_property_submit_mail_header", $headers);    // just in case if you want to modify the header in child theme

			// Send Email
			if (!wp_mail($target_email, $email_subject, $email_body, $headers)) {
				aarambha_log('Failed: To send property submit notice');
			}
		}
	}

	add_action('aarambha_after_property_submit', 'cre_submit_notice');
}
