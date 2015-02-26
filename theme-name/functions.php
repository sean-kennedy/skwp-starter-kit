<?php

/*
 * ========================================================================
 *
 *	Theme Support
 *
 * ========================================================================
 */

	if (function_exists('add_theme_support')) {
	
	    // Add Menu Support
	    add_theme_support('menus');
	
	    // Add Thumbnail Theme Support
	    add_theme_support('post-thumbnails');
	
	    // Enables post and comment RSS feed links to head
	    add_theme_support('automatic-feed-links');
	    
	}

/*
 * ========================================================================
 *
 *	Custom Walker to only show published pages in WP nav menu
 *
 * ========================================================================
 */
 
	/* Usage *
	
	wp_nav_menu(array(
		'theme_location' => 'main-menu',
		'walker' => new Exclude_Unpublished
	));
	
	*/
	
	class Exclude_Unpublished extends Walker_Nav_Menu {
	 
		public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			if (!$this->hide_if_not_published($item)) return;
			parent::start_el($output, $item, $depth, $args, $id);
		}
		 
		public function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			if (!$this->hide_if_not_published($item)) return;
			parent::end_el($output, $item, $depth, $args, $id);
		}
		 
		private function hide_if_not_published(&$item) {
			if ($item->object === 'page') {
				return get_post_status($item->object_id) === 'publish';
			} else {
				return true;
			}
		}
	 
	}

/*
 * ========================================================================
 *
 *	Sub Menu from WP nav menu
 *
 * ========================================================================
 */
 
	/* Usage *
	
	wp_nav_menu(array(
		'theme_location' => 'main-menu',
		'sub_menu' => true
	));
	
	*/
	
	add_filter('wp_nav_menu_objects', 'skwp_nav_menu_objects_sub_menu', 10, 2);
	 
	function skwp_nav_menu_objects_sub_menu($sorted_menu_items, $args) {
	
		if (isset($args->sub_menu)) {
		
			$root_id = 0;
			
			// Find the current menu item
			foreach ($sorted_menu_items as $menu_item) {
				if ($menu_item->current) {
					// Set the root id based on whether the current menu item has a parent or not
					$root_id = ($menu_item->menu_item_parent) ? $menu_item->menu_item_parent : $menu_item->ID;
					break;
				}
			}
			
			// Find the top level parent
			if (!isset($args->direct_parent)) {
			
				$prev_root_id = $root_id;
				
				while ($prev_root_id != 0) {
					foreach ($sorted_menu_items as $menu_item) {
						if ($menu_item->ID == $prev_root_id) {
							$prev_root_id = $menu_item->menu_item_parent;
							// Don't set the root_id to 0 if reached the top of the menu
							if ($prev_root_id != 0) $root_id = $menu_item->menu_item_parent;
							break;
						}
					}
				}
			}
			 
			$menu_item_parents = array();
			
			foreach ($sorted_menu_items as $key => $item) {
				// Init menu_item_parents
				if ($item->ID == $root_id) $menu_item_parents[] = $item->ID;
			 
				if (in_array($item->menu_item_parent, $menu_item_parents)) {
					// Part of sub-tree
					$menu_item_parents[] = $item->ID;
				} else if (!(isset($args->show_parent) && in_array($item->ID, $menu_item_parents))) {
					// Not part of sub-tree
					unset($sorted_menu_items[$key]);
				}
			}
			
			return $sorted_menu_items;
			
		} else {
			return $sorted_menu_items;
		}
		
	}

/*
 * ========================================================================
 *
 *	Template Helper Functions
 *
 * ========================================================================
 */
 
	/**
	 *	Create excerpt from post/page content
	 */
	function content_excerpt($content, $length = 13, $link_text = 'Read More') {
		
		$content = preg_replace('/\[.*\]/', '', $content);
		
		$trimmed_content = wp_trim_words($content, $length, '... <a class="read-more-link" href="' . get_permalink() . '">' . $link_text . '</a>' );
		
		return $trimmed_content;
		
	}
	
	/**
	 *	Check if page has children
	 */
	function has_children($child_of = null) {
	
		if (is_null($child_of)) {
			global $post;
			$child_of = $post->ID;
		}
		
		return (wp_list_pages("child_of=$child_of&echo=0")) ? true : false;
		
	}

/*
 * ========================================================================
 *
 *	WP Nav Menus
 *
 * ========================================================================
 */

	/**
	 *	Main Navigation
	 */
	function main_nav() {
		
		wp_nav_menu(array(
			'theme_location'  => 'main-menu',
			'menu'            => '', 
			'container'       => false, 
			'container_id'    => '',
			'menu_class'      => 'menu', 
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul class="js-nav-list nav-list group">%3$s</ul>',
			'depth'           => 0,
			'walker'          => new Exclude_Unpublished
		));
		
	}
	
	/**
	 *	Register Navigation
	 */
	add_action('init', 'skwp_register_menus');
	 
	function skwp_register_menus() {
		register_nav_menus(array(
			'main-menu' => 'Main Menu'
		));
	}

