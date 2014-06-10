<?php
/*
Plugin Name: Compact Admin
Plugin URI: http://lumens.se/compact-admin/
Description: Makes the post & pages list in the admin more compact. It also replaces the em dashes with whitespace in the pages list for a cleaner look.
Author: reimund
Version: 1.1
Author URI: http://lumens.se/
*/

function compact_admin_head()
{
	echo '<link rel="stylesheet" type="text/css" href="' . plugins_url(basename(dirname(__FILE__))) . '/media/css/compact-admin.css" />';
}

function admin_scripts() {
	wp_enqueue_script('compact-admin', plugins_url(basename(dirname(__FILE__)) . '/media/js/compact-admin.js'), array('jquery'));
}

add_action('admin_head', 'compact_admin_head');
add_action( 'admin_print_scripts-edit.php', 'admin_scripts' );
?>
