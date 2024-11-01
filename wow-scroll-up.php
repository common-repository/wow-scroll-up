<?php 
/*
Plugin Name: Wow scroll up
Description: This plugin allows you to easily scroll back to the top of the page.
Version: 1.2
Author: WebArea | Vera Nedvyzhenko
Author URI: https://profiles.wordpress.org/veradeveloper/
*/

// -------------------------------------------
// Define param

define('WSU_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('WSU_PLUGIN_URL', plugin_dir_url( __FILE__ ));

// -------------------------------------------

// -------------------------------------------
//Enqueue scripts & styles
function wsu_admin_scripts(){
	wp_enqueue_style('wsu_admin_select2', plugins_url('css/select2.min.css', __FILE__));
	wp_enqueue_style('wsu_admin_style', plugins_url('css/admin.css', __FILE__));

	wp_enqueue_media();
    wp_enqueue_style('wp-color-picker'); 
	wp_enqueue_script('wsu_admin_select2_script', plugins_url('js/select2.min.js', __FILE__));
	wp_enqueue_script('wsu_admin_script', plugins_url('js/admin.js', __FILE__), array('jquery', 'wp-color-picker'), false, true);
	wp_localize_script('wsu_admin_script', 'wsu_plugin_url', WSU_PLUGIN_URL);
}

add_action('admin_enqueue_scripts', 'wsu_admin_scripts');

function wsu_scripts(){
	wp_enqueue_style('wsu_styles', plugins_url('css/style.css', __FILE__));
	wp_enqueue_script('jquery', false, array('jquery'));
	wp_enqueue_script('wsu_svginject_script', plugins_url('js/jquery.svgInject.js', __FILE__));
	wp_enqueue_script('wsu_main_script', plugins_url('js/main.js', __FILE__));
	$wsu_main_option = get_option('wsu_options');
	wp_localize_script('wsu_main_script', 'wsu_icon_color', $wsu_main_option['wsu_icon_color']);
	wp_localize_script('wsu_main_script', 'wsu_button_visible_from', $wsu_main_option['wsu_button_visible_from']);
	wp_localize_script('wsu_main_script', 'wsu_speed', $wsu_main_option['wsu_speed']);
}

add_action('login_enqueue_scripts', 'wsu_scripts');
add_action('wp_enqueue_scripts', 'wsu_scripts' );

// -------------------------------------------

// -------------------------------------------
// Add Settings Page

function wsu_settings_page(){
	add_options_page( 'Wow scroll up', 'Wow scroll up', 'manage_options', 'wow_scroll_up_settings', 'wow_scroll_up_page_content' );
}

add_action('admin_menu', 'wsu_settings_page');

function wow_scroll_up_page_content(){
	?>
	<div class="wrap wsu_wrap">
		<h1>Wow scroll up settings</h1>

		<form action="options.php" method="POST">
			<?php
				settings_fields( 'wsu_option_group' );
				do_settings_sections( 'wsu_settings_page' );
				submit_button();
			?>
		</form>
	</div>
	<div class="wrap wsu_wrap webarea">
		<a href="//webarea.com.ua/" target="_blank">
			<img src="<?php echo WSU_PLUGIN_URL . 'img/logo-black.svg'; ?>" alt="">
			<p>Need a website, custom plugin or website help</p>
		</a>
	</div>
	<?php
}

// -------------------------------------------

// -------------------------------------------
// Register Settings

function wsu_register_settings(){
	register_setting('wsu_option_group', 'wsu_options');
	add_settings_section('wsu_section_general_st', 'General Settings', '', 'wsu_settings_page' );
	add_settings_section('wsu_section_colors_st', 'Colors Settings', '', 'wsu_settings_page' );
	add_settings_section('wsu_section_effects_st', 'Effects Settings', '', 'wsu_settings_page' );

	add_settings_field('wsu_button_enable_b', 'Enable Button', 'wsu_button_enable_fill', 'wsu_settings_page', 'wsu_section_general_st' );
	add_settings_field('wsu_button_icon_type', 'Button Icon Type', 'wsu_button_icon_type_fill', 'wsu_settings_page', 'wsu_section_general_st' );

	add_settings_field('wsu_button_image', 'Button Image', 'wsu_button_image_fill', 'wsu_settings_page', 'wsu_section_general_st' );
	add_settings_field('wsu_button_icon', 'Button Icon', 'wsu_button_icon_fill', 'wsu_settings_page', 'wsu_section_general_st' );

	add_settings_field('wsu_icon_size', 'Icon Size (px)', 'wsu_icon_size_fill', 'wsu_settings_page', 'wsu_section_general_st' );
	add_settings_field('wsu_height', 'Height (px)', 'wsu_height_fill', 'wsu_settings_page', 'wsu_section_general_st' );
	add_settings_field('wsu_width', 'Width (px)', 'wsu_width_fill', 'wsu_settings_page', 'wsu_section_general_st' );
	add_settings_field('wsu_speed', 'Scroll Speed', 'wsu_speed_fill', 'wsu_settings_page', 'wsu_section_general_st' );
	add_settings_field('wsu_icon_color', 'Button Icon Color', 'wsu_icon_color_fill', 'wsu_settings_page', 'wsu_section_colors_st' );
	add_settings_field('wsu_bg_color', 'Button Background Color', 'wsu_bg_color_fill', 'wsu_settings_page', 'wsu_section_colors_st' );
	add_settings_field('wsu_bg_color_hover', 'Button Background Color Hover', 'wsu_bg_color_hover_fill', 'wsu_settings_page', 'wsu_section_colors_st' );
	add_settings_field('wsu_button_position', 'Button Position', 'wsu_button_position_fill', 'wsu_settings_page', 'wsu_section_effects_st' );
	add_settings_field('wsu_button_visible_from', 'Hide From Top (px)', 'wsu_button_visible_from_fill', 'wsu_settings_page', 'wsu_section_effects_st' );
	add_settings_field('wsu_button_style', 'Button Style', 'wsu_button_style_fill', 'wsu_settings_page', 'wsu_section_effects_st' );
	add_settings_field('wsu_button_mobile', 'Disable On Mobile', 'wsu_button_mobile_fill', 'wsu_settings_page', 'wsu_section_effects_st' );
}

add_action('admin_init', 'wsu_register_settings');

function wsu_button_enable_fill(){
	$val = get_option('wsu_options')['wsu_button_enable_b'];
	?>
	<input type="hidden" name="wsu_options[wsu_button_enable_noval]" value="1">
	<div class="wsu-checkbox">
		<input type="checkbox" name="wsu_options[wsu_button_enable_b]" value="1"<?php checked( 1 == $val ); ?> />
		<label></label>
	</div>
	<?php
}

function wsu_button_icon_type_fill(){
	$val = get_option('wsu_options')['wsu_button_icon_type'];
	?>
	<div class="wsu-radio">
		<input id="wsu_button_icon_type_icon" type="radio" name="wsu_options[wsu_button_icon_type]" value="icon"<?php checked('icon' == $val ); ?> />
		<label for="wsu_button_icon_type_icon">Icon</label>
		<input id="wsu_button_icon_type_image" type="radio" name="wsu_options[wsu_button_icon_type]" value="image"<?php checked('image' == $val ); ?> />
		<label for="wsu_button_icon_type_image">Image</label>
	</div>
	<?php
}

function wsu_button_image_fill(){
	$val = get_option('wsu_options')['wsu_button_image'];
	?>
		<div class="wsu-upload-image">
			<input type="hidden" name="wsu_options[wsu_button_image]" value="<?php echo esc_attr( $val ) ?>">
			<?php if(esc_attr( $val ) != ''){ ?>
				<div class="wsu-upload-image-preview">
					<img src="<?php echo wp_get_attachment_url(esc_attr( $val )); ?>">
					<div class="wsu-upload-image-delete">+</div>
				</div>
			<?php }else{ ?>
				<div class="wsu-upload-image-preview">
				</div>
				<input class="button-secondary" id="wsu_upload_image_button" type="button" value="Upload File" />
			<?php } ?>
		</div>
	<?php
}

function wsu_button_icon_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_button_icon'];
	?>
	<div class="wsu-slect-icn">
		<select class="wsu-select-icn" name="wsu_options[wsu_button_icon]">
			<option value="black-circle-background" <?php selected($val, "black-circle-background"); ?>>Black Circle Background</option>
			<option value="caret-arrow-up" <?php selected($val, "black-circle-background"); ?>>Caret Arrow Up</option>
			<option value="square-box-outline" <?php selected($val, "square-box-outline"); ?>>Square Box Outline</option>
			<option value="up-arrow" <?php selected($val, "up-arrow"); ?>>Up Arrow 1</option>
			<option value="up-arrow-2" <?php selected($val, "up-arrow-2"); ?>>Up Arrow 2</option>
			<option value="arrow-up" <?php selected($val, "arrow-up"); ?>>Up Arrow 3</option>
			<option value="up-arrow-key" <?php selected($val, "up-arrow-key"); ?>>Up Arrow Key</option>
			<option value="up-chevron-button" <?php selected($val, "up-chevron-button"); ?>>Up Chevron Button</option>
			<option value="upload-button" <?php selected($val, "upload-button"); ?>>Upload Button</option>
			<option value="chevron-up" <?php selected($val, "chevron-up"); ?>>Chevron Up</option>
		</select>
		<i>(button icon)</i>
	</div>
	<?php
}

