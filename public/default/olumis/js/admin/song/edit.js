$(function()
{
	$(document).on('click', 'button.browse', function()
	{
		$(this).siblings('#image, #jinglemp3, #mastermp3').click();
	});
	
	$('#image').fileupload(
	{
		dataTpe: 'json',
		
		maxNumberOfFiles: 1,
		
		formData: [{name: 'uploadphoto', value: true}],
		
		add: function(e, data)
		{
			$('.progress-bar').remove();
			
			data.context = $('.songimage .progress').append('<div class="progress-bar" role="progressbar" style="width: 0%"></div>');
			
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
			}
		}
	});
	
	$('#jinglemp3').fileupload(
	{
		dataTpe: 'json',
		
		maxNumberOfFiles: 1,
		
		formData: [{name: 'jinglemp3', value: true}],
		
		add: function(e, data)
		{
			$('.progress-bar').remove();
			
			data.context = $('.jingleaudio .progress').append('<div class="progress-bar" role="progressbar" style="width: 0%"></div>');
			
			data.submit();
			
			$('.browse').hide();
			
			$('.jingleaudio em').text('uploading audio... please wait...')
			
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
				
				$('audio#audio-jingle').attr('src', data.result.data);
			}
		}
	});
	
	$('#mastermp3').fileupload(
	{
		dataTpe: 'json',
		
		maxNumberOfFiles: 1,
		
		formData: [{name: 'mastermp3', value: true}],
		
		add: function(e, data)
		{
			$('.progress-bar').remove();
			
			data.context = $('.masteraudio .progress').append('<div class="progress-bar" role="progressbar" style="width: 0%"></div>');
			
			data.submit();
			
			$('.browse').hide();
			
			$('.masteraudio em').text('uploading audio... please wait...')
			
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
				
				$('audio#audio-master').attr('src', data.result.data);
			}
		}
	});
	
	// image thumbnail
	
	$(document).on('click', '.thumbnail', lightbox);
	
	$(document).on('click', '.lb-prev', lb_prev);
	
	$(document).on('click', '.lb-next', lb_next);
	
	// zmq
	
	let conn = new ab.Session(ws_url,
			
	function()
	{
		conn.subscribe(location.host +'.audio.jingle.status.'+ $_GET()['song_id'], function(topic, response)
		{
			$('.jingleaudio em').html(response.msg)
			
			$.notify({icon:'fa fa-info-circle', message:'<strong>'+response.msg+'</strong>'})
		})
		
		conn.subscribe(location.host +'.audio.master.status.'+ $_GET()['song_id'], function(topic, response)
		{
			$('.masteraudio em').html(response.msg)
			
			$.notify({icon:'fa fa-info-circle', message:'<strong>'+response.msg+'</strong>'})
		})
	},
	
	function()
	{
		console.warn('WebSocket Connection Closed')
	},
	
	{'skipSubprotocolCheck': true})
	
	// speech
	
	$(document).on('click', 'a[name="speech"]', function(e)
	{
		e.preventDefault()
		
		$.get('/admin/song/speech', {}, function(resp)
		{
			$('.th-notice').html(resp)
			
			$('.js-notice').modal({show:true})
			
		}, 'html')
	})
	
	$(document).on('click', '#speech-pagination a', function(e)
	{
		e.preventDefault()
		
		$.get(this.href, {}, function(resp)
		{
			$('.th-notice').html(resp)
			
		}, 'html')
		
		e.preventDefault()
	})

});

function lightbox(e)
{
	e.preventDefault();
	
	var currentImg = $(this).attr('href');
	
	$('.th-notice').html('<div class="lightbox"><div class="clearfix lb-buttons"> <div class="pull-left"><button type="button" type="button" class="btn btn-default lb-prev"><i class="fa fa-angle-double-left fa-lg"></i></button></div>  <div class="pull-right"><button type="button" class="btn btn-default lb-next"><i class="fa fa-angle-double-right fa-lg"></i></button></div></div> <img class="img-responsive" src="'+ currentImg +'" alt=""></div>');
	
	$('.js-notice').modal({show:true});
}

function lb_prev()
{
	var prev_src;
	
	var currentImg = $('.lightbox img')[0].src;
	
	$.each($('a.thumbnail'), function(index, el)
	{
		if (currentImg == $(el).attr('href'))
		{
			if (index == 0) { prev_src = $('a.thumbnail')[ $('a.thumbnail').length - 1 ].href }
			else { prev_src = $('a.thumbnail')[ index - 1 ].href }
		}
	});
	
	$('.th-notice').html('<div class="lightbox"><div class="clearfix lb-buttons"> <div class="pull-left"><button type="button" class="btn btn-default lb-prev"><i class="fa fa-angle-double-left fa-lg"></i></button></div>  <div class="pull-right"><button type="button" class="btn btn-default lb-next"><i class="fa fa-angle-double-right fa-lg"></i></button></div></div> <img class="img-responsive" src="'+ prev_src +'" alt=""></div>');
	
	$('.js-notice').modal({show:true});
}

function lb_next()
{
	var next_src;
	
	var currentImg = $('.lightbox img')[0].src;
	
	$.each($('a.thumbnail'), function(index, el)
	{
		if (currentImg == $(el).attr('href'))
		{
			if (index == ($('a.thumbnail').length - 1)) { next_src = $('a.thumbnail')[ 0 ].href }
			else { next_src = $('a.thumbnail')[ index + 1 ].href }
		}
	});
	
	$('.th-notice').html('<div class="lightbox"><div class="clearfix lb-buttons"> <div class="pull-left"><button type="button" class="btn btn-default lb-prev"><i class="fa fa-angle-double-left fa-lg"></i></button></div>  <div class="pull-right"><button type="button" class="btn btn-default lb-next"><i class="fa fa-angle-double-right fa-lg"></i></button></div></div> <img class="img-responsive" src="'+ next_src +'" alt=""></div>');
	
	$('.js-notice').modal({show:true});
}

