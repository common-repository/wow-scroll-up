jQuery(function($) {
	$('.wsu-svg-in').svgInject(function() {
		$('.wsu-scrollup-bttn svg, .wsu-scrollup-bttn svg *').attr('style', 'fill: '+wsu_icon_color+' !important; stroke: '+wsu_icon_color+' !important');
	});
    
    var windowPos = $(document).scrollTop();
 	if(windowPos >= wsu_button_visible_from){
		$('.wsu-scrollup-bttn').addClass('visible');
	}else if(windowPos < wsu_button_visible_from){
		$('.wsu-scrollup-bttn').removeClass('visible');
	}

    $(window).scroll(function(){
    	var scrollPos = $(document).scrollTop();
        if(scrollPos >= wsu_button_visible_from){
        	$('.wsu-scrollup-bttn').addClass('visible');
    	}else if(scrollPos < wsu_button_visible_from){
        	$('.wsu-scrollup-bttn').removeClass('visible');
    	}
	});

	$('.wsu-scrollup-bttn').click(function(){
		$('html, body').animate({
			scrollTop: 0
		}, wsu_speed);
	});
});