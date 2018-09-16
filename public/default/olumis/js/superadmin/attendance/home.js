$(function()
{
    let scanner = new Instascan.Scanner({ video: document.getElementById('camera') })

    scanner.addListener('scan', function(content)
    {
        $.post(location.href, {'scan-qrc':'','qr_password':content}, function(response) {})
    })

    Instascan.Camera.getCameras().then(function(cameras)
    {
        if (cameras.length > 0)
        {
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
                update_student_list(response)
            })

            conn.subscribe('active.student', function(topic, response)
            {
                update_student_list(response)
            })

            conn.subscribe('reseted.student', function(topic, response)
            {
                update_student_list(response)
            })
        },
        
        function()
        {
            console.warn('WebSocket Connection Closed')
        },
        
        {'skipSubprotocolCheck': true}
    )
})

function update_student_list(response)
{
    let csc = $('#confirmed-student-container')

    let cs = $('#confirmed-student')

    if (typeof response.students !== 'undefined')
    {
        let students = ''

        cs.html('')

        $.each(response.students, function(i)
        {
            students += '<tr data-user-id="'+ response.students[i].user_id +'"><td>'+ response.students[i].queue_no +'</td><td>'+ response.students[i].fullname +'</td><td>'+ response.students[i].faculty +'</td><td>'+ response.students[i].student_id +'</td></tr>'
        })

        cs.append(students)

        csc.scrollTop(9999)
    }
}