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
 *	Featured image in RSS feed
 *
 * ========================================================================
 */
	
    add_filter('the_content_feed', 'skwp_featured_image_in_feed');
    add_filter('the_excerpt_rss', 'skwp_featured_image_in_feed' );
    
    function skwp_featured_image_in_feed($content) {
        
        global $post;
            
        if (has_post_thumbnail($post->ID)) {
            $output = get_the_post_thumbnail($post->ID, 'full', array('style' => 'float:right; margin:0 0 10px 10px;'));
            $content = $output . $content;
        }
        
        return $content;
        
    }
    
/*
 * ========================================================================
 *
 *  Optimise RSS for Feedly
 *
 * ========================================================================
 */
    
    add_filter('rss2_ns', 'skwp_optimise_feedly');
    
    function skwp_optimise_feedly() {
        echo 'xmlns:webfeeds="http://webfeeds.org/rss/1.0"';
    }
    
    add_filter('rss2_head', 'skwp_feedly_head');
    
    function skwp_feedly_head() {
        echo '<webfeeds:accentColor>#64a0c8</webfeeds:accentColor>';
    }

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
 *	Disable Wordpress embeds added in 4.4 (credit: https://wordpress.org/plugins/disable-embeds/)
 *
 * ========================================================================
 */
 
	add_action('init', 'skwp_disable_embeds', 9999);
		
	function skwp_disable_embeds() {
	
		global $wp;
	
		$wp->public_query_vars = array_diff($wp->public_query_vars, array('embed'));
	
		add_filter('embed_oembed_discover', '__return_false');
		add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
	
		remove_action('wp_head', 'wp_oembed_add_discovery_links');
		remove_action('wp_head', 'wp_oembed_add_host_js');
		remove_action('rest_api_init', 'wp_oembed_register_route');
		remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
		
		function disable_embeds_tiny_mce_plugin($plugins) {
			
			return array_diff($plugins, array('wpembed'));
			
		}
		
	}
	
/*
 * ========================================================================
 *
 *	Disable Wordpress rest API added in 4.4
 *
 * ========================================================================
 */
 
	add_action('init', 'skwp_disable_rest_api');
		
	function skwp_disable_rest_api() {
		
		add_filter('rest_enabled', '__return_false');
		add_filter('rest_jsonp_enabled', '__return_false');
 
		remove_action('wp_head', 'rest_output_link_wp_head');
		remove_action('template_redirect', 'rest_output_link_header', 11);
			
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
        .wpseo-tab-video-container__handle,
        .wpseo-metabox-buy-premium {
            display: none;
        }
        
        .wpseo-metabox-sidebar li.active span {
            border-color: transparent;
        }
        
        .wpseo-metabox-sidebar li span {
            margin-left:-8px;
        }
		</style>';
	}
	
/*
 * ========================================================================
 *
 *	Redirect Pages top-level menu item to tree view
 *
 * ========================================================================
 */
	
	//add_action('admin_footer', 'skwp_menu_links_js');
	
	function skwp_menu_links_js() {
		echo '<script>
            jQuery("#menu-pages > a").attr("href", "/wp-admin/edit.php?post_type=page&page=cms-tpv-page-page");
		</script>';
	}
	
/*
 * ========================================================================
 *
 *	ACF: Hide page layouts custom rules
 *
 * ========================================================================
 */
		 
	//add_action('admin_footer', 'skwp_custom_acf_js');
	
	function skwp_custom_acf_js() {
		echo '<script>
		
        var fieldGroups = [
            {
                "trigger": "acf-field_XXXXXXXXXXXXX-X",
                "field": "acf-group_XXXXXXXXXXXXX-X"
            }
        ];
        
        fieldGroups.forEach(function(fieldGroup) {
           eventBinder(fieldGroup.trigger, fieldGroup.field);
        });
        
        function eventBinder(trigger, field) {
            (function() {
                var $trigger = jQuery("#" + trigger),
                    $field = jQuery("#" + field);
                
                $trigger.on("click", function() {
                    checkStatus($trigger, $field);
                });
                
                checkStatus($trigger, $field);
            })();
        }
        
        function checkStatus($trigger, $field) {
            $trigger.is(":checked") ? $field.addClass("active") : $field.removeClass("active");
        }
		
		</script>';
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
 
 	//add_action('init', 'skwp_acf_add_options_page');
 	
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
 *	Remove Posts
 *
 * ========================================================================
 */
	
	//add_action('admin_menu', 'skwp_remove_admin_menus');
	//add_action('wp_before_admin_bar_render', 'skwp_remove_toolbar_menus');
	
	function skwp_remove_admin_menus() {
	    remove_menu_page( 'edit.php' );
	}
	
	function skwp_remove_toolbar_menus() {
	    global $wp_admin_bar;
	    $wp_admin_bar->remove_menu( 'new-post' );
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
	
	//add_action('init', 'skwp_taxonomies_for_pages');
	
	function skwp_taxonomies_for_pages() {
		register_taxonomy_for_object_type('post_tag', 'page');
		register_taxonomy_for_object_type('category', 'page');
	}
	
	if (!is_admin()) {
		//add_action('pre_get_posts', 'skwp_category_archives');
		//add_action('pre_get_posts', 'skwp_tags_archives');
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
	
/*
 * ========================================================================
 *
 *	Shortcodes
 *
 * ========================================================================
 */
 	
	/**
	 *	Template part
	 *
	 *	@desc Load a theme template part from /partials folder anywhere in the_content(). Pass in variables as 
	 *		  attributes to the shortcode and the value will available as $attr['attribute_name'] in the template.
	 */
	 
	add_shortcode('template', 'skwp_template_part_shortcode');
	
	function skwp_template_part_shortcode($attr) {
		
		if (!empty($attr['name'])) {
			
			$template = get_template_directory() . '/partials/' . $attr['name'] . '.php';
			
			if (file_exists($template)) {
				ob_start();
				include($template);
				return ob_get_clean();
			}
		
		}
	    
	}

?>