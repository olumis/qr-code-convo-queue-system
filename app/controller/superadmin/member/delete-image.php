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
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('user'));
	}
	
	if (!isset($_GET['user_image_id']) || !$_GET['user_image_id'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('image'));
	}
	
	if (!$_SESSION['error'])
	{
		$_GET['user_image_id'] = (int)$_GET['user_image_id'];

		$res = db_exists('user_image', ['user_id' => $_GET['user_id'], 'user_image_id' => $_GET['user_image_id']]);

		if (!$res->num_rows)
		{
			$_SESSION['error'][] = sprintf(lang('err_nonexistence'),lang('image'));
		}
	}

	if ($_SESSION['error']) return false;

	return true;
}

if (isset($_POST['user_image']))
{
	if (goodget())
	{
		mysqli_autocommit($mysqli, false);

		try
		{
			db_delete('user_image', ['user_id' => $_GET['user_id'], 'user_image_id' => $_GET['user_image_id']]);
			
			$_SESSION['success'][] = sprintf(lang('succ_deleted'), lang('image'));
		}
		
		catch(Exception $e)
		{
			mysqli_rollback($mysqli);

			$_SESSION['error'][] = $e->getMessage();
		}

		mysqli_commit($mysqli);
		
		redirect(u('/superadmin/member/edit?user_id=%d', $_GET['user_id']));
	}
}

/**
 * user profile picture
 */

$image = load_model('superadmin/user')->image($_GET['user_image_id'], $_GET['user_id'])->row;

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
	'href'		=> u('/superadmin/member/'),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('edit_member'),
	'href'		=> u('/superadmin/member/edit?user_id=%d',$_GET['user_id']),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('delete_image'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('delete_image'), 'root' => $root, 'active' => $active]),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs,
	'image'			=> $image
];

tpl('superadmin/member/delete-image.tpl', $data, true);
