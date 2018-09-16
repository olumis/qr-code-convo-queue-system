<?php

/**
 * zmq
 */

$context = new ZMQContext();

$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'qr_code');

$socket->connect("tcp://localhost:5555");

/**
 * GO button is clicked
 * - mark this student 'is_active' as 1
 */

if (isset($_POST['go']) && (isset($_POST['user_id']) && $_POST['user_id']))
{
    $_POST['user_id'] = (int)$_POST['user_id'];

    db_update('attendance', ['is_active' => 1], ['user_id' => $_POST['user_id']]);

    /**
     * tell browser about the newly added students list
     * tell browser about the newly activate student info
     */

    $confirmed_students = load_model('superadmin/attendance')->students()->rows;

    $activated_student = load_model('superadmin/user')->user($_POST['user_id'])->row;

    $json = [
        'id'                => sprintf('active.student'),
        'students'          => $confirmed_students, // list of confirmed but inactive students
        'active_student'    => $activated_student // active student
    ];

    $socket->send(json_encode($json));
}

/**
 * RESET button is clicked
 * - mark all student 'is_active' as 0
 */

if (isset($_POST['reset']))
{
    $sql = "UPDATE attendance SET is_active = 0";

    db_query($sql);

    /**
     * tell browser about the newly added students list
     */

    $confirmed_students = load_model('superadmin/attendance')->students()->rows;

    $json = [
        'id'        => sprintf('reseted.student'),
        'students'  => $confirmed_students,
        'reset'     => true
    ];

    $socket->send(json_encode($json));
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
	'text' 		=> lang('live_queue'),
	'href'		=> '',
	'is_active'	=> true
];

$scripts = [
    u(TEMPLATE.'/olumis/js/superadmin/live-queue/home.js')
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('attendance'), 'root' => $root, 'active' => $active]),
	'footer'		=> tpl('footer.tpl', [], false, $scripts),
    'breadcrumbs'	=> $breadcrumbs,
    'students'      => $students
];

tpl('superadmin/live-queue/home.tpl', $data,  true);
