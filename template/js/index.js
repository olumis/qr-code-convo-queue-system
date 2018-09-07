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
         * let us clone the first student (listed on top of the table) before we remove it
         */

        let firststudent = document.querySelector('#student-list tbody tr:first-child')

        let cloned = firststudent.cloneNode(true)

        let student_id = firststudent.dataset.studentId

        firststudent.remove()

        /**
         * once we clone the top listed student, let us put it inside the 'active' table
         */

        let active = document.querySelector('#student-active tbody')

        active.innerHTML = ''

        active.appendChild(cloned)

        /**
         * let's tell the server to mark this student as 'is_scanned = 1'
         */

        mark_student(student_id)
    }

    /**
     * add an onclick event listener to the reset button
     */

    document.querySelector('#reset').onclick = reset_student
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
            /** show updated student list from db */

            get_unscanned_student()
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
            /** after that, refresh the whole page */

            location.href = location.href
        }
    }

    xhr.send('reset')
}

/**
 * function to
 * send a GET to the server requesting all students marked as 'is_scanned = 0'
 */

function get_unscanned_student()
{
    const xhr = new XMLHttpRequest()

    xhr.responseType = 'json'

    xhr.open('GET', '?get_unscanned_student', true)

    xhr.onload = function()
    {
        let studentlist = document.querySelector('#student-list tbody')

        studentlist.innerHTML = ''

        this.response.forEach(function(el,i)
        {
            let tr = document.createElement('tr')

            tr.setAttribute('data-student-id', el.student_id)

            tr.innerHTML += '<td>'+ parseInt(i+1) +'</td><td>'+ el.fullname +'</td><td>'+ el.faculty +'</td><td>'+ el.student_no +'</td>'

            studentlist.appendChild(tr)
        })  
    }

    xhr.send(null)
}