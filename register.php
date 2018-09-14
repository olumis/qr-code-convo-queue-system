<?php

if (is_logged()) redirect(u('admin?t=%s',$_SESSION['token']));

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
	
	if (!isset($_POST['g-recaptcha-response']) || !$_POST['g-recaptcha-response'])
	{
	    $_SESSION['error'][] = sprintf(lang('err_required'),lang('recaptcha'));
	}
	else
	{
	    $json = curl_post(CAPTCHA_URL,['secret' => SECRET_KEY, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $_SERVER['REMOTE_ADDR']]);
	    
	    if (!$json)
	    {
	        $_SESSION['error'][] = sprintf(lang('err_system'),lang('recaptcha'));
	    }
	    else
	    {
	        $response = (array)json_decode($json);
	        
	        if (isset($response['error-codes']) && $response['error-codes'])
	        {
	            foreach ($response['error-codes'] as $k => $err)
	            {
	                $_SESSION['error'][] = $err;
	            }
	        }
	        else
	        {
	            if (isset($response['success']) && !$response['success'])
	            {
	                $_SESSION['error'][] = lang('err_recaptcha_failed');
	            }
	        }
	    }
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
				
			$hashedcrypt = generate_hash($_POST['password']);
			
			$email_vsalt = md5( random_bytes(16) );
				
			$email_vcode = md5( $email_vsalt . $_POST['email'] . $hashedcrypt );
			
			/**
			 * user
			 */
			
			$user = [
				'email'             => $_POST['email'],
				'password'          => $hashedcrypt,
				'is_superadmin'     => 0,
				'ip'                => $_SERVER['REMOTE_ADDR'],
				'email_verified'    => 0,
				'email_vsalt'       => $email_vsalt,
				'email_vcode'       => $email_vcode,
				'is_active'         => 1,
				'created_at'        => date('Y-m-d H:i:s', $time),
				'updated_at'        => date('Y-m-d H:i:s', $time)
			];
			
			db_insert('user', $user);
			
			$user_id = mysqli_insert_id($mysqli);
			
			/**
			 * user_attr
			 */
			
			$user_attr = [
				'user_id'	=> $user_id,
				'usertitle'	=> 0,
				'fullname'	=> '',
				'mobile_no'	=> '',
				'icpass'	=> ''
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
			 * ewallet
			 */
			
			$ewallet = ['user_id' => $user_id];
			
			db_insert('ewallet', $ewallet);
			
			/**
			 * email
			 */
			
			$replacements = [
				'verifyurl' => sprintf(URL."verify?vcode=%s", $email_vcode)
			];
			
			$emaildata = [
				'tpl'          => 'verify.tpl',
				'to'           => $_POST['email'],
				'subject'      => lang('es_email_verification'),
				'replacements' => $replacements
			];
			
			/**
			 * COMMIT DB OPERATION
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
else
{
	$active = 'home';
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
	'header'		=> tpl('header.tpl', ['title' => lang('register'), 'root' => 'register', 'active' => $active]),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs,
	'posted'		=> $posted
];

tpl('register.tpl', $data, true);

