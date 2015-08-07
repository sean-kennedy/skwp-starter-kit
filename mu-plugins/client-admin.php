<?php

/**
 * Plugin Name: Client Admin
 * Plugin URI: http://seankennedy.com.au/
 * Description: Client admin settings and styles.
 * Text Domain: client-admin
 * Author: Sean Kennedy
 * Author URI: http://seankennedy.com.au/
 * Version: 0.1.0
 */
 
/*
 * ========================================================================
 *
 *	Add advanced settings user option
 *
 * ========================================================================
 */
 
	add_action('personal_options', 'skwp_add_advanced_settings_field');
	
	function skwp_add_advanced_settings_field($profile) {
		
		$advancedSettings = get_user_meta($profile->ID, 'skwp_advanced_settings', true);
		
		?>
		<tr>
			<th scope="row">Advanced Settings</th>
			<td>
				<label for="skwp_advanced_settings">
				<input type="checkbox" value="1" id="skwp_advanced_settings" name="skwp_advanced_settings" <?php if ($advancedSettings == 1) { echo 'checked="checked"'; } ?>> Show advanced settings in the admin area</label>
			</td>
		</tr><?php
		
	}
	
	add_action('personal_options_update', 'skwp_update_advanced_settings');
	add_action('edit_user_profile_update', 'skwp_update_advanced_settings');
	
	function skwp_update_advanced_settings() {
		
		$user_id = get_current_user_id();
		
		if (isset($_POST['skwp_advanced_settings'])) {
			update_user_meta($user_id, 'skwp_advanced_settings', 1);
		} else {
			update_user_meta($user_id, 'skwp_advanced_settings', 0);
		}
		
	}
	
/*
 * ========================================================================
 *
 *	New user default settings
 *
 * ========================================================================
 */
 
	add_action('user_register', 'skwp_admin_bar_off_default', 10, 1);
	
	function skwp_admin_bar_off_default($user_id) {
		
		// Admin bar
		update_user_meta($user_id, 'show_admin_bar_front', 'false');
		update_user_meta($user_id, 'show_admin_bar_admin', 'false');
		
		// Per page counts
		update_user_meta($user_id, 'upload_per_page', 200);
		update_user_meta($user_id, 'edit_page_per_page', 200);
		update_user_meta($user_id, 'edit_post_per_page', 200);
		
		// Yoast SEO
		update_user_meta($user_id, 'wpseo_ignore_tour', 1);
		
		// Menus metabox screen options
		update_user_meta($user_id, 'metaboxhidden_nav-menus', array('add-post', 'add-custom-links', 'add-category', 'add-post_tag'));
		
	}
	 
/*
 * ========================================================================
 *
 *	Admin toolbar advanced settings toggle
 *
 * ========================================================================
 */
	
	//add_action('wp_before_admin_bar_render', 'skwp_admin_bar_advanced_settings_toggle');
		
	function skwp_admin_bar_advanced_settings_toggle() {
		
		global $wp_admin_bar;
		
		$wp_admin_bar->add_menu(array(
			'id' => 'skwp_advanced_settings_toggle',
			'parent' => 'user-actions',
			'title' => __('Toggle Advanced Settings'),
			'href' => admin_url('profile.php?advanced_settings=toggle'),
			'meta' => false
		));
		
	}
	
/*
 * ========================================================================
 *
 *	Admin CSS
 *
 * ========================================================================
 */

	add_action('admin_head', 'skwp_master_css');
	
	function skwp_master_css() {
		
		$current_user = wp_get_current_user();
		$showAdvancedSettings = get_user_meta($current_user->ID, 'skwp_advanced_settings', true); 
		
		// All users
		echo '<style>
		#wp-admin-bar-wp-logo,
		tr.user-url-wrap,
		tr.user-googleplus-wrap,
		tr.user-twitter-wrap,
		tr.user-facebook-wrap,
		tr.user-description-wrap,
		tr.user-rich-editing-wrap,
		tr.user-comment-shortcuts-wrap {
			display: none;	
		}
		.metabox-holder .postbox-container .empty-container {
			border: none;
		}
		</style>';
		
		// Only users with advanced settings hidden
		if (!$showAdvancedSettings) {
			echo '<style>
			#menu-appearance,
			#menu-plugins,
			#menu-settings,
			#menu-tools,
			#toplevel_page_edit-post_type-acf-field-group,
			#toplevel_page_wpseo_dashboard,
			#wp-admin-bar-wpseo-menu,
			#toplevel_page_itsec,
			#wp-admin-bar-itsec_admin_bar_menu,
			h3#wordpress-seo,
			h3#wordpress-seo + .form-table,
			tr.user-admin-color-wrap {
				display: none;
			}
			</style>';
		}
	}
	
	// Hide logo on login page
	add_action('login_head', 'skwp_hide_login_logo' );
	
	function skwp_hide_login_logo() {
		echo '<style> #login h1 { display: none; } </style>';
	}
	
