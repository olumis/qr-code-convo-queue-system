/**
 * @author Charles Langkung
 */

player = $('audio')[0]

$(function()
{
	$(document).on('click', '.play', play);
	
	$(document).on('click', '.stop', stop);
	
	player.oncanplay = function(e)
	{
		player.play()
	}
	
	player.onended = function(e)
	{		
		stop(e)
	}
});

function play(e)
{
	e.preventDefault();
	
	let media = $(this).data('media')
	
	stop(e)
	
	player.src = '/audio/master/' + media
	
	$(this).addClass('hidden')
	
	$(this).siblings('.stop').removeClass('hidden')
	
	player.load()
}

function stop(e)
{
	e.preventDefault();
	
	player.src = ''
	
	player.load()
	
	$('.play').removeClass('hidden')
	
	$('.stop').addClass('hidden')
}

