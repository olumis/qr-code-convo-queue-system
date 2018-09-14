/**
 * @author Charles Langkung
 */

$(function()
{
	$(document).on('input', '.price-range', setprice);
	
	$('.price').html(round($('.price-range').val(),2));
});

function setprice()
{
	$('.price').html(round(this.value,2));
}

