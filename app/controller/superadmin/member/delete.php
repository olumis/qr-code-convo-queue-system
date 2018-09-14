<?php

if (!goodget())
{
	redirect(u('/superadmin/member'));
}

function goodget()
{
	$_SESSION['error'] = [];

	clean();

	if (!isset($_GET['user_id']) || !$_GET['user_id'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('destination'));
	}
	else
	{
		$_GET['user_id'] = (int)$_GET['user_id'];

		$res = db_exists('user', ['user_id' => $_GET['user_id'], 'is_active' => 1 ]);

		if (!$res->num_rows)
		{
			$_SESSION['error'][] = sprintf(lang('err_nonexistence'),lang('member'));
		}
	}

	if ($_SESSION['error']) return false;

	return true;
}

function goodpost()
{
	$_SESSION['error'] = [];

	clean();

	if (!isset($_POST['user_id']) || !$_POST['user_id'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('member'));
	}
	else
	{
		$_POST['user_id'] = (int)$_POST['user_id'];
	}
	
	if ($_SESSION['error']) return false;

	return true;
}

if (isset($_POST['member']))
{
	if (goodpost())
	{
		mysqli_autocommit($mysqli, false);

		try
		{
			$user = [
				'is_active' => 0
			];

			db_update('user', $user, ['user_id' => $_POST['user_id']]);
				
			$_SESSION['success'][] = sprintf(lang('succ_deleted'), lang('member'));
		}
		
		catch(Exception $e)
		{
			mysqli_rollback($mysqli);

			$_SESSION['error'][] = $e->getMessage();
		}

		mysqli_commit($mysqli);

		redirect(u('/superadmin/member'));
	}
}

/**
 * member
 */

$member = load_model('superadmin/user')->user( $_GET['user_id'] )->row;

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
	'text' 		=> lang('delete_member'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('delete_member'), 'root' => $root, 'active' => $active]),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs,
	'member'		=> $member
];

tpl('superadmin/member/delete.tpl', $data, true);
