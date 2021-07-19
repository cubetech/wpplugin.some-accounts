<?php
/*
Plugin Name: cubetech WordPress SoMe Accounts
Plugin URI: https://github.com/cubetech/wpplugin.some-accounts
Description: A plugin to add your social media accounts to your theme or content
Version: 1.4.0
Author: cubetech GmbH
Author URI: https://www.cubetech.ch
Text Domain: cubetech_plugin_some-accounts
Domain Path: /lang
*/

if ( !defined( 'RWMB_VER' ) ) {
	include('vendor/metabox.io/meta-box.php');
}

class Cubetech_Plugin_Some_Accounts {

	function init(){

		add_action('init', array($this, 'someRegisterAction'));

		add_filter('rwmb_meta_boxes', array($this, 'registerMetaboxesAction'));

		add_action( 'wp_enqueue_scripts', array($this, 'includeFontAwesome') );
		add_action( 'admin_enqueue_scripts', array($this, 'includeFontAwesome') );
		
		add_shortcode('some-accounts', array($this, 'shortcode'));

		add_action('plugins_loaded', array($this, 'load_textdomain'));

		// Add the custom columns to the book post type
		add_filter( 'manage_someaccs_posts_columns', array($this, 'set_custom_edit_someaccs_columns') );
		// Add the data to the custom columns for the book post type
		add_action( 'manage_someaccs_posts_custom_column' , array($this, 'custom_someaccs_column'), 10, 2 );

	}
	
	function load_textdomain() {

		load_plugin_textdomain( 'cubetech_plugin_some-accounts', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );

	}

	function includeFontAwesome() {
		
		wp_enqueue_style( 'cubetech-some-accounts', plugin_dir_url(__FILE__) . 'vendor/fontawesome-free-5.15.3-web/css/brands.min.css' , false ); 
		
	}
	
