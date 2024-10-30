jQuery(document).ready(function($) {
	$('.ajax_submit_form').submit(function(e){
		if($(this).validate().form())
		{
			var data = $(this).serialize();
			data = data + '&action=' + $(this).attr('id');
			var myajax = ajax_post(data);
			myajax.success(function(xml){
				var msg = xml_to_json(xml);
				display_msg(msg);
			});
		}
		e.preventDefault();
	})
	
	function ajax_post(data)
	{
		var this_url = stripDomain(ajaxurl);
		var res = $.ajax({
			url:this_url,
			type: 'post',
			data: data,
			dataType: 'xml',
		});
		return res;
	}
	
	function xml_to_json(xml)
	{
		var res	=	$(xml).find('response_data').text();
		return res;
	}	
	
	function display_msg(str)
	{
		$('#msg').html(str);
		$('#msg').show('fast',function(){
			location.reload();
		});
	}
	
	function stripDomain(str)
	{
		var res = str.replace(/https?:\/\/[^\/]+/i, "");
		return res;
	}
});