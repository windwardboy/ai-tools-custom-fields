<?php
/**
 * Plugin Name: AI Tools Custom Fields
 * Description: Adds custom fields for AI tools and fetches favicons.
 * Version: 1.1
 * Author: VJ
 * License: GPL-2.0+
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}

// Add custom fields
function ai_tools_add_custom_fields() {
    add_meta_box('ai_tools_custom_fields', 'AI Tool Details', 'ai_tools_custom_fields_callback', 'post', 'normal', 'high');
}
add_action('add_meta_boxes', 'ai_tools_add_custom_fields');

function ai_tools_custom_fields_callback($post) {
    wp_nonce_field('save_ai_tools_custom_fields', 'ai_tools_custom_fields_nonce');

    $fields = array(
        'ai_tool_pricing' => 'Pricing',
        'ai_tool_free_paid' => 'Free/Paid',
        'ai_tool_technology' => 'Technology',
        'ai_tool_industry' => 'Industry',
        'ai_tool_use_cases' => 'Use Cases',
        'ai_tool_website' => 'Website',
        'ai_tool_documentation' => 'Documentation',
        'ai_tool_api_key_required' => 'API Key Required',
    );

    foreach ($fields as $field => $label) {
        $value = get_post_meta($post->ID, $field, true);
        echo '<p><label for="'.$field.'">'.$label.':</label>';
        echo '<input type="text" id="'.$field.'" name="'.$field.'" value="'.esc_attr($value).'" size="25" /></p>';
    }
}

// Save custom fields and favicon URL
function ai_tools_save_custom_fields($post_id) {
    if (!isset($_POST['ai_tools_custom_fields_nonce']) || !wp_verify_nonce($_POST['ai_tools_custom_fields_nonce'], 'save_ai_tools_custom_fields')) {
        return;
    }

    $fields = array(
        'ai_tool_pricing',
        'ai_tool_free_paid',
        'ai_tool_technology',
        'ai_tool_industry',
        'ai_tool_use_cases',
        'ai_tool_website',
        'ai_tool_documentation',
        'ai_tool_api_key_required',
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }

    // Fetch and save favicon URL
    save_favicon_url($post_id);
}
add_action('save_post', 'ai_tools_save_custom_fields');

// Fetch favicon URL from a given website URL
function fetch_favicon_url($website_url) {
    $favicon_service_url = 'https://favicongrabber.com/api/grab/' . parse_url($website_url, PHP_URL_HOST);
    $response = wp_remote_get($favicon_service_url);

    if (is_wp_error($response)) {
        return '';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['icons'][0]['src'])) {
        return $data['icons'][0]['src'];
    }

    return '';
}

// Save favicon URL when the post is saved
function save_favicon_url($post_id) {
    if (!isset($_POST['ai_tool_website'])) {
        return;
    }

    $website_url = sanitize_text_field($_POST['ai_tool_website']);
    $favicon_url = fetch_favicon_url($website_url);

    if (!empty($favicon_url)) {
        update_post_meta($post_id, 'ai_tool_favicon', $favicon_url);
    }
}

// Enqueue custom styles
function ai_tools_enqueue_styles() {
    wp_enqueue_style('ai-tools-styles', plugins_url('ai-tools-custom-fields.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'ai_tools_enqueue_styles');