/*
 * ========================================================================
 *
 *	Top level menus item
 *
 * ========================================================================
 */
	 
	skwp_top_level_menu_item();
	
	function skwp_top_level_menu_item() {
			 
		add_action('admin_menu', 'skwp_add_menu_item');
		
		function skwp_add_menu_item() {
			add_menu_page('Page title', 'Menus', 'manage_options', 'skwp-top-menus', 'skwp_menu_item', 'dashicons-menu', 58);	
		}
		 
		add_action('admin_footer', 'skwp_add_menu_js');
		
		function skwp_add_menu_js() {
			echo '<script>
			var menuItem = document.getElementById("toplevel_page_skwp-top-menus");
			var menuLink = menuItem.getElementsByTagName("a")[0];
			
			var appearanceItem = document.getElementById("menu-appearance");
			var appearanceLink = appearanceItem.getElementsByTagName("a")[0];
			
			var url = window.location.href;
	
			menuLink.setAttribute("href", "nav-menus.php");
	
			if (url.indexOf("nav-menus.php") > -1) {
				appearanceItem.className = appearanceItem.className.replace(/(?:^|\s)wp-has-current-submenu(?!\S)/g, "");
				appearanceLink.className = appearanceLink.className.replace(/(?:^|\s)wp-has-current-submenu(?!\S)/g, "");
				appearanceItem.className = appearanceItem.className + " wp-not-current-submenu";
				
				menuItem.className = menuItem.className + " current";
				menuLink.className = menuItem.className + " current";
			}
			</script>';
		}
	
	}
	
/*
 * ========================================================================
 *
 *	Admin bar site link open in new tab
 *
 * ========================================================================
 */
		 
	add_action('admin_footer', 'skwp_site_link_new_tab');
	
	function skwp_site_link_new_tab() {
		echo '<script>
		var homeLink = document.getElementById("wp-admin-bar-site-name").getElementsByTagName("a")[0].target = "_blank";
		</script>';
	}
	
/*
 * ========================================================================
 *
 *	Admin footer text
 *
 * ========================================================================
 */
 
	add_filter('admin_footer_text', 'skwp_admin_footer');
	
    function skwp_admin_footer () {
    	echo 'Site by <a href="http://www.rowland.com.au/" target="_blank">Rowland</a>.';
    }
	
/*
 * ========================================================================
 *
 *	Admin toolbar front-end styles
 *
 * ========================================================================
 */
	
	add_action('wp_head', 'skwp_admin_bar_css');
	
	function skwp_admin_bar_css() {
		
		if (is_user_logged_in()) {
			echo '<style>
				#wp-admin-bar-wp-logo,
				#wp-admin-bar-wpseo-menu,
				#wp-admin-bar-itsec_admin_bar_menu {
					display: none;
				}
			</style>';
		}
		
	}
	
/*
 * ========================================================================
 *
 *	Force toggle toolbar in tiny mce
 *
 * ========================================================================
 */
 
	add_filter('tiny_mce_before_init', 'skwp_toolbar_toggle');
		
	function skwp_toolbar_toggle($args) {
		$args['wordpress_adv_hidden'] = false;
		return $args;
	}
    
/*
 * ========================================================================
 *
 *	Admin dashboard cleanup
 *
 * ========================================================================
 */
 
    add_action('wp_dashboard_setup', 'skwp_remove_dashboard_widgets');

	function skwp_remove_dashboard_widgets(){
	    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
	    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
	    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
	    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
	    remove_meta_box('dashboard_primary', 'dashboard', 'side');
	    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
	    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
	    remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'normal');
	    remove_meta_box('mandrill_widget', 'dashboard', 'normal');
	}

?>