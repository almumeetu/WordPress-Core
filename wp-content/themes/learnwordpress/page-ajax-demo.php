<?php
/**
 * Template Name: AJAX Demo Page
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div id="posts-container">
            <?php
            // Initial posts load
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'paged' => 1,
                'ignore_sticky_posts' => true
            );
            
            $query = new WP_Query($args);
            
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    get_template_part('template-parts/content', 'post');
                }
                wp_reset_postdata();
            } else {
                echo '<p>' . __('No posts found', 'text-domain') . '</p>';
            }
            ?>
        </div>
        
        <?php if (true || $query->max_num_pages > 1) : ?>
            <button id="load-more" data-page="2"><?php _e('Load More', 'text-domain'); ?></button>
        <?php endif; ?>
    </main>
</div>

<?php get_footer(); ?>