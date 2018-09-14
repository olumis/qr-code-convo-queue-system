<?php

function goodpost()
{
	clean();

	$_SESSION['error'] = array();

	if (!isset($_POST['email']) || !$_POST['email'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('email'));
	}
	else
	{
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['error'][] = sprintf(lang('err_invalid'),lang('email'));
		}
		else
		{
			$res = db_exists('user', ['email' => $_POST['email'], 'is_active' => 1]);

			if (!$res->num_rows)
			{
				$_SESSION['error'][] = sprintf(lang('err_nonexistence'),$_POST['email']);
			}
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

if (isset($_POST['fpasswd']))
{
	if (goodpost())
	{
		mysqli_autocommit($mysqli, false);

		try
		{
			$user_id = db_exists('user', ['email' => $_POST['email'], 'is_active' => 1])->row['user_id'];
			
			$user = load_model('superadmin/user')->user($user_id)->row;
		    
			$time = time();
				
			$email_vsalt = md5(random_bytes(16));
				
			$fp_vcode = md5($user_id . $_POST['email'] . $email_vsalt );
				
			$forgot_password = [
				'user_id'     => $user_id,
				'email'       => $_POST['email'],
				'email_vsalt' => $email_vsalt,
				'fp_vcode'    => $fp_vcode,
				'created_at'  => date('Y-m-d H:i:s', $time),
				'updated_at'  => date('Y-m-d H:i:s', $time)
			];

			db_insert('forgot_password', $forgot_password);
				
			/**
			 * email
			 */
				
			$replacements = [
				'fullname'	=> sprintf('%s %s', $user['usertitle'], $user['fullname']),
				'verifyurl' => sprintf(URL."reset-password?vcode=%s", $fp_vcode),
			];

			$emaildata = [
				'tpl'          => 'forgot-password.tpl',
				'to'           => $_POST['email'],
				'subject'      => lang('es_fpass_verification'),
				'replacements' => $replacements
			];

			firemail($emaildata);

			/**
			 * commit DB
			 */

			mysqli_commit($mysqli);
				
			/**
			 * success
			 */
				
			$_SESSION['success'][] = sprintf(lang('succ_fpasswd'),$_POST['email'], SMTP_FROM);
				
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
	'text' 		=> lang('forgot_password'),
	'href'		=> '',
	'is_active'	=> true
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('forgot_password'), 'root' => 'forgot-password', 'active' => 'forgot-password']),
	'footer'		=> tpl('footer.tpl'),
	'breadcrumbs'	=> $breadcrumbs
];

tpl('forgot-password.tpl', $data, true);
