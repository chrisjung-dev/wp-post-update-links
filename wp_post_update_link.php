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
	/*
	 * Variable Declaration
	 */
    private $update_count = 0;
    private $update_links = array();
    
    public function insert_post_update_links( $content ){
        $link_html = '<ul>';
        for( $i = 0; $i < count( $this->update_links); $i++ ){
            $link_html .= '<li><a href="#update_' . ($i+1) .'">' . $this->update_links[ $i ] . '</a></li>';
        };
        $link_html .= '</ul>';
        return $link_html . $content;
    }
    public function execute_update_shortcodes( $atts, $content=null, $code="" ) {
        $this->update_count++;
        $this->update_links[] = $atts['title'] ? $atts['title'] : _('Update ') . $this->update_count;
        return '<div class="update" id="update_' . $this->update_count . '">' . $content . '</div>';
    }
};
$wp_post_update_links = new wp_post_update_links();
add_shortcode( 'update', array( $wp_post_update_links, 'execute_update_shortcodes') );
/*
 *	Add filter AFTER Shortcode to have the Update Link Array
 */
add_filter( 'the_content', array( $wp_post_update_links, 'insert_post_update_links' ), 12 );
?>
