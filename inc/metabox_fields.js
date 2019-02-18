jQuery(document).ready(function(){
  var dami_upload_frame;
  var value_id;
  jQuery('.dami_upload_button').live('click',function(event){
    value_id =jQuery( this ).attr('id');
	event.preventDefault();
	if( dami_upload_frame ){
	  dami_upload_frame.open();
	  return;
	}
	
	dami_upload_frame = wp.media({
	  title: '上传图片',
	  button: {
	    text: '上传',
	  },
	  multiple: false
	});
	
	dami_upload_frame.on('select',function(){
	  attachment = dami_upload_frame.state().get('selection').first().toJSON();
	  //jQuery('#'+value_id+'_input').val(attachment.url).trigger('change');
	  jQuery('input[name='+value_id+']').val(attachment.url).trigger('change');
	});
	
	dami_upload_frame.open();
	
	});
	
	jQuery('.damiwp_url_input').each(function(){
	  jQuery(this).bind('change focus blur', function(){
	    $select = '#' + jQuery(this).attr('name') + '_div';
		$value = jQuery(this).val();
		$image = '<img src ="'+$value+'" />';
		var $image = jQuery($select).html('').append($image).find('img');
		window.setTimeout(function(){
		  if(parseInt($image.attr('width')) < 20){
		    jQuery($select).html('');
		  }
		},500);
	  });
	});



	jQuery('.tab-head li').click(function(event) {
		var i = jQuery(this).index();
		jQuery('.tab-head li').removeClass('cur'); 
		jQuery(this).addClass('cur');
		jQuery('.tab-body .dami_metabox').hide();
		jQuery('.tab-body div.dami_metabox:eq('+i+')').fadeIn();

	});

});