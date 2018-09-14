$(function()
{
    let scanner = new Instascan.Scanner({ video: document.getElementById('camera') })

    scanner.addListener('scan', function(content)
    {
        $.post(location.href, {'scan-qrc':'','qr_password':content}, function(response) {})
    })

    Instascan.Camera.getCameras().then(function (cameras)
    {
        if (cameras.length > 0) {
            scanner.start(cameras[0])
        }
        else {
            console.error('No cameras found.')
        }
    }).catch(function(e) {
        console.error(e)
    })

	// zmq
	
	let conn = new ab.Session(ws_url,
			
        function()
        {
            conn.subscribe('confirmed.student', function(topic, response)
            {
                let nextstudent = '<tr><td>'+ response.student.fullname +'</td><td>'+ response.student.faculty +'</td></tr>'

                $('#confirmed-student').append(nextstudent)
            })
        },
        
        function()
        {
            console.warn('WebSocket Connection Closed')
        },
        
        {'skipSubprotocolCheck': true})
})
