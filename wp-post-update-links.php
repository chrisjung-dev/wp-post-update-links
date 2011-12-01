<?php
/**
 * Plugin Name: Wordpress Post Update Links
 * Plugin URI: http://wiki.campino2k.de/programmierung/wp-post-update-links
 * Description: Inserts Links to Update sections in the Beginning of Posts and Pages
 * Version: 0.1
 * Author: Christian Jung
 * Author URI: http://campino2k.de
 * License: GPLv2
 */
class wp_post_update_links {
    
	private $update_links;
    
	public function insert_post_update_links( $content ){
		global $post;
		if( !isset( $this->update_links[ $post->ID ] ) ) {
			return $content;
		} else {
			$link_html = '<div class="update-links-section">';
			$link_html .= '<div class="update-links-headline">' . __( 'Updates:', 'wp_post_update_links') .'</div>';
			$link_html .= '<ul class="update-links">';
			foreach( $this->update_links[ $post->ID ] as $i => $update_link ){
				$link_html .= '<li><a href="#post-' . $post->ID . '_update-' . $i .'">' . $update_link . '</a></li>';
			};
			$link_html .= '</ul>';
			$link_html .= '</div>';
			/*
			 * remove vars to have no side effects in other posts on index pages
			 */
			unset( $this->update_links );
			return $link_html . $content;
		} 
	}
	public function execute_update_shortcodes( $atts, $content=null, $code="" ) {
		global $post;
		$this->update_links[] = $post->ID;
		$update_link_text = __('Update ', 'wp_post_update_links' ) . ( isset(  $this->update_links[ $post->ID ] ) ?  count( $this->update_links[ $post->ID ] ) + 1 :	'1' );
		$this->update_links[ $post->ID ][] = isset( $atts['title'] ) ? $atts['title'] : $update_link_text;
		$return = '<div class="update" id="post-' . $post->ID . '_update-' . ( count( $this->update_links[ $post->ID ] ) - 1 ) . '">' . $content . '</div>';
		return $return;
	}
	public function add_wp_post_update_links_style() {
		wp_enqueue_style( 'wp-post-update-links-style', plugins_url( 'css/screen.css', __FILE__ ), false, '20111129', 'screen' );
	}
};
/*
 *	Create Instance to have some encapsulation
 */
$wp_post_update_links = new wp_post_update_links();
/*
 *	Add shortcode function
 */
add_shortcode( 'update', array( $wp_post_update_links, 'execute_update_shortcodes') );
/*
 *	Add filter AFTER Shortcode to have the Update Link Array
 */
add_filter( 'the_content', array( $wp_post_update_links, 'insert_post_update_links' ), 12 );
/*
 *	Add standard styling (everything inline)
 */
add_action( 'wp_print_styles', array( $wp_post_update_links, 'add_wp_post_update_links_style' ) );
?>
