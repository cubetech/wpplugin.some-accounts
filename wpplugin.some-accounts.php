<?php
/*
Plugin Name: cubetech WordPress SoMe Accounts
Plugin URI: https://github.com/cubetech/wpplugin.some-accounts
Description: A plugin to add your social media accounts to your theme or content
Version: 1.1.0
Author: cubetech GmbH
Author URI: https://www.cubetech.ch
*/

if ( !defined( 'RWMB_VER' ) ) {
	include('vendor/metabox.io/meta-box.php');
}

class Wordpress_some_accounts{
	function init(){
		add_action('init', array($this, 'someRegisterAction'));

		add_filter('rwmb_meta_boxes', array($this, 'registerMetaboxesAction'));

		add_action( 'wp_enqueue_scripts', array($this, 'includeFontAwesome') );
		
		add_shortcode('some-accounts', array($this, 'shortcode'));
	}
	
	function includeFontAwesome() {
		
		wp_enqueue_style( 'SoMe', plugin_dir_url(__FILE__) . 'vendor/font-awesome-4.7.0/css/font-awesome.min.css' , false ); 
		
	}
	
	function someRegisterAction() {
		$labels = array(
			'name'               => _x( 'Social Media Accounts', 'someaccs', 'wpplugin-someaccs' ),
			'singular_name'      => _x( 'SoMe Account', 'someacc', 'wpplugin-someaccs' ),
			'menu_name'          => _x( 'SoMe Accounts', 'someaccs', 'wpplugin-someaccs' ),
			'name_admin_bar'     => _x( 'SoMe Account', 'someaccs', 'wpplugin-someaccs' ),
			'add_new'            => _x( 'Neuer Account', 'someacc', 'wpplugin-someaccs' ),
			'add_new_item'       => __( 'Neuer Account', 'wpplugin-someaccs' ),
			'new_item'           => __( 'Neuer Account', 'wpplugin-someaccs' ),
			'edit_item'          => __( 'Account bearbeiten', 'wpplugin-someaccs' ),
			'view_item'          => __( 'Account anschauen', 'wpplugin-someaccs' ),
			'all_items'          => __( 'Alle Accounts', 'wpplugin-someaccs' ),
			'search_items'       => __( 'Accounts durchsuchen', 'wpplugin-someaccs' ),
			'parent_item_colon'  => __( 'Parent Accounts:', 'wpplugin-someaccs' ),
			'not_found'          => __( 'Keine Accounts gefunden', 'wpplugin-someaccs' ),
			'not_found_in_trash' => __( 'Keine Accounts im Papierkorb', 'wpplugin-someaccs' )
		);

		$args = array(
			'labels'             => $labels,
			'menu_icon'			 => 'dashicons-share',
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
	
	function registerMetaboxesAction( $meta_boxes )
	{
	    $prefix = 'ct_some_';

	    // 1st meta box
	    $meta_boxes[] = array(
	        'id'       => 'account_information',
	        'title'    => 'Account Informationen',
	        'pages'    => array( 'someaccs' ),
	        'context'  => 'normal',
	        'priority' => 'high',
	
	        'fields' => array(
	            array(
	                'name'  => 'Link',
	                'desc'  => 'Link zum Account auf der Plattform',
	                'id'    => $prefix . 'link',
	                'std'	=> 'http://',
	                'type'  => 'url',
	            ),
	            array(
	                'name'  => 'Icon',
	                'desc'  => 'verwendet FontAwesome Icons (http://fontawesome.io/icons/#brand)',
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
            'facebook' => 'Facebook',
            'facebook-square' => 'Facebook (quadratisch)',
            'facebook-official' => 'Facebook (offiziell)',
            'twitter' => 'Twitter',
            'twitter-square' => 'Twitter (quadratisch)',
            'instagram' => 'Instagram',
            'flickr' => 'Flickr',
            'flickr-square' => 'Flickr (quadratisch)',
            'xing' => 'XING',
            'xing-square' => 'XING (quadratisch)',
            'linkedin' => 'LinkedIn',
            'linkedin-square' => 'LinkedIn (quadratisch)',
            'pinterest' => 'Pinterest',
            'pinterest-square' => 'Pinterest (quadratisch)',
            'tumblr' => 'Tumblr',
            'tumblr-square' => 'Tumblr (quadratisch)',
            'youtube' => 'YouTube',
            'youtube-square' => 'YouTube (quadratisch)',
            'youtube-play' => 'YouTube (Play Icon)',
            'dribbble' => 'Dribbble',
            'deviantart' => 'DeviantArt',
            'behance' => 'Behance',
            'behance-square' => 'Behance (quadratisch)',
            'github' => 'GitHub',
            'github-square' => 'GitHub (quadratisch)',
            'wordpress' => 'Wordpress',
            'share-alt' => 'Share neutral',
            'share-alt-square' => 'Share neutral (quadratisch)',
            'google-plus' => 'Google plus',
            'google-plus-square' => 'Google plus (quadratisch)',
        );

        return apply_filters( 'some_options', $options );
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
	
}//end class

$var = new Wordpress_some_accounts();
$var->init();