	function someRegisterAction() {

		$labels = array(
			'name'               => _x( 'Social media accounts', 'someaccs', 'cubetech_plugin_some-accounts' ),
			'singular_name'      => _x( 'SoMe account', 'someacc', 'cubetech_plugin_some-accounts' ),
			'menu_name'          => _x( 'SoMe accounts', 'someaccs', 'cubetech_plugin_some-accounts' ),
			'name_admin_bar'     => _x( 'SoMe account', 'someaccs', 'cubetech_plugin_some-accounts' ),
			'add_new'            => _x( 'New account', 'someacc', 'cubetech_plugin_some-accounts' ),
			'add_new_item'       => __( 'Add new account', 'cubetech_plugin_some-accounts' ),
			'new_item'           => __( 'New account', 'cubetech_plugin_some-accounts' ),
			'edit_item'          => __( 'Edit account', 'cubetech_plugin_some-accounts' ),
			'view_item'          => __( 'View account', 'cubetech_plugin_some-accounts' ),
			'all_items'          => __( 'All accounts', 'cubetech_plugin_some-accounts' ),
			'search_items'       => __( 'Search accounts', 'cubetech_plugin_some-accounts' ),
			'parent_item_colon'  => __( 'Parent accounts:', 'cubetech_plugin_some-accounts' ),
			'not_found'          => __( 'No accounts found', 'cubetech_plugin_some-accounts' ),
			'not_found_in_trash' => __( 'No accounts in trash', 'cubetech_plugin_some-accounts' )
		);

		$args = array(
			'labels'             => $labels,
			'menu_icon'  	     => 'dashicons-share',
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => true,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

		register_post_type('someaccs', $args);

	}
	
	function registerMetaboxesAction( $meta_boxes ) {

	    $prefix = 'ct_some_';

	    // 1st meta box
	    $meta_boxes[] = array(
	        'id'       => 'account_information',
	        'title'    => __('Informations for the account', 'cubetech_plugin_some-accounts' ),
	        'pages'    => array( 'someaccs' ),
	        'context'  => 'normal',
	        'priority' => 'high',
	
	        'fields' => array(
	            array(
	                'name'  => __( 'Link', 'cubetech_plugin_some-accounts' ),
	                'desc'  => __( 'Link to the account on the platform', 'cubetech_plugin_some-accounts' ),
	                'id'    => $prefix . 'link',
	                'std'	=> 'http://',
	                'type'  => 'url',
	            ),
	            array(
	                'name'  => __( 'Icon', 'cubetech_plugin_some-accounts' ),
	                'desc'  => __( 'Uses FontAwesome icons (http://fontawesome.io/icons/#brand)', 'cubetech_plugin_some-accounts' ),
	                'id'    => $prefix . 'icon',
	                'type'  => 'select',
	                'options' => $this->get_some_options()
                )
	        )
	    );
	
	    return $meta_boxes;

	}

	function get_some_options() {

        $options = array(
            'facebook' => __( 'Facebook', 'cubetech_plugin_some-accounts' ),
            'facebook-square' => __( 'Facebook (square)', 'cubetech_plugin_some-accounts' ),
            'facebook-f' => __( 'Facebook (official)', 'cubetech_plugin_some-accounts' ),
            'twitter' => __( 'Twitter', 'cubetech_plugin_some-accounts' ),
            'twitter-square' => __( 'Twitter (square)', 'cubetech_plugin_some-accounts' ),
            'instagram' => __( 'Instagram', 'cubetech_plugin_some-accounts' ),
            'flickr' => __( 'Flickr', 'cubetech_plugin_some-accounts' ),
            'flickr-square' => __( 'Flickr (square)', 'cubetech_plugin_some-accounts' ),
            'whatsapp' => __( 'WhatsApp', 'cubetech_plugin_some-accounts' ),
            'whatsapp-square' => __( 'WhatsApp (square)', 'cubetech_plugin_some-accounts' ),
            'tiktok' => __( 'TikTok', 'cubetech_plugin_some-accounts' ),
            'discord' => __( 'Discord', 'cubetech_plugin_some-accounts' ),
            'xing' => __( 'XING', 'cubetech_plugin_some-accounts' ),
            'xing-square' => __( 'XING (square)', 'cubetech_plugin_some-accounts' ),
            'linkedin' => __( 'LinkedIn', 'cubetech_plugin_some-accounts' ),
            'linkedin-square' => __( 'LinkedIn (square)', 'cubetech_plugin_some-accounts' ),
            'pinterest' => __( 'Pinterest', 'cubetech_plugin_some-accounts' ),
            'pinterest-square' => __( 'Pinterest (square)', 'cubetech_plugin_some-accounts' ),
            'tumblr' => __( 'Tumblr', 'cubetech_plugin_some-accounts' ),
            'tumblr-square' => __( 'Tumblr (square)', 'cubetech_plugin_some-accounts' ),
            'youtube' => __( 'YouTube', 'cubetech_plugin_some-accounts' ),
            'youtube-square' => __( 'YouTube (square)', 'cubetech_plugin_some-accounts' ),
            'youtube-play' => __( 'YouTube (play icon)', 'cubetech_plugin_some-accounts' ),
            'vimeo-v' => __( 'Vimeo', 'cubetech_plugin_some-accounts' ),
            'vimeo-square' => __( 'Vimeo (square)', 'cubetech_plugin_some-accounts' ),
            'dribbble' => __( 'Dribbble', 'cubetech_plugin_some-accounts' ),
            'deviantart' => __( 'DeviantArt', 'cubetech_plugin_some-accounts' ),
            'behance' => __( 'Behance', 'cubetech_plugin_some-accounts' ),
            'behance-square' => __( 'Behance (square)', 'cubetech_plugin_some-accounts' ),
            'github' => __( 'GitHub', 'cubetech_plugin_some-accounts' ),
            'github-square' => __( 'GitHub (square)', 'cubetech_plugin_some-accounts' ),
            'wordpress' => __( 'WordPress', 'cubetech_plugin_some-accounts' ),
            'share-alt' => __( 'Share', 'cubetech_plugin_some-accounts' ),
            'share-alt-square' => __( 'Share (square)', 'cubetech_plugin_some-accounts' ),
            'google-plus' => __( 'Google plus', 'cubetech_plugin_some-accounts' ),
            'google-plus-square' => __( 'Google plus (square)', 'cubetech_plugin_some-accounts' ),
            'rss' => __( 'RSS feed', 'cubetech_plugin_some-accounts' ),
            'rss-square' => __( 'RSS feed (square)', 'cubetech_plugin_some-accounts' ),
        );

        $options = apply_filters_deprecated( 'some_options', array( $options ), '1.1.0', 'cubetech/plugin/some-accounts/options' );
        return apply_filters( 'cubetech/plugin/some-accounts/options', $options );

    }
	
	function shortcode() {

		ob_start();
		// LOOK FOR TEMPLATE IN THEME
		$template = locate_template( 'templates/social-shortcode.php' );
		
		// LOOK IN PLUGIN
		if( !$template ) {
			$template = dirname(__FILE__) . "/templates/social-shortcode.php";
		}

		// LOAD TEMPLATE
		if( $template ) {
			include( $template );
		}
		$content = ob_get_contents();
		ob_end_clean();
		return $content;

	}
	
	function set_custom_edit_someaccs_columns($columns) {

		$offset = -1;

		$new = array_slice($columns, 0, $offset, true) +
	    array( 'someaccs_icon' => __( 'Icon', 'cubetech_plugin_some-accounts' ) ) +
	    array( 'someaccs_link' => __( 'Link', 'cubetech_plugin_some-accounts' ) ) +
	    array_slice($columns, $offset, NULL, true);

		return $new;

	}

	function custom_someaccs_column( $column, $post_id ) {

	    switch ( $column ) {
	
	        case 'someaccs_icon' :
	            echo '<i style="font-size: 24px;" class="fa fa-' . get_post_meta($post_id, 'ct_some_icon' )[0] . '"></i>';
	            break;
	
	        case 'someaccs_link' :
	            echo get_post_meta($post_id, 'ct_some_link' )[0]; 
	            break;
	
	    }

	}

}//end class

$var = new Cubetech_Plugin_Some_Accounts();
$var->init();
