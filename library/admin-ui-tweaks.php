<?php

/*
 * DASHBOARD WIDGETS
*/
// Comment the Dashboard widgets you would like to keep.
function remove_dashboard_widgets(){
	global$wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_addthis']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['events_dashboard_window']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

	remove_meta_box('symposium_id', 'dashboard', 'normal'); // WP Symposium (if you use it)
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // right now
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // recent comments
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // incoming links
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // plugins
	remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');  // quick press
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');  // Yoast Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');  // recent drafts
	remove_meta_box('dashboard_primary', 'dashboard', 'normal');   // wordpress blog
	remove_meta_box('dashboard_secondary', 'dashboard', 'normal');   // other wordpress news

}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');


/*
 * FRONTEND DEFAULT WIDGETS
*/
// Comment the frontend widgets you would like to keep.

function remove_frontend_wp_widgets(){
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_RSS' );
}
add_action('widgets_init','remove_frontend_wp_widgets', 1);

/*
 *  ADMINISTRATION LEFTSIDE MENU
*/
/* Cleanup the left admin sidebar */
function cleanup_admin_leftside_menu() {

	global $menu;
	// Remove from this menu those menu items that should not be removed...
	$restricted = array(__('Posts'),__('Links'), __('Comments'), __('Separator'));

	end($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)) {
			unset($menu[key($menu)]);
		}
	}
}
add_action('admin_menu', 'cleanup_admin_leftside_menu');

/*
 *  ADMINISTRATION TOPRIGHT SHORTCUTS MENU
*/
function cleanup_topright_shortcuts_menu($actions) {
	unset($actions['edit-comments.php']);
	unset($actions['post-new.php']);
	return $actions;
}
add_filter('favorite_actions', 'cleanup_topright_shortcuts_menu');


/*
 * MEDIA UPLOAD INTERFACE CLEANUP 
*/

function media_upload_interface_cleanup($form_fields) {
	$form_fields['image_description']['input'] = 'hidden';
	$form_fields['image_alt']['value'] = sanitize_title($form_fields['post_title']['value']);
	$form_fields['image_alt']['input'] = 'hidden';
	$form_fields['post_excerpt']['value'] = '';
	$form_fields['post_excerpt']['input'] = 'hidden';
	$form_fields['post_content']['value'] = '';
	$form_fields['post_content']['input'] = 'hidden';
	$form_fields['url']['value'] = '';
	$form_fields['url']['input'] = 'hidden';
	$form_fields['align']['value'] = 'aligncenter';
	$form_fields['align']['input'] = 'hidden';
	$form_fields['image-size']['value'] = 'thumbnail'; // Change the value to the size at which images should be inserted in the post body.
	//$form_fields['image-size']['input'] = 'hidden';
	//$form_fields['image-caption']['value'] = 'caption';
	//$form_fields['image-caption']['input'] = 'hidden';
	//$form_fields['buttons']['input'] = 'hidden';
	return $form_fields;
}


add_filter('attachment_fields_to_edit', 'media_upload_interface_cleanup', 15, 2);


/*
 *	POST' WYSIWYG EDITOR	
*/
// Add buttons to wysiwyg editor
function enable_more_buttons($buttons) {
	// More buttons: http://www.tinymce.com/wiki.php/Buttons/controls
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'styleselect';
	return $buttons;
}
