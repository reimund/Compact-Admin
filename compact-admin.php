<?php
/*
Plugin Name: Compact Admin
Plugin URI: http://lumens.se/compact-admin/
Description: Makes the post & pages list in the admin more compact. It also replaces the em dashes with whitespace in the pages list for a cleaner look.
Author: reimund
Version: 1.3.0
Author URI: http://lumens.se/
*/

function ca_admin_scripts() {
	global $pagenow;
	$enabled_post_types = get_option('ca_enabled_post_types');

	if (empty($enabled_post_types)) {
		$enabled_post_types = ['post', 'page'];
	}
	else {
		$enabled_post_types = explode(',', str_replace(', ', ',', $enabled_post_types));
	}
	
	if ($pagenow === 'edit.php' && in_array($_GET['post_type'], $enabled_post_types)) {
		wp_enqueue_script('compact-admin', plugins_url(basename(__DIR__) . '/media/js/compact-admin.js'), ['jquery']);
		wp_register_style('compact_admin', plugins_url(basename(__DIR__)) . '/media/css/compact-admin.css', []);
		wp_enqueue_style('compact_admin');
	}
}

function ca_settings_section_cb() {
	echo '<p>Configure what parts of the admin Compact Admin should alter.</p>';
}
function ca_enable_post_types_cb() {
	$types = get_option('ca_enabled_post_types');

	if (empty($types)) {
		$types = 'post, page';
	}

	echo '<input name="ca_enabled_post_types" id="ca_enabled_post_types" type="text" value="' . $types . '" class="code">'
	. '<br><small>Comma separated list of post types</small>';
}

function ca_register_settings() {
	$section_id = 'ca_settings_section';
	$setting_id = 'ca_enabled_post_types';

	add_settings_section(
		$section_id,
		'Main settings',
		'ca_settings_section_cb',
		'compact-admin-settings'
	);
	add_settings_field(
		$setting_id,
		'Enabled post types',
		'ca_enable_post_types_cb',
		'compact-admin-settings',
		$section_id,
	);

	register_setting($section_id, $setting_id);
}

function ca_settings_init() {
	// Shouldn't update_option be called automatically?
	if (!empty($_POST['ca_enabled_post_types'])) {
		update_option('ca_enabled_post_types', $_POST['ca_enabled_post_types']);
	}

	?>
		<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
	   
		<!-- run the settings_errors() function here. -->
		<?php settings_errors(); ?>
		<h1>Compact Admin settings</h1>
	   
		<form method="post" action="options-general.php?page=compact-admin-settings" enctype="multipart/form-data">
			<?php
				settings_fields('ca_settings_section');

				// all the add_settings_field callbacks is displayed here
				do_settings_sections('compact-admin-settings');

				submit_button('Save changes');
			?>          
		</form>
	</div>
	<?php
}

function ca_admin_menu() {
	add_options_page('Compact Admin settings', 'Compact Admin', 'manage_options', 'compact-admin-settings', 'ca_settings_init');
}

add_action('admin_menu', 'ca_admin_menu', 9);    
add_action('admin_init', 'ca_register_settings', 9);    
add_action('admin_print_scripts-edit.php', 'ca_admin_scripts' );
?>
