<?php

/**
 * Plugin Name: Wordpress Post Update Links
 * Plugin URI: http://wiki.campino2k.de/
 * Description: Inserts Links to Update sections in the Beginning of Posts and Pages
 * Version: 0.1
 * Author: Christian Jung
 * Author URI: http://campino2k.de
 */
class wp_post_update_links {

    //$updatelinks = array();
    
    function insert_post_update_links( $content ){
        return '<ul><li><a href="#">Update Link</a></li></ul>' . $content;
    }
    
    function replace_update_shortcodes( $content ){
    
    }
    /*
    function monats_gericht( $atts, $content=null, $code="" ) {
        $price = $atts['preis'];
        return '<div class="gericht"><div class="name"><p>' . $content . '</p></div><div class="preis">&euro;&nbsp;'. $price . '</div><hr /></div>';
    };
    add_shortcode('gericht', 'monats_gericht');
    */

};

add_filter( 'the_content', array('wp_post_update_links', 'insert_post_update_links' ));

?>
