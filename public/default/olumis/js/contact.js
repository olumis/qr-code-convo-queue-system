$(function()
{
    $(document).on('change', 'select[name="subject"]', function(e)
    {
        $.post(location.href, {'get_subject_msg':'', 'subject':this.value}, function(resp)
        {
            $('textarea[name="message"]').val(resp);

        }, 'html')
    })
})