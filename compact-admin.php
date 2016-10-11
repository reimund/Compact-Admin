<?php
/*
Plugin Name: Compact Admin
Plugin URI: http://lumens.se/compact-admin/
Description: Makes the post & pages list in the admin more compact. It also replaces the em dashes with whitespace in the pages list for a cleaner look.
Author: reimund
Version: 1.2.0
Author URI: http://lumens.se/
*/

function admin_scripts() {
	global $pagenow;
	if ('edit.php' == $pagenow && ('page' == $_GET['post_type'] || 'post' == $_GET['post_type'])) {
		wp_enqueue_script('compact-admin', plugins_url(basename(__DIR__) . '/media/js/compact-admin.js'), ['jquery']);
		wp_register_style('compact_admin', plugins_url(basename(__DIR__)) . '/media/css/compact-admin.css', []);
		wp_enqueue_style('compact_admin');
	}
}

add_action('admin_print_scripts-edit.php', 'admin_scripts' );
?>