/*
 * ========================================================================
 *
 *	Enqueue
 *
 * ========================================================================
 */

	/**
	 *	Scripts
	 */
	add_action('wp_enqueue_scripts', 'skwp_enqueue_scripts');

	function skwp_enqueue_scripts() {
	
	    if (!is_admin()) {
	    
	        wp_deregister_script('jquery');
			wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '1.11.1', false);
	        
	        wp_register_script('menu', get_template_directory_uri() . '/js/menu.js', array('jquery'), '1.0.0', true);
	        
	        wp_register_script('forms', get_template_directory_uri() . '/js/forms.js', array('jquery'), '1.0.0', true);
	
	        wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery', 'menu', 'forms'), '1.0.0', true);
	        wp_enqueue_script('scripts');
	        
	    }
	    
	}

	/**
	 *	Stylesheets
	 */
	add_action('wp_enqueue_scripts', 'skwp_enqueue_styles');
	
	function skwp_enqueue_styles() {
	
	    wp_register_style('defaults', get_template_directory_uri() . '/css/defaults.css', array(), '1.0', 'all');
	    
	    wp_register_style('menu', get_template_directory_uri() . '/css/menu.css', array(), '1.0', 'all');
	    
	    wp_register_style('forms', get_template_directory_uri() . '/css/forms.css', array(), '1.0', 'all');
	    
	    wp_register_style('style', get_stylesheet_uri(), array('defaults', 'menu', 'forms'), '1.0', 'all');
	    wp_enqueue_style('style');
	    
	}
	
/*
 * ========================================================================
 *
 *	Add page slug to body class
 *
 * ========================================================================
 */
 
 	add_filter('body_class', 'skwp_body_classes');

	function skwp_body_classes($classes) {
	    
	    if (is_home()) {
	        $key = array_search('blog', $classes);
	        if ($key > -1) {
	            unset($classes[$key]);
	            $classes[] = 'index-list';
	        }
	    }
	    
		if (is_archive() || is_search() || is_home()) {
			$classes[] = 'list-view';
		}
	
	    return $classes;
	    
	}
	
/*
 * ========================================================================
 *
 *	Pagination
 *
 * ========================================================================
 */
 
	/* Usage *
	
	skwp_pagination();
		
	*/
 
 	add_action('init', 'skwp_pagination');
 	
	function skwp_pagination() {
	    
	    global $wp_query;
	    $big = 999999999;
	    
	    echo paginate_links(array(
	        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
	        'format' => '?paged=%#%',
	        'current' => max(1, get_query_var('paged')),
	        'total' => $wp_query->max_num_pages
	    ));
	    
	}
	
/*
 * ========================================================================
 *
 *	Custom 'Read More' link for excerpts
 *
 * ========================================================================
 */
 
 	add_filter('excerpt_more', 'skwp_view_article');

	function skwp_view_article() {
	    global $post;
	    return '... <a class="read-more-link" href="' . get_permalink($post->ID) . '">Read More</a>';
	}
	
/*
 * ========================================================================
 *
 *	Remove 'text/css' from enqueued stylesheets
 *
 * ========================================================================
 */

	add_filter('style_loader_tag', 'skwp_style_remove');
	
	function skwp_style_remove($tag) {
	    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
	}
	
/*
 * ========================================================================
 *
 *	Remove width and height dimensions from the_thumbnail
 *
 * ========================================================================
 */
 
	add_filter('post_thumbnail_html', 'skwp_remove_thumbnail_dimensions', 10);
	add_filter('image_send_to_editor', 'skwp_remove_thumbnail_dimensions', 10);
	
	function skwp_remove_thumbnail_dimensions($html) {
	    $html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
	    return $html;
	}

/*
 * ========================================================================
 *
 *	Remove Actions
 *
 * ========================================================================
 */
 	
 	// Display the links to the extra feeds such as category feeds
	remove_action('wp_head', 'feed_links_extra', 3);
	
	// Display the links to the general feeds: Post and Comment Feed
	remove_action('wp_head', 'feed_links', 2);
	
	// Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action('wp_head', 'rsd_link');
	
	// Display the link to the Windows Live Writer manifest file.
	remove_action('wp_head', 'wlwmanifest_link');
	
	// Index link
	remove_action('wp_head', 'index_rel_link');
	
	// Prev link
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	
	// Start link
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	
	// Display relational links for the posts adjacent to the current post.
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	
	// Display the XHTML generator that is generated on the wp_head hook, WP version
	remove_action('wp_head', 'wp_generator');
	
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	
	remove_action('wp_head', 'rel_canonical');
	
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

?>