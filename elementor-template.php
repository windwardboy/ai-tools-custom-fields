<?php
$post_id = get_the_ID();
$favicon_url = get_post_meta($post_id, 'ai_tool_favicon', true);
?>
<div class="ai-tool-item">
    <h2>
        <?php if (!empty($favicon_url)): ?>
            <img class="ai-tool-favicon" src="<?php echo esc_url($favicon_url); ?>" alt="Favicon">
        <?php endif; ?>
        <?php the_title(); ?>
    </h2>
    <p><?php the_excerpt(); ?></p>
    <div class="ai-tool-details">
        <p><strong>Pricing:</strong> <?php echo get_post_meta($post_id, 'ai_tool_pricing', true); ?></p>
        <p><strong>Free/Paid:</strong> <?php echo get_post_meta($post_id, 'ai_tool_free_paid', true); ?></p>
        <p><strong>Technology:</strong> <?php echo get_post_meta($post_id, 'ai_tool_technology', true); ?></p>
        <p><strong>Industry:</strong> <?php echo get_post_meta($post_id, 'ai_tool_industry', true); ?></p>
        <p><strong>Use Cases:</strong> <?php echo get_post_meta($post_id, 'ai_tool_use_cases', true); ?></p>
        <p><strong>Website:</strong> <a href="<?php echo esc_url(get_post_meta($post_id, 'ai_tool_website', true)); ?>" target="_blank"><?php echo esc_url(get_post_meta($post_id, 'ai_tool_website', true)); ?></a></p>
        <p><strong>Documentation:</strong> <a href="<?php echo esc_url(get_post_meta($post_id, 'ai_tool_documentation', true)); ?>" target="_blank"><?php echo esc_url(get_post_meta($post_id, 'ai_tool_documentation', true)); ?></a></p>
        <p><strong>API Key Required:</strong> <?php echo get_post_meta($post_id, 'ai_tool_api_key_required', true); ?></p>
    </div>
</div>
