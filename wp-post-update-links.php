<?php
/**
 * Plugin Name: Wordpress Post Update Links
 * Plugin URI: http://wiki.campino2k.de/programmierung/wp-post-update-links
 * Description: Inserts Links to Update sections in the Beginning of Posts and Pages
 * Version: 0.3.0
 * Author: Christian Jung
 * Author URI: http://campino2k.de
 * License: GPLv2
 */

/**
 * create instance of post update at init action
 * needs to be be before print_styles since we add some own styles
 */
add_action( 'init', function() {
	// create anonymous instance on init
	new wp_post_update_links(); 
});

class wp_post_update_links {
    
	private $update_links;
	
	public function __construct() {
		/*
		 *	Add shortcode function
		 */
		add_shortcode( 'update', array( $this, 'execute_update_shortcodes') );

		/*
		 *	Add filter to fix empty paragraphs in shortcodes
		 */
		add_filter( 'the_content', array( $this, 'remove_empty_paragraphs' ) );

		/*
		 *	Add filter AFTER Shortcode to have the Update Link Array
		 */
		add_filter( 'the_content', array( $this, 'insert_post_update_links' ), 12 );

		/*
		 *	Add standard styling (everything inline)
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'add_wp_post_update_links_style' ) );

		/*
		 *	Add Custom Links to Plugin information
		 */
		add_filter( 'plugin_row_meta', array( $this, 'init_meta_links' ),	10,	2 );
	}
	
	public function insert_post_update_links( $content ){
		global $post;
		if( !isset( $this->update_links[ $post->ID ] ) ) {
			return $content;
		} else {
			/**
			 * Create update section
			 * use classes since multiple posts can be shown at once
			 */
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

	public function remove_empty_paragraphs ( $content ) {
		
		/**
		 *	remove empty paragraphs
		 *
		 *	original work by Johann Heyne 
		 *	http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
		 */
		
		$content = strtr( $content, array ( '<p>[' => '[', ']</p>' => ']', ']<br />' => ']') );

		return $content;
	}

	public function execute_update_shortcodes( $atts, $content=null, $code="" ) {
		global $post;
		$this->update_links[] = $post->ID;

		// predefine update link text
		$update_link_text = __('Update ', 'wp_post_update_links' ) . ( isset(  $this->update_links[ $post->ID ] ) ?  count( $this->update_links[ $post->ID ] ) + 1 : '1' );

		/*	
		 * Check if title is available and not "false" then override standard link text
		 * "false" should not been displayed
		 */
		$update_link_text = isset( $atts['title'] ) && $atts['title'] !== "false" ? $atts['title'] : $update_link_text;
 
		 // put update title in nested array for later use
		$this->update_links[ $post->ID ][] = $update_link_text;

		$return = '<div class="update" id="post-' . $post->ID . '_update-' . ( count( $this->update_links[ $post->ID ] ) - 1 ) . '">';
		if(	
			!( isset( $atts['notitle'] )
			&& $atts['notitle'] == "true" )
			&& ( isset( $atts['title'] )
			&& $atts['title'] != "false" ) 
		) {
			$return .= '<p class="update-post-title">' . $update_link_text  . '</p>';
		}

		
		/*
		 *	Use wpautop() on content of the shortcode to have correct p-tags in it
		 */
		$return .= wpautop( $content );

		$return .= '</div>';
		return $return;
	}

	public function add_wp_post_update_links_style() {
		wp_enqueue_style( 'wp-post-update-links-style', plugins_url( 'css/screen.css', __FILE__ ), false, '20111202', 'screen' );
	}

	public function init_meta_links( $links, $file ) {
		if( plugin_basename( __FILE__) == $file  )  {
			return array_merge(
				$links,
				array(
					sprintf(
						'<a href="https://flattr.com/thing/444258/WordPress-Post-Update-Links-Plugin" target="_blank">%s</a>',
						esc_html__('Flattr')
					)
				)
			);
		}
		return $links;
	}
};
?>
