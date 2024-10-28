<?php

/*
 Plugin Name: bbPress Top Contributors
 Plugin URI: http://www.eduardoleoni.com.br
 Description: Shortcode to show the authors that have posted more
 Version: 0.1
 Author: Eduardo Leoni
 Author URI: http://www.eduardoleoni.com.br
 Text Domain: bbpress-top-contributors
 */


function bbtc_get($limit){
   
    global $wpdb;
    $query = "SELECT 
                post_author, COUNT(*) as count 
              FROM 
                " . $wpdb->prefix . "posts 
              WHERE 
                post_type ='reply' OR post_type = 'topic'
              GROUP BY 
                post_author
              ORDER BY 
                count DESC
              LIMIT $limit";
    $result = $wpdb->get_results($query);
    
    foreach ($result as $each):
        $author = $each->post_author;
        $replies = $each->count;
        
        ?>
        <div class ="each">
            <span class ="by"> <span class ="image"><?php echo get_avatar($author); ?></span></span>
            <span class ="author"><a href = "<?php echo bbp_get_user_profile_url($author); ?>"> <?php echo get_the_author_meta( 'display_name', $author); ?></a></span>
            <span class ="posts"><?php echo $replies; ?> posts</span>
            <span class ="role"><?php echo bbp_get_user_display_role($author); ?></span>
        </div>
        <?php
        
    endforeach;
    
    
    ?>
      
    <?php
    
}



function bbtc_shortcodeCaller( $atts ){
    
    bbtc_get($atts["qty"]);
}


add_shortcode( 'bbpresstopcontributors', 'bbtc_shortcodeCaller' );



