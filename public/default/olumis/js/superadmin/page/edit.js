/**
 * @author Charles Langkung
 */

$(function()
{
	$('#summernote').summernote({
		minHeight: 200,
		toolbar: [
			['font', ['bold', 'italic', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['fontsize', ['fontsize']],
            ['view', ['fullscreen', 'codeview']]
        ]
	})
	
	$('#summernote').on('summernote.change', function(we, contents, $editable) {
		$('[name="page_content"]').val(contents);
	})
	
	$(document).on('submit', 'form:eq(0)', function(e)
	{
		e.preventDefault()
		
		$.post(location.href, 'edit_page&' + $(this).serialize(), function(resp)
		{
			$('input[type="submit"], button[type="submit"], a.cancel').removeClass('disabled')
			
			if (resp.status == 'error')
			{
				$('.th-notice').removeClass('text-center').html(resp.msg)
				
				$('.js-notice').modal({show:true})
			}
			else location.href = resp.return
			
		}, 'json')
	})
})
