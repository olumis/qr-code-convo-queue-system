
/**
 * @author charles langkung
 */

var ismobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|mobile|CriOS/i;
var source = null;
var audioContex = new (window.AudioContext || window.webkitAudioContext)();
var analyser = audioContex.createAnalyser(); analyser.fftSize = 1024;
var player = $('audio')[0];
var drawVisual = null;
var lastTime = 0;
var vendors = ['ms', 'moz', 'webkit', 'o'];

for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x)
{
	window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
	window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
}

if (!window.requestAnimationFrame)
{
    window.requestAnimationFrame = function (callback, element)
    {
        var currTime = new Date().getTime();
        var timeToCall = Math.max(0, 16 - (currTime - lastTime));
        var id = window.setTimeout(function () { callback(currTime + timeToCall); },timeToCall);
        lastTime = currTime + timeToCall;
        return id;
    };
}

if (!window.cancelAnimationFrame)
{
    window.cancelAnimationFrame = function (id)
    {
        clearTimeout(id);
    };
}

$(function()
{
	// play button
	
	$(document).on('click', '.play', function(e)
	{
		$(this).addClass('hidden');
		
		$(this).siblings('.pause').removeClass('hidden');
		
		if (!$('.track.active').length) $('.track:eq(0)').addClass('active');
    	
		songinfo();
		
		var src = $('.track.active').find('.media').data('media');
		
		player.src = '/audio/preview/' + src;
		
		player.load();
	});
	
	// player event
	
	player.oncanplay = function()
	{
		if (ismobile.test(navigator.userAgent))
		{
			player.play();
		}
		else {
			
			if (!source)
			{
				source = audioContex.createMediaElementSource(player);
			}
			
			source.connect(analyser);
			
			analyser.connect(audioContex.destination);
			
			cancelAnimationFrame(drawVisual);
			
			spectrum(analyser);
			
			$('canvas').show();
			
			player.play();
		}
	};
	
	player.onended = function()
	{
		player.currentTime = 0;
		
		player.src = ''; player.load();
		
		next();
	};
	
	player.ontimeupdate = function()
	{
		$('progress').attr('value', (player.currentTime));
	};
	
	player.onloadedmetadata = function()
	{
		$('progress').attr('max', player.duration);
	};
	
	// pause button
	
	$(document).on('click', '.pause', function()
	{
		$(this).addClass('hidden');
		
		$(this).siblings('.play').removeClass('hidden');
		
		player.currentTime = 0;
		
		player.src = ''; player.load();
		
		$('canvas').hide();
	});
	
	// prev button
	
	$(document).on('click', '.prev', function()
	{
		$('.track.active').prev().trigger('click');
	});
	
	// next button
	
	$(document).on('click', '.next', function()
	{
		next();
	});
	
	// playlist button
	
	$(document).on('click', '.track', function(e)
	{
		$('.track').each(function(i, el){$(el).removeClass('active')});
		
		$(this).addClass('active');
		
		$('.play').trigger('click');
	});
	
	// pagination button
	
	$(document).on('click', '.pagination a', function(e)
	{
		e.preventDefault();
		
		$.post( $(this).attr('href'), {}, function(html)
		{
			$('#tracks-container').html( html );
			
			if (!player.currentTime)
				$('.play').trigger('click');
			
			highlight_current_track();
			
		}, 'html' );
	});
	
	// image thumbnail
	
	$(document).on('click', '.thumbnail', lightbox);
	
	$(document).on('click', '.lb-prev', lb_prev);
	
	$(document).on('click', '.lb-next', lb_next);
	
	// first page load - lyric
	
	
	$('#lyric').html( $('#lyric-body').html() );
	
	// like button
	
	$(document).on('click', '.like', like);
	
	// download button
	
	$(document).on('click', '.download', download);
	
});

$(window).on('load', function()
{
	var canvas = $('canvas')[0];
	
	$(canvas).attr('width', $('progress').width()-2);
});

