<?php

if (!goodget())
{
	redirect(u('/superadmin/member'));
}

function goodget()
{
	$_SESSION['error'] = [];

	clean();

	if ((!isset($_GET['fullname']) || !$_GET['fullname']) && (!isset($_GET['email']) || !$_GET['email']) && (!isset($_GET['mobile_no']) || !$_GET['mobile_no']))
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('search_criteria'));
	}

	if ($_SESSION['error']) return false;
	
	return true;
}

/**
 * pagination
 */

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

$members = load_model('superadmin/user')->users($_GET, $page);

/**
 * pagination
 */

$qdata = [
	'fullname'	=> (isset($_GET['fullname']) && $_GET['fullname']) ? $_GET['fullname'] : '',
	'email'		=> (isset($_GET['email']) && $_GET['email']) ? $_GET['email'] : '',
	'mobile_no'	=> (isset($_GET['mobile_no']) && $_GET['mobile_no']) ? $_GET['mobile_no'] : '',
];

$paginationurl = http_build_query($qdata);

$pagination = pagination($page, $members->total_rows, u('superadmin/member/search?%s&page={page}',$paginationurl));

/**
 * active page
 */

if (strpos($_GET['route'], '/') !== false)
{
	list($root,$active) = explode('/', $_GET['route']);
}
else
{
	$active = 'home';
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
	'href'		=> u('/superadmin/member'),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('search_result'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('search_result'), 'root' => $root, 'active' => $active]),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs,
	'members'		=> $members,
	'pagination'	=> $pagination,
	'page'			=> $page
];

tpl('superadmin/member/search.tpl', $data,  true);