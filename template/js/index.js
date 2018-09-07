/**
 * @author charles langkung
 */

if (document.readyState == 'loading')
{
    document.addEventListener('DOMContentLoaded', start)
}
else start()

/**
 * start() is the main function to execute when DOM is ready
 */

function start()
{
    /**
     * add an onclick event listener to the scan button
     */

    document.querySelector('#scan').onclick = function()
    {
        /**
         * let us get the student_id for the first student (listed on top of the table)
         */

        let firststudent = document.querySelector('#student-list tbody tr:first-child')

        let student_id = firststudent.dataset.studentId

        /**
         * let's tell the server to mark this student as 'is_scanned = 1'
         */

        mark_student(student_id)
    }

    /**
     * add an onclick event listener to the reset button
     */

    document.querySelector('#reset').onclick = reset_student

    /**
     * zmq
     */
	
	let conn = new ab.Session('ws://syahril.convo/wss',
			
    function()
    {
        conn.subscribe('mark.student', function(topic, response)
        {
            /**
             * response.data will contain array or unscanned students
             * - to debug just console.log(response.data)
             */

            let studentlist = document.querySelector('#student-list tbody')

            studentlist.innerHTML = ''

            response.data.forEach(function(el,i)
            {
                let tr = document.createElement('tr')

                tr.setAttribute('data-student-id', el.student_id)

                tr.innerHTML += `<td>${el.fullname}</td><td>${el.faculty}</td><td>${el.student_no}</td>`

                studentlist.appendChild(tr)
            })

            /**
             * response.active will contain the currently active student info
             * - to debug just console.log(response.active)
             */
            
            let studentactive = document.querySelector('#student-active tbody')

            studentactive.innerHTML = ''

            let tr = document.createElement('tr')

            tr.setAttribute('data-student-id', response.active.student_id)

            tr.innerHTML += `<td>${response.active.fullname}</td><td>${response.active.faculty}</td><td>${response.active.student_no}</td>`

            studentactive.appendChild(tr)
        })

        conn.subscribe('reset.student', function(topic, response)
        {
            location.href = location.href
        })
    },
    
    function()
    {
        console.warn('WebSocket Connection Closed')
    },
    
    {'skipSubprotocolCheck': true})
}

/**
 * function to
 * send a POST to the server requesting to mark this student as 'is_scanned = 1'
 * we send 2 identities
 * - update
 * - student_id
 */

function mark_student(student_id)
{
    const xhr = new XMLHttpRequest()

    xhr.responseType = 'json'

    xhr.open('POST', '?', true)

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    xhr.onreadystatechange = function()
    {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200)
        {
            // TBD
        }
    }

    xhr.send('update&student_id='+student_id)
}

/**
 * function to
 * send a POST to the server requesting to mark all students as 'is_scanned = 0'
 */

function reset_student()
{
    const xhr = new XMLHttpRequest()

    xhr.responseType = 'json'

    xhr.open('POST', '?', true)

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    xhr.onreadystatechange = function()
    {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200)
        {
            // TBD
        }
    }

    xhr.send('reset')
}
