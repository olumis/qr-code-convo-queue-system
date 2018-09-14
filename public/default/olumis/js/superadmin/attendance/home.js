$(function()
{
    let scanner = new Instascan.Scanner({ video: document.getElementById('camera') })

    scanner.addListener('scan', function(content)
    {
        $.post(location.href, {'scan-qrc':'','qr_password':content}, function(response)
        {
            
        })
    })

    Instascan.Camera.getCameras().then(function (cameras)
    {
        if (cameras.length > 0)
        {
            scanner.start(cameras[0])
        }
        else
        {
            console.error('No cameras found.')
        }
    }).catch(function(e)
    {
        console.error(e)
    })
})
