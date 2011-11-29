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
	private $update_count = -1;
    private $update_links = array();
    
    public function insert_post_update_links( $content ){
		global $post;
		if( !isset( $update_count ) &&  !isset( $this->update_links ) ) {
			return $content;
		} else {
			$link_html = '<div class="update-links-section">';
			$link_html .= '<div class="update-links-headline">' . __( 'Updates:', 'wp_post_update_links') .'</div>';
			$link_html .= '<ul class="update-links">';
			foreach( $this->update_links as $i => $update_link ){
				$link_html .= '<li><a href="#post-' . $post->ID . '_update-' . $i .'">' . $update_link . '</a></li>';
			};
			$link_html .= '</ul>';
			$link_html .= '</div>';
			
			/*
			 * remove vars to have no side effects in other posts on index pages
			 */
			unset( $update_count );
			unset( $this->update_links );

			return $link_html . $content;
		} 
    }
    public function execute_update_shortcodes( $atts, $content=null, $code="" ) {
		global $post;
		$this->update_count++;
        $this->update_links[] = $atts['title'] ? $atts['title'] : __('Update ', 'wp_post_update_links' ) . $this->update_count;
        return '<div class="update" id="post-' . $post->ID . '_update-' . $this->update_count . '">' . $content . '</div>';
    }
};
$wp_post_update_links = new wp_post_update_links();
add_shortcode( 'update', array( $wp_post_update_links, 'execute_update_shortcodes') );
/*
 *	Add filter AFTER Shortcode to have the Update Link Array
 */
add_filter( 'the_content', array( $wp_post_update_links, 'insert_post_update_links' ), 12 );
wp_enqueue_style( 'wp-post-update-links-style', plugins_url( 'css/screen.css', __FILE__ ), null, 20111129, 'screen' );
?>
