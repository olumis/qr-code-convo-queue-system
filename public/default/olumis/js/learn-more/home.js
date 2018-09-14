/**
 * @author Charles Langkung
 */

$(function()
{
	$('.lead').each(function(i, el)
	{
		$(this).css({'cursor':'pointer'})
		
		$(this).next().toggle(false)
		
		
	})
	
	$(document).on('click', '.lead', function(e)
	{
		$('.lead').next().toggle(false)
		
		$(this).next().toggle(true)
		
		$('html, body').animate({ scrollTop: 0 }, 'slow');
	})
	
	if (location.hash)
	{
		setTimeout(function(){ $('[name="'+ location.hash.substring(1) +'"]').trigger('click') },300)
	}
})