function wsu_icon_size_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_icon_size'];
	?>
	<input class="wsu-simple-inp" type="number" name="wsu_options[wsu_icon_size]" value="<?php echo esc_attr( $val ) ?>" />
	<i>(icon size in px)</i>
	<?php
}

function wsu_height_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_height'];
	?>
	<input class="wsu-simple-inp" type="number" name="wsu_options[wsu_height]" value="<?php echo esc_attr( $val ) ?>" />
	<i>(button height in px)</i>
	<?php
}

function wsu_width_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_width'];
	?>
	<input class="wsu-simple-inp" type="number" name="wsu_options[wsu_width]" value="<?php echo esc_attr( $val ) ?>" />
	<i>(button width in px)</i>
	<?php
}

function wsu_speed_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_speed'];
	?>
	<input class="wsu-simple-inp" type="number" name="wsu_options[wsu_speed]" value="<?php echo esc_attr( $val ) ?>" />
	<i>(in millisecond (1000ms = 1sec))</i>
	<?php
}

function wsu_icon_color_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_icon_color'];
	?>
	<input type="text" class="wsu_colorpicker" name="wsu_options[wsu_icon_color]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

function wsu_bg_color_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_bg_color'];
	?>
	<input type="text" class="wsu_colorpicker" name="wsu_options[wsu_bg_color]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

