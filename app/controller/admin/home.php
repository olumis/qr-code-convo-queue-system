<?php

/**
 * user
 */

$user = load_model('superadmin/user')->user($_SESSION['user']['user_id'])->row;

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
	'header'        => tpl('header.tpl', ['title' => lang('dashboard'), 'root' => 'admin', 'active' => 'admin']),
	'footer'        => tpl('footer.tpl'),
    'breadcrumbs'   => $breadcrumbs,
	'user'          => $user
];

tpl('admin/home.tpl', $data, true);
