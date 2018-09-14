$(function()
{
	// submit
	
	$('form').on('submit', function(e)
	{
		$(this).find('input[type="submit"], button[type="submit"], a.cancel').addClass('disabled');
	});
	
	$(document).on('click', '.disabled', function(e){e.preventDefault()});
	
	// select picker
	
	$('.selectpicker').selectpicker();
	
	// spellcheck
	
	$('input[type="text"], input[type="email"], textarea').attr('spellcheck', false);
	
	// reset
	
	$(document).on('click', '.reset', function(e)
	{
		$('.selectpicker').selectpicker('val','');
		
		$('input[type="email"], input[type="text"], textarea, select').val('');
		
		$('input[type="radio"], input[type="checkbox"]').prop('checked', false);
		
		e.preventDefault();
	});
	
	// popover
	
	$('[data-toggle="popover"]').popover({'html':true,'placement':'top','trigger':'focus'})
	
	// new windows
	
	$(document).on('click', '.newin', function(e) { e.preventDefault(); window.open(this.href); });
	
	// modal
	
	$('.sc-notice').modal({show:true});
	
	/**
	 * tmp fix: .dropdown inside table-responsive
	 * from simon21587
	 * @link https://github.com/twbs/bootstrap/issues/11037
	 */
	
	$('.table-responsive').on('shown.bs.dropdown', function (e)
	{
		var t = $(this), 
			m = $(e.target).find('.dropdown-menu'),
			tb = t.offset().top + t.height(),
			mb = m.offset().top + m.outerHeight(true),
			d = 20; // Space for shadow + scrollbar.   
		
		if (t[0].scrollWidth > t.innerWidth())
		{
			if (mb + d > tb)
			{
				t.css('padding-bottom', ((mb + d) - tb)); 
			}
		}
		else
		{
			t.css('overflow', 'visible');
		}
	}).on('hidden.bs.dropdown', function ()
	{
		$(this).css({'padding-bottom': '', 'overflow': ''})
	})
	
	// bootstrap notify default setting
	
	$.notifyDefaults({
		animate: {
			enter: 'animated fadeInRight',
			exit: 'animated fadeOutRight'
		},
		delay: 10000,
		type: 'info',
		newest_on_top: true,
		placement: {from: 'bottom', align: 'right'}
	})
	
});

function round(num, dec)
{
	var result = String(Math.round(num*Math.pow(10,dec))/Math.pow(10,dec));
	if(result.indexOf('.')<0) {result+= '.';}
	while(result.length- result.indexOf('.')<=dec) {result+= '0';}
	return result;
}

function $_GET()
{
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) { vars[key] = value; });
	return vars;
}

function pad(num, size)
{
	let s = num + ""
	while (s.length < size) s = "0" + s
	return s

}
