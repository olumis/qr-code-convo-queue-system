<?php

if (is_logged()) redirect(u('/admin'));

function goodpost()
{
	clean();

	$_SESSION['error'] = [];

	if (!isset($_POST['email']) || !$_POST['email'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('email'));
	}
	else
	{
		if ( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['error'][] = sprintf(lang('err_invalid'),lang('email'));
		}
		else
		{
		    $res = db_exists('user', ['email' => $_POST['email'], 'is_active' => 1]);
		    
		    if (!$res->num_rows)
		    {
		        $_SESSION['error'][] = sprintf(lang('err_nonexistence'),lang('email'));
		    }
		}
	}

	if (!isset($_POST['password']) || !$_POST['password'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('password'));
	}

	if (!$_SESSION['error'])
	{
		if ( ! loginemail($_POST['email'], $_POST['password']))
		{
			$_SESSION['error'][] = sprintf(lang('err_login'), $_POST['email']);
		}
	}
	
	if ($_SESSION['error']) return false;

	return true;
}

$posted = [];

if (isset($_POST['login']))
{
	if (goodpost())
	{
		/**
		 * in-complete profile
		 */

		if (isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id'] && in_array($acl['icp'], $_SESSION['acl']))
		{
			$_SESSION['error'][] = sprintf(lang('help_profile'));
				
			redirect(u('/profile'));
		}

		/**
		 * everything's good
		 */

		redirect(u('/admin'));
	}

	$posted = $_POST;
}

/**
 * active page
 */

$root = $active = '';

if (strpos($_GET['route'], '/') !== false)
{
	list($root, $active) = explode('/', $_GET['route']);
}

/**
 * breadcrumbs
 */

$breadcrumbs[] = [
	'text' 		=> lang('home'),
	'href'		=> u('/'),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('login'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => lang('login'), 'root' => 'login', 'active' => $active]),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs,
	'posted'		=> $posted
];

tpl('login.tpl', $data, true);
