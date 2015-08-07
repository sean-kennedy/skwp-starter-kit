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
 *	Disable Wordpress emojis added in 4.2 (credit: https://wordpress.org/plugins/disable-emojis/)
 *
 * ========================================================================
 */

	add_action('init', 'skwp_disable_emojis');
		
	function skwp_disable_emojis() {
		
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_styles', 'print_emoji_styles');
		
		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
		
		add_filter('tiny_mce_plugins', 'skwp_disable_emojis_tinymce');
		
	}
	
	function skwp_disable_emojis_tinymce($plugins) {
		
		if (is_array($plugins)) {
			return array_diff($plugins, array('wpemoji'));
		} else {
			return array();
		}
		
	}
	
/*
 * ========================================================================
 *
 *	Move Yoast SEO metabox to the bottom of the page
 *
 * ========================================================================
 */
	
	add_filter('wpseo_metabox_prio', 'skwp_move_seo_box');
	
	function skwp_move_seo_box() {
		return 'low';
	}

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
 *	Load admin CSS
 *
 * ========================================================================
 */
	
	add_action('admin_head', 'skwp_admin_css');
	
	function skwp_admin_css() {
		echo '<style>
		.acf-field {
			max-width: none;
		} 
		</style>';
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
 *	Add Categories and Tags for Pages
 *
 * ========================================================================
 */
	
	add_action('init', 'skwp_taxonomies_for_pages');
	
	function skwp_taxonomies_for_pages() {
		register_taxonomy_for_object_type('post_tag', 'page');
		register_taxonomy_for_object_type('category', 'page');
	}
	
	if (!is_admin()) {
		add_action('pre_get_posts', 'skwp_category_archives');
		add_action('pre_get_posts', 'skwp_tags_archives');
	}
	
	function skwp_tags_archives($wp_query) {
		if ($wp_query->get('tag'))
		$wp_query->set('post_type', 'any');
	}
	
	function skwp_category_archives($wp_query) {
		if ($wp_query->get('category_name') || $wp_query->get('cat'))
		$wp_query->set('post_type', 'any');
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
	    $menu[5][0] = 'Articles';
	    $submenu['edit.php'][5][0] = 'All Articles';
	    $submenu['edit.php'][10][0] = 'Add New';
	    $submenu['edit.php'][16][0] = 'Article Tags';
	    echo '';
	}
	
	//add_action('init', 'skwp_change_post_object');
	
	function skwp_change_post_object() {
	    global $wp_post_types;
	    $labels = &$wp_post_types['post']->labels;
	    $labels->name = 'Articles';
	    $labels->singular_name = 'Article';
	    $labels->add_new = 'Add New';
	    $labels->add_new_item = 'Add New Article';
	    $labels->edit_item = 'Edit Article';
	    $labels->new_item = 'Article';
	    $labels->view_item = 'View Article';
	    $labels->search_items = 'Search Articles';
	    $labels->not_found = 'No Articles found';
	    $labels->not_found_in_trash = 'No Articles found in Trash';
	    $labels->all_items = 'All Articles';
	    $labels->menu_name = 'Articles';
	    $labels->name_admin_bar = 'Article';
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