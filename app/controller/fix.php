<div id="student-list"></div>

<hr>

<ol id="student-active"></ol>

<hr>

<button type="button">Go</button>

<script>

/**
 * student data can be fetched from any database 
 */

const students = [
    {name: 'shahril',faculty: 'ABC',id: '123'},
    {name: 'alif',faculty: 'DEF',id: '456'},
    {name: 'muiz',faculty: 'GHI',id: '789'},
    {name: 'ashraf',faculty: 'JKL',id: '012'},
    {name: 'wan',faculty: 'MNO',id: '345'}
]

display(students)

document.querySelector('button').onclick = function()
{
    /**
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/shift
     */

    let firstelement = students.shift()

    display(students)

    document.getElementById('student-active').innerHTML = '<li>' + firstelement.name + '</li>'
}

/**
 * list student name into the first <div>
 */

function display(db)
{
    let html = '<ol>'

    db.forEach(function(element, index)
    {
        html += '<li>'+ element.name +'</li>'
    })

    html += '</ol>'

    document.getElementById('student-list').innerHTML = html
}

</script>
