<?php

/**
 * Add agent metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function cre_agent_metabox_tab($property_metabox_tabs)
{
	if (is_array($property_metabox_tabs)) {
		$property_metabox_tabs['agent'] = array(
			'label' => esc_html__('Agent Information', 'crucial-real-estate'),
			'icon'  => 'dashicons-businessman',
		);
	}

	return $property_metabox_tabs;
}

add_filter('cre_property_metabox_tabs', 'cre_agent_metabox_tab', 60);


/**
 * Add agent metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function cre_agent_metabox_fields($property_metabox_fields)
{

	$cre_agent_fields = array(
		array(
			'name'    => esc_html__('What to display in agent information box ?', 'crucial-real-estate'),
			'id'      => "REAL_HOMES_agent_display_option",
			'type'    => 'radio',
			'std'     => 'none',
			'options' => array(
				'my_profile_info' => esc_html__('Author information.', 'crucial-real-estate'),
				'agent_info'      => esc_html__('Agent Information. ( Select the agent below )', 'crucial-real-estate'),
				'none'            => esc_html__('None. ( Hide information box )', 'crucial-real-estate'),
			),
			'columns' => 6,
			'tab'     => 'agent',
		),
		array(
			'name'     => esc_html__('Agents', 'crucial-real-estate'),
			'id'       => "REAL_HOMES_agents",
			'type'     => 'select',
			'options'  => cre_get_agents_array(),
			'multiple' => true,
			'columns'  => 6,
			'tab'      => 'agent',
		),
	);

	return array_merge($property_metabox_fields, $cre_agent_fields);
}

add_filter('cre_property_metabox_fields', 'cre_agent_metabox_fields', 60);
