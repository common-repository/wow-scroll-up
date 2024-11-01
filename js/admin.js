jQuery(function($) {
	
  $('.wsu_colorpicker').wpColorPicker();

  function formatState (state) {
    if (!state.id) {
      return state.text;
    }
    var baseUrl = wsu_plugin_url;
    var $state = $(
      '<span><img src="' + baseUrl + 'img/' + state.element.value.toLowerCase() + '.svg" class="wsu-img-icon" /> ' + state.text + '</span>'
    );
    return $state;
  };

  $(".wsu-select-icn").select2({
    templateResult: formatState
  });

  $('body').on('click', '#wsu_upload_image_button', wsu_open_media_window);

  function wsu_open_media_window() {
    this.window = wp.media({
      title: 'Add file',
      multiple: false,
      library: {
        type: 'image/jpeg, image/gif, image/png, image/bmp, image/tiff, image/x-icon, image/svg',
      },
      button: {text: 'Insert'}
    });

    var self = this;
    this.window.on('select', function() {
      var file = self.window.state().get('selection').first().toJSON();
      $('input[name="wsu_options[wsu_button_image]"]').val(file.id);
      $('.wsu-upload-image').find('.button-secondary').remove();
      $('.wsu-upload-image-preview').append('<img src="'+file.url+'">');
      $('.wsu-upload-image-preview').append('<div class="wsu-upload-image-delete">+</div>');
    });

    this.window.open();
    return false;
  }

  $('.wsu-upload-image-preview').on('click', '.wsu-upload-image-delete', function(){
    $(this).parent().html('');
    $('input[name="wsu_options[wsu_button_image]"]').val('');
    $('.wsu-upload-image').append('<input class="button-secondary" id="wsu_upload_image_button" type="button" value="Upload File" />');
  });

  function wsu_image_type(inputVal){
    if(inputVal == 'icon'){
      $('.wsu-upload-image').closest('tr').css('display', 'none');
      $('.wsu-slect-icn').closest('tr').css('display', 'table-row');
    }else if(inputVal == 'image'){
      $('.wsu-slect-icn').closest('tr').css('display', 'none');
      $('.wsu-upload-image').closest('tr').css('display', 'table-row');
    }
  }

  wsu_image_type($('input[name="wsu_options[wsu_button_icon_type]"]:checked').val());

  $('input[name="wsu_options[wsu_button_icon_type]"]').on('change', function(){
    wsu_image_type($(this).val());
  });

});