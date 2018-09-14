$(function()
{
	$(document).on('click', '.vote', function(e)
	{
		$.post($(this).data('vote-url'), {'vote':true,'song_id':$(this).data('song-id')}, function(data)
		{
			$('.th-notice').html(data.msg);
			
			$('.js-notice').modal({show:true,backdrop:'static'});
			
		},'json');
		
		e.preventDefault();
	});
	
	$(document).on('click', '#topten .play', function(e)
	{
		$('#player .pause').click(); // player stop all
		
		$('#topten .pause').click(); // topten stop all
		
		$(this).addClass('hidden');
		
		$(this).siblings('.pause').removeClass('hidden');
    	
		var player = document.getElementById('audio');
		
		var src = $(this).data('src');
		
		$(player).removeAttr('src');
		
		player.load();
		
		$(player).attr('src', src);
		
		player.play();
		
		player.addEventListener('ended', function()
		{
			player.currentTime = 0;
			
			$('#topten .pause').click(); // stop all
		});
	});
	
	$(document).on('click', '#topten .pause', function()
	{
		$(this).addClass('hidden');
		
		$(this).siblings('.play').removeClass('hidden');
		
		var player = document.getElementById('audio');
		
		$(player).removeAttr('src');
		
		player.load();
	});
	
	$(document).on('click', '.thumbnail', function(e)
	{
		e.preventDefault();
		
		$('.th-notice').html('<img class="img-responsive" src="'+ $(this).attr('href') +'" alt="">');
		
		$('.js-notice').modal({show:true,backdrop:'static'});
	});
});
