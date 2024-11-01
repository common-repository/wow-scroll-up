<?php
	$wsu_main_option = get_option('wsu_options');
?>


<?php if($wsu_main_option['wsu_button_enable_b'] == '1'){ ?>
<div class="wsu-scrollup-bttn <?php if($wsu_main_option['wsu_button_position'] == 'bottom-left'){echo 'left ';} if($wsu_main_option['wsu_button_style'] == 'circle'){echo 'circle';} if(trim($wsu_main_option['wsu_button_mobile']) == '1'){echo ' mobile';} ?>" style="width: <?php echo $wsu_main_option['wsu_width'] . 'px'; ?>; height: <?php echo $wsu_main_option['wsu_height'] . 'px'; ?>; line-height: <?php echo $wsu_main_option['wsu_height'] . 'px'; ?>; background: <?php echo $wsu_main_option['wsu_bg_color']; ?>;">
	<div class="wsu-hover" style="background: <?php echo $wsu_main_option['wsu_bg_color_hover']; ?>"></div>
	<div class="wsu-img-cont" style="width: <?php echo $wsu_main_option['wsu_icon_size'] . 'px'; ?>; height: <?php echo $wsu_main_option['wsu_icon_size'] . 'px'; ?>;">
		<?php if($wsu_main_option['wsu_button_icon_type'] == 'icon'){ ?>
		<img class="wsu-svg-in" src="<?php echo WSU_PLUGIN_URL . 'img/' . $wsu_main_option['wsu_button_icon'] . '.svg'; ?>">
	    <?php }elseif($wsu_main_option['wsu_button_icon_type'] == 'image'){?>
		<img src="<?php echo wp_get_attachment_url($wsu_main_option['wsu_button_image']); ?>">
	    <?php } ?>
	</div>
</div>
<?php } ?>