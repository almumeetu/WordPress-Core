<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
    <header class="entry-header">
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>
        
        <div class="entry-meta">
            <?php 
            printf(
                __('Posted on %s by %s', 'text-domain'),
                get_the_date(),
                get_the_author()
            );
            ?>
        </div>
    </header>
    
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
    
    <footer class="entry-footer">
        <a href="<?php the_permalink(); ?>" class="read-more">
            <?php _e('Read More', 'text-domain'); ?>
        </a>
    </footer>
</article>