<?php

/**
 * total students
 */

$totalstudents = load_model('superadmin/attendance')->total_students();

/**
 * total faculties
 */

$totalfaculties = load_model('lists')->total_get('faculty');

/**
 * total users
 */

$totalusers = load_model('superadmin/user')->total_users();

/**
 * total pages
 */

$totalpages = load_model('superadmin/page')->total_pages();

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
	'href'		=> '',
	'is_active'	=> true
];

$data = [

	'header'		=> tpl('header.tpl', ['title' => lang('dashboard'), 'root' => 'superadmin', 'active' => 'superadmin']),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs' 	=> $breadcrumbs,
	'totalstudents'	=> $totalstudents,
	'totalfaculties'=> $totalfaculties,
    'totalusers'    => $totalusers,
    'totalpages'    => $totalpages
];

tpl('superadmin/home.tpl', $data, true);