$(window).on('resize', function()
{
	var canvas = $('canvas')[0];
	
	$(canvas).attr('width', $('progress').width()-2);
});

function spectrum(analyser)
{
	var canvas = $('canvas')[0],
	WIDTH = canvas.width,
	HEIGHT = canvas.height,
	canvasContex = canvas.getContext('2d'),
	gradient = canvasContex.createLinearGradient(0, 0, 0, 100),
	bufferLength = analyser.frequencyBinCount,
	frequencyData = new Uint8Array(bufferLength);
	
	gradient.addColorStop(1, '#0f0');
    gradient.addColorStop(0.3, '#ff0');
    gradient.addColorStop(0, '#f00');
    
    canvasContex.clearRect(0, 0, WIDTH, HEIGHT);
    
    function draw()
    {
    	drawVisual = requestAnimationFrame(draw);
    	
    	analyser.getByteFrequencyData(frequencyData);
    	
    	canvasContex.fillStyle = '#fff';
    	
    	canvasContex.fillRect(0, 0, WIDTH, HEIGHT);
    	
    	var barWidth = (WIDTH / bufferLength) * 2.5;
    	var barHeight;
    	var x = 0;
    	
    	for(var i = 0; i < bufferLength; i++)
    	{
    		barHeight = frequencyData[i]/2;
    		
    		canvasContex.fillStyle = '#337ab7';
    		
    		canvasContex.fillRect(x,HEIGHT-barHeight/2,barWidth,barHeight/2);
    		
    		x += barWidth+1;
    	}
    }
    
    draw();
}

function next()
{
	var nexttrack = $('.track.active').next();
	
	if (nexttrack.length)
	{
		nexttrack.trigger('click');
	}
	else
	{
		if ($('.tracks li').filter(':last').hasClass('active'))
		{
			var pagination = $('.pagination');
			
			if (pagination.length)
			{
				var active = $('.pagination li.active');
				
				var nextpage = active.next().find('a');
				
				if (nextpage.length)
				{
					if (nextpage.text().match(/[0-9]+/))
					{
						nextpage.trigger('click');
					}
				}
				else
				{
					/* last page + last song: go back to page 1 and continue playing */
					
					$('.pagination li a').filter(':first').trigger('click');
					
				}
			}
			else
			{
				/* page 1 + last song: play track number 1 */
				
				$('.tracks li').filter(':first').trigger('click')
			}
		}
		else {
			
			$('.play').trigger('click');
		}
	}
}

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

function songinfo()
{
	var currentInfo = $('.artist-title').data('media');
	
	var currentSong = $('.track.active').find('.media').data('media');
	
	if (currentInfo != currentSong)
	{
		$.get('/songinfo',{'media':currentSong}, function(html)
		{
			$('.song-info').html(html);
			
			$('#lyric').html( $('#lyric-body').html() );
			
		}, 'html');
	}
}

function like()
{
	var currentSong = $('.track.active').find('.media').data('media');
	
	if (currentSong)
	{
		$.post('/like',{'media':currentSong}, function(response)
		{
			
			$('.th-notice').html(response.msg);
			
			$('.js-notice').modal({show:true});
			
		}, 'json');
	}
	else
	{
		$.post('/like',{'media':''}, function(response)
		{
			
			$('.th-notice').html(response.msg);
			
			$('.js-notice').modal({show:true});
			
		}, 'json');
	}
}

function download()
{
	var currentSong = $('.track.active').find('.media').data('media');
	
	if (currentSong)
	{
		location.href = '/order?media='+ currentSong;
	}
	else
	{
		$.get('/order',{'noplay':''}, function(response)
		{
			
			$('.th-notice').html(response.msg);
			
			$('.js-notice').modal({show:true});
			
		}, 'json');
	}
}

function highlight_current_track()
{
	var currentInfo = $('.artist-title').data('media');
	
	$('.track').each(function(i,el)
	{
		var media = $(el).find('.media').data('media')
		
		if (media == currentInfo)
		{
			$(el).addClass('active');
		}
	});
}





