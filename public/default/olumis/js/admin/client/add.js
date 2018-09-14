
$(function()
{
    $(document).on('click', 'a.xhraddclient', function(e)
    {
        e.preventDefault()

        $.post(location.href, {'client':'','client_id' : this.dataset.clientId}, function(response)
        {
            if (response.status == 'error')
            {
                $('.th-notice').html(response.data)
                
                $('.js-notice').modal({show:true})
            }
            else location.href = response.url

        },'json')
    })
})