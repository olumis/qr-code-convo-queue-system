$(function()
{
	// zmq
	
	let conn = new ab.Session(ws_url,
			
        function()
        {
            let profile_pic = $('#profile-pic')

            let fullname = $('#fullname')

            let faculty = $('#faculty')

            conn.subscribe('activated.student', function(topic, response)
            {
                if (typeof response.students !== 'undefined')
                {
                    let csc = $('#confirmed-student-container')

                    let cs = $('#confirmed-student')

                    let students = ''

                    cs.html('')

                    $.each(response.students, function(i)
                    {
                        students += '<tr data-user-id="'+ response.students[i].user_id +'"><td>'+ response.students[i].queue_no +'</td><td>'+ response.students[i].fullname +'</td><td>'+ response.students[i].faculty +'</td><td>'+ response.students[i].student_id +'</td></tr>'
                    })

                    cs.append(students)

                    csc.scrollTop(0)
                }

                if (typeof response.astudent !== 'undefined')
                {
                    let img = $('<img src="/img/profile/'+ response.astudent.dimension.thumb +'" style="border-radius: 50%;">')

                    img.on('load', function()
                    {
                        fullname.html(response.astudent.fullname)

                        faculty.html(response.astudent.faculty)

                        profile_pic.html(img)
                    })
                }
            })

            conn.subscribe('reseted.student', function(topic, response)
            {
                if (typeof response.students !== 'undefined')
                {
                    let csc = $('#confirmed-student-container')

                    let cs = $('#confirmed-student')

                    let students = ''

                    cs.html('')

                    $.each(response.students, function(i)
                    {
                        students += '<tr data-user-id="'+ response.students[i].user_id +'"><td>'+ response.students[i].queue_no +'</td><td>'+ response.students[i].fullname +'</td><td>'+ response.students[i].faculty +'</td><td>'+ response.students[i].student_id +'</td></tr>'
                    })

                    cs.append(students)

                    csc.scrollTop(0)
                }
                
                if (typeof response.reset !== 'undefined')
                {
                    let img = $('<img src="/default/olumis/img/holder.png" style="border-radius: 50%;">')

                    img.on('load', function()
                    {
                        fullname.html('Student Name')

                        faculty.html('Faculty')

                        profile_pic.html(img)

                        csc.scrollTop(0)
                    })
                }
            })
        },
        
        function()
        {
            console.warn('WebSocket Connection Closed')
        },
        
        {'skipSubprotocolCheck': true}
    )

    // go button

    $(document).on('click', '#go', function()
    {
        let topstudent = $('#confirmed-student tr:eq(0)')

        let topstudent_user_id = $(topstudent).data('user-id')

        if (topstudent.length)
        {
            $.post(location.href, {'go':'', 'user_id':topstudent_user_id}, function() {})
        }
    })

    // reset button

    $(document).on('click', '#reset', function()
    {
        let topstudent = $('#confirmed-student tr:eq(0)')

        $.post(location.href, {'reset':''}, function() {})
    })
})
