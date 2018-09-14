<?php

if (!goodget()) redirect(u('/'));

global $reset;

function goodget()
{
	global $reset;
	
	clean();
	
	$_SESSION['error'] = [];
	
	if (!isset($_GET['vcode']) || !$_GET['vcode'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'), lang('verification_code'));
	}
	else
	{
		if (!preg_match('/^[a-z0-9]+$/i', $_GET['vcode']))
		{
			$_SESSION['error'][] = sprintf(lang('err_format'), lang('verification_code'));
		}
		else
		{
			$res = $reset = $cache = db_exists('forgot_password', ['fp_vcode' => db_escape($_GET['vcode'])]);
		
			if (!$res->num_rows)
			{
				$_SESSION['error'][] = sprintf(lang('err_nonexistence'), lang('verification_code'));
			}
			else
			{
				$res = db_get('reset_password', sprintf("reset_success != 0 AND forgot_password_id = %d", (int)$res->row['forgot_password_id']));
		
				if ($res->num_rows)
				{
					$_SESSION['error'][] = sprintf(lang('err_verified'), lang('verification_code'));
				}
				else
				{
					/**
					 * check user_id + email + salt
					 */
		
					if ( md5( $cache->row['user_id'] . $cache->row['email'] . $cache->row['email_vsalt'] ) != $_GET['vcode'] )
					{
						$_SESSION['error'][] = sprintf(lang('err_invalid'), lang('verification_code'));
					}
				}
			}
		}
	}
	
	if ($_SESSION['error']) return false;

	return true;
}

function goodpost()
{
	clean();

	$_SESSION['error'] = [];

	$p1okay = $p2okay = false;
	
	if (!isset($_POST['password']) || !$_POST['password'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('password'));
	}
	else
	{
		$p1okay = true;
	}

	if (!isset($_POST['password_again']) || !$_POST['password_again'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('password_again'));
	}
	else
	{
		$p2okay = true;
	}

	if ($p1okay && $p2okay)
	{
		if ($_POST['password'] != $_POST['password_again'])
		{
			$_SESSION['error'][] = sprintf(lang('err_mismatched'),lang('password'));
		}
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

if (isset($_POST['rpasswd']))
{
	if (goodpost())
	{
		mysqli_autocommit($mysqli, false);
		
		try
		{
			$time = time();
			
			$hashedcrypt = hasher($_POST['password']);
			
			/**
			 * user
			 */
			
			$user = [
				'password'		=> $hashedcrypt,
				'updated_at'	=> date('Y-m-d H:i:s', $time)
			];
			
			db_update('user', $user, ['user_id' => $reset->row['user_id']]);
			
			/**
			 * reset_password
			 */
			
			$reset_password = [
				'forgot_password_id' => $reset->row['forgot_password_id'],
				'reset_success'      => 1,
				'created_at'         => date('Y-m-d H:i:s', $time),
				'updated_at'         => date('Y-m-d H:i:s', $time)
			];
			
			db_insert('reset_password', $reset_password);

			/**
			 * commit DB
			 */

			mysqli_commit($mysqli);
			
			/**
			 * success
			 * - autologin
			 */
			
			X($reset->row['user_id']);
			
			/**
			 * email
			 */

			$user = load_model('superadmin/user')->user($reset->row['user_id'])->row;
			
			$emaildata = [
				'tpl'          => 'reset-password.tpl',
				'to'           => $_SESSION['user']['email'],
				'subject'      => lang('es_rpass_confirmation'),
				'replacements' => ['fullname' => sprintf('%s %s', $user['usertitle'], $user['fullname'])]
			];
			
			firemail($emaildata);
			
			/**
			 * success
			 */
			
			$_SESSION['success'][] = sprintf(lang('succ_updated'),lang('password'));
			
		}
		catch(Exception $e)
		{
			mysqli_rollback($mysqli);
		
			$_SESSION['error'][] = $e->getMessage();
		}
		
		redirect(u('/admin'));
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
	'text' 		=> lang('reset_password'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => lang('reset_password'), 'root' => 'reset-password', 'active' => 'reset-password']),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs
];

tpl('reset-password.tpl', $data, true);
