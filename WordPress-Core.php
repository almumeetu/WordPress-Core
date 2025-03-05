<?php
/**
 * Plugin Name: Conditional Tags Test
 * Description: WordPress Conditional Tags টেস্ট করার জন্য একটি প্লাগিন।
 * Version: 1.0
 * Author: Saikat
 */

add_action('wp_footer', function() {
    echo "<div style='position: fixed; bottom: 10px; left: 10px; background: #000; color: #fff; padding: 10px;'>";
    
    if ( is_home() ) {
        echo "এটি হোম পেজ!";
    } elseif ( is_single() ) {
        echo "এটি একটি সিঙ্গেল পোস্ট পেজ!";
    } elseif ( is_page() ) {
        echo "এটি একটি পেজ!";
    } elseif ( is_category() ) {
        echo "এটি একটি ক্যাটাগরি পেজ!";
    }
    
    echo "</div>";
});
