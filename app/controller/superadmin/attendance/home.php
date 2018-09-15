<?php

/**
 * zmq
 */

$context = new ZMQContext();

$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'qr_code');

$socket->connect("tcp://localhost:5555");

/**
 * we have valid scan request
 * - check if the qr code content matched the qr_password in the database
 * - the qr_password matched, get the student info
 * - check the attendance table if the user already there
 * - insert user_id if the student is not in the attendance table
 */

if (isset($_POST['scan-qrc']) && (isset($_POST['qr_password']) && $_POST['qr_password']))
{
    $qr_password = $_POST['qr_password'];

    $student = db_exists('user', ['qr_password' => $qr_password]);

    if ($student->num_rows)
    {
        $myattendance = db_exists('attendance', ['user_id' => $student->row['user_id']]);

        if (!$myattendance->num_rows)
        {
            $faculty = load_model('superadmin/user')->user($student->row['user_id'])->row['faculty'];

            $queue_no = generate_queue_no($faculty);

            $attendance = [
                'user_id'       => $student->row['user_id'],
                'faculty'       => $faculty,
                'queue_no'      => $queue_no,
                'is_active'     => 0,
                'created_at'    => date('Y-m-d H:i:s')
            ];

            db_insert('attendance', $attendance);

            /**
             * tell browser about the newly added students list
             */

            $confirmed_students = load_model('superadmin/attendance')->students()->rows;

            $json = [
                'id'            => sprintf('confirmed.student'),
                'students'      => $confirmed_students
	        ];
	        
	        $socket->send(json_encode($json));
        }
    }
}

/**
 * confirmed students
 */

$students = load_model('superadmin/attendance')->students()->rows;

/**
 * active page
 */

if (strpos($_GET['route'], '/') !== false)
{
	list($root,$active) = explode('/', $_GET['route']);
}

/**
 * breadcrumbs
 */

$breadcrumbs[] = [
	'text' 		=> lang('dashboard'),
	'href'		=> u('/superadmin'),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('attendance'),
	'href'		=> '',
	'is_active'	=> true
];

$scripts = [
    u(TEMPLATE.'/olumis/js/superadmin/attendance/home.js')
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('attendance'), 'root' => $root, 'active' => $active]),
	'footer'		=> tpl('footer.tpl', [], false, $scripts),
    'breadcrumbs'	=> $breadcrumbs,
    'students'      => $students
];

tpl('superadmin/attendance/home.tpl', $data,  true);
