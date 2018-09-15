$(function()
{
	$(document).on('click', 'button.browse', function()
	{
		$(this).siblings('#image').click();
	});
	
	$('#image').fileupload(
	{
		dataTpe: 'json',
		
		maxNumberOfFiles: 1,
		
		formData: [{name: 'upload', value: true}, {value: $('#nonce').val()}],
		
		add: function(e, data)
		{
			$('.progress-bar').remove();
			
			data.context = $('.progress').append('<div class="progress-bar" role="progressbar" style="width: 0%"></div>');
			
			data.submit();
			
			$('.browse').hide();
			
			$('.progress').show();
		},
		
		progress: function(e, data)
		{
			var progress = parseInt(data.loaded / data.total * 100, 10);
			
			data.context.find('.progress-bar').css({ 'width': progress + '%'});
		},
		
		fail:function(e, data)
		{
			
		},
		
		done: function(e, data)
		{
			if (data.result.status == 'error' && data.result.data.length > 0)
			{
				var html = '';
				
				for (var i=0; i < data.result.data.length; i++)
				{
					html += '<div><i class="fa fa-fire"></i> '+ data.result.data[i] +'</div>';
				}
				
				$('.th-notice').html(html);
				
				$('.js-notice').modal({show:true,backdrop:'static'});
				
				data.context.find('.progress-bar').css({ 'width':'0'});
				
				$('.browse').show();
			}
			else
			{
				$('.progress').html('');
				
				$('.progress, .browse').show();
				
				$('.thumb:eq(0)').before(data.result.data);
				
				$('.thumb:eq(1)').remove();

				$('#has-profile-pic').html('<input type="hidden" name="has_profile_pic">')
			}
		}
	});
	
	$(document).on('click', '.thumbnail', function(e)
	{
		e.preventDefault();
		
		$('.th-notice').html('<img class="img-responsive" src="'+ $(this).attr('href') +'" alt="">');
		
		$('.js-notice').modal({show:true});
	});
});