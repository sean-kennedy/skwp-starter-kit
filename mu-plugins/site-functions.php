<?php

/**
 * Plugin Name: Site Functions
 * Plugin URI: http://seankennedy.com.au/
 * Description: Site level functions independent of a theme.
 * Text Domain: site-functions
 * Author: Sean Kennedy
 * Author URI: http://seankennedy.com.au/
 * Version: 0.1.0
 */

/*
 * ========================================================================
 *
 *	Disable default Wordpress comments and pingbacks
 *
 * ========================================================================
 */

	add_filter('comments_open', '__return_false');
	add_filter('pings_open', '__return_false');

/*
 * ========================================================================
 *
 *	Change author permalink base
 *
 * ========================================================================
 */

	//add_action('init','skwp_change_author_permalinks');
	
	function skwp_change_author_permalinks() {
	
	    global $wp_rewrite;
	    $wp_rewrite->author_base = 'profiles';
	    $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base. '/%author%';
	    
	}
	
/*
 * ========================================================================
 *
 *	ACF: Options pages (v5.0)
 *
 *	@icons http://melchoyce.github.io/dashicons/
 *
 * ========================================================================
 */
 
 	add_action('init', 'skwp_acf_add_options_page');
 	
 	function skwp_acf_add_options_page() {
	
		if (!function_exists('acf_add_options_page')) {
			return;
		}
	
		/**
		 *	Top Level Pages
		 */
		acf_add_options_page(array(
	        'page_title'    => 'Options',
	        'menu_title'    => 'Options',
	        'menu_slug'     => 'options',
	        'position'		=> 26,
	        'icon_url'		=> 'dashicons-admin-generic',
	        'capability'    => 'edit_posts',
	        'redirect'      => true
	    ));
		
		/**
		 *	Sub Pages
		 */
		acf_add_options_sub_page(array(
			'title' => 'Global Options',
			'parent' => 'options',
		));
		
		acf_add_options_sub_page(array(
			'title' => 'Other Options',
			'parent' => 'options',
		));
			
	}

/*
 * ========================================================================
 *
 *	ACF: Change default path for acf-json folder (also rename to acf-cache)
 *
 *	@docs http://www.advancedcustomfields.com/resources/local-json/
 *
 * ========================================================================
 */
 
	add_filter('acf/settings/save_json', 'skwp_acf_json_save_point');
	 
	function skwp_acf_json_save_point($path) {
	    
	    $path = WP_CONTENT_DIR . '/acf-cache';
	    return $path;
	    
	}
	
	add_filter('acf/settings/load_json', 'skwp_acf_json_load_point');
	
	function skwp_acf_json_load_point($paths) {
		
		$paths[] = WP_CONTENT_DIR . '/acf-cache';
		return $paths;
		
	}
	
/*
 * ========================================================================
 *
 *	Component Shortcode
 *
 *	@desc Component shortcode to load a template anywhere in the_content()
 *
 * ========================================================================
 */
 
	/* Usage *
	
	[component template="file-name" field="acf_field_name"]
	
	*/

	add_shortcode('component', 'skwp_component_shortcode');
	 
	function skwp_component_shortcode($attr) {
		
		if (!empty($attr['template'])) {
			
			$template = 'partials/components/' . $attr['template'] . '.php';
			
			if (!empty($attr['field'])) {
				$field = $attr['field'];
			}
			
			ob_start();
			include(locate_template($template, false, false));
			return ob_get_clean();
		
		}
		
	}
	
/*
 * ========================================================================
 *
 *	Remove default page/post supports
 *
 *	@docs http://codex.wordpress.org/Function_Reference/remove_post_type_support
 *
 * ========================================================================
 */
	
	add_action('init', 'skwp_remove_post_type_support', 10);
	
	function skwp_remove_post_type_support() {
		
		/**
		 *	Page
		 */
	    remove_post_type_support('page', 'author');
	    remove_post_type_support('page', 'thumbnail');
	    remove_post_type_support('page', 'excerpt');
	    remove_post_type_support('page', 'trackbacks');
	    remove_post_type_support('page', 'comments');
	    remove_post_type_support('page', 'custom-fields');
	    
		/**
		 *	Post
		 */
	    remove_post_type_support('post', 'excerpt');
	    remove_post_type_support('post', 'trackbacks');
	    remove_post_type_support('post', 'custom-fields');
	    
	}
	
