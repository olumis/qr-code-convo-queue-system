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
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['error'][] = sprintf(lang('err_format'),lang('email'));
		}
		else
		{
		    $res = db_exists('user', ['email' => $_POST['email'], 'is_active' => 1]);
		    
		    if ($res->num_rows)
		    {
		        $_SESSION['error'][] = sprintf(lang('err_exists'),$_POST['email']);
		    }
		    else
		    {
		        $_POST['email'] = strtolower($_POST['email']);
		    }
		}
	}
	
	if (!isset($_POST['password']) || !$_POST['password'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('password'));
	}

	if ($_SESSION['error']) return false;

	return true;
}

$posted = [];

if (isset($_POST['register']))
{
	if (goodpost())
	{
		mysqli_autocommit($mysqli, false);
		
		try
		{
			$user_id = 0;
				
			$time = time();
				
			$hashedcrypt = hasher($_POST['password']);
			
			$email_vsalt = md5( random_bytes(16) );
				
			$email_vcode = md5( $email_vsalt . $_POST['email'] . $hashedcrypt );
			
			/**
			 * user
			 */
			
			$user = [
				'email'             => $_POST['email'],
				'password'          => $hashedcrypt,
				'email_vsalt'       => $email_vsalt,
				'email_vcode'       => $email_vcode,
				'email_verified'    => 0,
				'is_superadmin'		=> 0,
				'is_active'         => 1,
				'created_at'        => date('Y-m-d H:i:s', $time)
			];
			
			db_insert('user', $user);
			
			$user_id = mysqli_insert_id($mysqli);
			
			/**
			 * user_attr
			 */
			
			$user_attr = [
				'user_id'		=> $user_id,
				'fullname'		=> '',
				'faculty'		=> '',
				'student_id'	=> '',
			];
			
			db_insert('user_attr', $user_attr);
			
			/**
			 * acl
			 */
			
			$user_acl = [
				'user_id' => $user_id,
				'acl_id'  => $acl['guest']
			];
			
			db_insert('user_acl', $user_acl);
			
			$user_acl = [
				'user_id' => $user_id,
				'acl_id'  => $acl['icp']
			];
			
			db_insert('user_acl', $user_acl);
			
			/**
			 * commit db
			 */
			
			mysqli_commit($mysqli);
			
			/**
			 * - auto-login
			 * - redirect to profile
			 */
			
			if (X($user_id))
			{
			    $_SESSION['error'][] = sprintf(lang('help_profile'));
			    
			    redirect(u('/profile'));
			}
		}
		catch(Exception $e)
		{
			mysqli_rollback($mysqli);
		
			$_SESSION['error'][] = $e->getMessage();
		}
	}
	
	$posted = $_POST;
}

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
	'text' 		=> lang('home'),
	'href'		=> u('/'),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('register'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('register'), 'root' => 'register', 'active' => 'register']),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs,
	'posted'		=> $posted
];

tpl('register.tpl', $data, true);

