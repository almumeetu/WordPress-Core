<?php
/**
 * AJAX handlers for load more functionality
 */

add_action('wp_ajax_load_more_posts', 'handle_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'handle_load_more_posts');

function handle_load_more_posts() {
    // Verify nonce for security
    check_ajax_referer('ajax_nonce', 'nonce');
    
    // Sanitize and validate input
    $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
    $posts_per_page = 3;
    
    // Query arguments
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'ignore_sticky_posts' => true
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        ob_start();
        
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'post');
        }
        
        wp_reset_postdata();
        
        $is_last_page = $query->max_num_pages <= $page;
        
        wp_send_json_success(array(
            'html' => ob_get_clean(),
            'is_last_page' => $is_last_page
        ));
    } else {
        wp_send_json_error(array(
            'message' => __('No more posts found', 'text-domain')
        ));
    }
}