/*
 * ========================================================================
 *
 *	Change default Post type name
 *
 * ========================================================================
 */
 	
	//add_action('admin_menu', 'skwp_change_post_label');
	 
	function skwp_change_post_label() {
	    global $menu;
	    global $submenu;
	    $menu[5][0] = 'News';
	    $submenu['edit.php'][5][0] = 'News';
	    $submenu['edit.php'][10][0] = 'Add News';
	    $submenu['edit.php'][16][0] = 'News Tags';
	    echo '';
	}
	
	//add_action('init', 'skwp_change_post_object');
	
	function skwp_change_post_object() {
	    global $wp_post_types;
	    $labels = &$wp_post_types['post']->labels;
	    $labels->name = 'News';
	    $labels->singular_name = 'News';
	    $labels->add_new = 'Add News';
	    $labels->add_new_item = 'Add News';
	    $labels->edit_item = 'Edit News';
	    $labels->new_item = 'News';
	    $labels->view_item = 'View News';
	    $labels->search_items = 'Search News';
	    $labels->not_found = 'No News found';
	    $labels->not_found_in_trash = 'No News found in Trash';
	    $labels->all_items = 'All News';
	    $labels->menu_name = 'News';
	    $labels->name_admin_bar = 'News';
	}

/*
 * ========================================================================
 *
 *	Custom Post Types
 *
 *	@docs http://codex.wordpress.org/Function_Reference/register_post_type
 *	@icons http://melchoyce.github.io/dashicons/
 *
 * ========================================================================
 */
	
	//add_action('init', 'skwp_custom_post_type_init');
	
	function skwp_custom_post_type_init() {
	
		$labels = array(
			'name'               => _x( 'Custom Posts', 'post type general name', 'site-functions' ),
			'singular_name'      => _x( 'Custom Post', 'post type singular name', 'site-functions' ),
			'menu_name'          => _x( 'Custom Posts', 'admin menu', 'site-functions' ),
			'name_admin_bar'     => _x( 'Custom Post', 'add new on admin bar', 'site-functions' ),
			'add_new'            => _x( 'Add New', 'custom_post_type', 'site-functions' ),
			'add_new_item'       => __( 'Add New Custom Post', 'site-functions' ),
			'new_item'           => __( 'New Custom Post', 'site-functions' ),
			'edit_item'          => __( 'Edit Custom Post', 'site-functions' ),
			'view_item'          => __( 'View Custom Post', 'site-functions' ),
			'all_items'          => __( 'All Custom Posts', 'site-functions' ),
			'search_items'       => __( 'Search Custom Posts', 'site-functions' ),
			'parent_item_colon'  => __( 'Parent Custom Posts:', 'site-functions' ),
			'not_found'          => __( 'No Custom Posts found.', 'site-functions' ),
			'not_found_in_trash' => __( 'No Custom Posts found in Trash.', 'site-functions' )
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'exclude_from_search'=> false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_nav_menus'	 => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array('slug' => 'custom-post-type', 'with_front' => false),
			'capability_type'    => 'post',
			'taxonomies'		 => array(),
			'has_archive'        => true,
			'hierarchical'       => false,
			'show_in_admin_bar'	 => true,
			'menu_position'      => 5,
			'menu_icon'			 => 'dashicons-admin-post',
			'supports'           => array('title', 'editor', 'thumbnail')
		);
	
		register_post_type('custom_post_type', $args);
		
	}
	
	/**
	 *	Flush rewrite rules on plugin activation only
	 */
	//register_activation_hook(__FILE__, 'skwp_rewrite_flush');
	
	function skwp_rewrite_flush() {
		
	    skwp_custom_post_type_init();
	    
	    flush_rewrite_rules();
	    
	}
	
/*
 * ========================================================================
 *
 *	Shortcodes
 *
 * ========================================================================
 */
 	
	/**
	 *	Example shortcode to use get_template_part
	 */
 	//add_shortcode('example_shortcode', 'skwp_template_shortcode');
	
	function skwp_template_shortcode($attr) {
	
	    ob_start();
	    get_template_part('shortcodes/timeline');
	    return ob_get_clean();
	    
	}

?>