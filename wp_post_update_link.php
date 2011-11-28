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

    private $update_count = 0;
    private $update_links = array();
    
    public function insert_post_update_links( $content ){
        $link_html = '<ul>';
        for( $i = 1; $i <= count( $this->update_links); $i++ ){
            $link_html .= '<li>lalal</li>';
        }
        $link_html .= '</ul>';
        
        //return '<ul><li><a href="#">Update Link</a></li></ul>' . $content;
        return $link_html . $content;
    }
    private function replace_update_shortcodes( $content ){
        return $content;
    }
    public function execute_update_shortcodes( $atts, $content=null, $code="" ) {
        $this->update_count++;
        $this->update_links[] = $atts['title'] ? $atts['title'] : _('Update ') . $this->update_count;
        return '<div class="update" id="update_' . $this->update_count . '">' . $content . '</div>';
    }
};
$wp_post_update_links = new wp_post_update_links();
add_shortcode( 'update', array( $wp_post_update_links, 'execute_update_shortcodes') );
add_filter( 'the_content', array( $wp_post_update_links, 'insert_post_update_links' ) );

?>