function wsu_bg_color_hover_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_bg_color_hover'];
	?>
	<input type="text" class="wsu_colorpicker" name="wsu_options[wsu_bg_color_hover]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

function wsu_button_position_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_button_position'];
	?>
	<select name="wsu_options[wsu_button_position]">
		<option value="bottom-right" <?php selected($val, "bottom-right"); ?>>Bottom Right</option>
		<option value="bottom-left" <?php selected($val, "bottom-left"); ?>>Bottom Left</option>
	</select>
	<?php
}

function wsu_button_visible_from_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_button_visible_from'];
	?>
	<input class="wsu-simple-inp" type="number" name="wsu_options[wsu_button_visible_from]" value="<?php echo esc_attr( $val ) ?>" />
	<i>(hide button from px from top, set 0 for visibility on complete page)</i>
	<?php
}

function wsu_button_style_fill(){
	$val = get_option('wsu_options');
	$val = $val['wsu_button_style'];
	?>
	<select name="wsu_options[wsu_button_style]" value="<?php echo esc_attr( $val ) ?>">
		<option value="square" <?php selected($val, "square"); ?>>Square</option>
		<option value="circle" <?php selected($val, "circle"); ?>>Circle</option>
	</select>
	<?php
}

function wsu_button_mobile_fill(){
	$val = get_option('wsu_options')['wsu_button_mobile'];
	?>
	<div class="wsu-checkbox">
		<input type="checkbox" name="wsu_options[wsu_button_mobile]" value="1"<?php checked( 1 == $val ); ?> />
		<label></label>
	</div>
	<?php
}
// -------------------------------------------

// -------------------------------------------
// Set Option Default Value
add_action('admin_init', 'wsu_default_options_v');
function wsu_default_options_v(){
	$wsu_main_option = get_option('wsu_options');
	if(empty($wsu_main_option)){
		$wsu_main_option['wsu_button_enable_b'] = 1;
		$wsu_main_option['wsu_button_icon_type'] = 'icon';
		$wsu_main_option['wsu_button_icon'] = 'up-arrow';
		$wsu_main_option['wsu_icon_size'] = '40';
		$wsu_main_option['wsu_height'] = '60';
		$wsu_main_option['wsu_width'] = '60';
		$wsu_main_option['wsu_speed'] = '300';
		$wsu_main_option['wsu_icon_color'] = '#fff';
		$wsu_main_option['wsu_bg_color'] = '#000';
		$wsu_main_option['wsu_bg_color_hover'] = '#ccc';
		$wsu_main_option['wsu_button_position'] = 'bottom-right';
		$wsu_main_option['wsu_button_visible_from'] = '600';
		$wsu_main_option['wsu_button_style'] = 'square';
		$wsu_main_option['wsu_button_mobile'] = '';
		update_option('wsu_options', $wsu_main_option);
	}

	if(!empty($wsu_main_option)){
		if(!array_key_exists('wsu_button_icon_type', $wsu_main_option)){
			$wsu_main_option['wsu_button_icon_type'] = 'icon';
		}

		if(!array_key_exists('wsu_button_enable_noval', $wsu_main_option)){
			$wsu_main_option['wsu_button_enable_b'] = 1;
			$wsu_main_option['wsu_button_enable_noval'] = 1;
		}
		update_option('wsu_options', $wsu_main_option);
	}
}
// -------------------------------------------

// -------------------------------------------
// Frontend

function wsu_frontend(){
	require_once( WSU_PLUGIN_PATH . 'wow-scroll-button.php');
}

add_action('wp_head', 'wsu_frontend');

// -------------------------------------------
?>