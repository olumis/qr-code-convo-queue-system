<?php

$acl = [
    'guest'			=> 1,
    'icp'			=> 2, // in-complete profile
    'admin'			=> 3,
	'superadmin'	=> 4,
	'student'		=> 5,
	'staff'			=> 6
];

$aclaccess['guest'] = $aclaccess['icp'] = [
	'404',
	'permission',
	'home',
	'login',
	'logout',
	'register',
	'verify',
	'about',
	'contact',
	'profile',
	'profile/delete-image',
	'forgot-password',
	'reset-password',
	'fix',
	'js/config',
	'qrcode-png'
];

$aclaccess['admin'] = [
	'admin'
];

$aclaccess['superadmin'] = [
	'superadmin',
	'superadmin/member',
	'superadmin/member/edit',
	'superadmin/member/delete',
	'superadmin/member/delete-image',
	'superadmin/member/login',
	'superadmin/member/search',
    'superadmin/page',
    'superadmin/page/add',
    'superadmin/page/edit',
    'superadmin/page/delete'
];
