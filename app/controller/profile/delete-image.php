<?php

if (!goodget())
{
	redirect(u('/profile'));
}

function goodget()
{
	$_SESSION['error'] = [];

	clean();
	
	if (!isset($_GET['user_image_id']) || !$_GET['user_image_id'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('image'));
	}
	else
	{
		$_GET['user_image_id'] = (int)$_GET['user_image_id'];

		$res = db_exists('user_image', ['user_id' => $_SESSION['user']['user_id'], 'user_image_id' => $_GET['user_image_id']]);

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
			db_delete('user_image', ['user_id' => $_SESSION['user']['user_id'], 'user_image_id' => $_GET['user_image_id']]);
			
			$_SESSION['success'][] = sprintf(lang('succ_deleted'), lang('image'));

			/**
			 * commit db
			 */

			mysqli_commit($mysqli);
		}
		
		catch(Exception $e)
		{
			mysqli_rollback($mysqli);

			$_SESSION['error'][] = $e->getMessage();
		}
		
		redirect(u('/profile'));
	}
}

/**
 * user profile picture
 */

$image = load_model('superadmin/user')->image($_GET['user_image_id'], $_SESSION['user']['user_id'])->row;

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
	'href'		=> u('/admin'),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('profile'),
	'href'		=> u('/profile'),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('delete_image'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('delete_image'), 'root' => 'profile', 'active' => 'profile']),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs,
	'image'			=> $image
];

tpl('profile/delete-image.tpl', $data, true);
