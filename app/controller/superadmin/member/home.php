<?php

if (isset($_GET['page']) && $_GET['page'])
{
	$page = (int)$_GET['page'];
}
else
{
	$page = 1;
}

/**
 * members
 */

$members = load_model('superadmin/user')->users([], $page);

/**
 * pagination
 */

$pagination = pagination($page, $members->total_rows, u('superadmin/member?page={page}'));

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
	'text' 		=> lang('member'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('member'), 'root' => $root, 'active' => $active]),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs,
	'members'		=> $members,
	'pagination'	=> $pagination,
	'page'			=> $page
];

tpl('superadmin/member/home.tpl', $data,  true);

