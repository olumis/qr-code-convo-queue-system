<?php

if (!goodget()) redirect(u('/superadmin/member'));

function goodget()
{
	$_SESSION['error'] = [];
	
	clean();
	
	if (!isset($_GET['user_id']) || !$_GET['user_id'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('user'));
	}
	else
	{
		$_GET['user_id'] = (int)$_GET['user_id'];
	}
	
	if ($_SESSION['error']) return false;
	
	return true;
}

function goodupload()
{
	clean();

	$_SESSION['error'] = [];

	goodimage();

	if ($_SESSION['error']) return false;

	return true;
}

if (isset($_POST['upload']))
{
	if (goodupload())
	{
	    $imgpath = $_FILES['image']['tmp_name'];
	    
	    $filename = makefilename(random_bytes(16));
	    
	    $where = getcwd() .DIRECTORY_SEPARATOR. PATH_IMG .DIRECTORY_SEPARATOR.'profile'.DIRECTORY_SEPARATOR;
	    
	    /**
	     * dimension
	     */
	    
	    $dimension = [
	        'large'		=> crop($imgpath, $filename, $where, 0, 0, true),
	        'medium'	=> crop($imgpath, $filename, $where, 500, 0),
	        'thumb'		=> crop($imgpath, $filename, $where, 300, 300)
	    ];
	    
	    $user_id = (int)$_GET['user_id'];
	    
	    db_delete('user_image', ['user_id' => $user_id]);
	    
	    db_insert('user_image', ['user_id' => $user_id, 'dimension' => serialize($dimension)]);
	    
	    $user_image_id = mysqli_insert_id($mysqli);
	    
	    $thumburl = u('/img/profile/%s', $dimension['thumb']);
	    
	    $largeurl = u('/img/profile/%s', $dimension['large']);
	    
	    $deleteurl = sprintf(u('/').'superadmin/member/delete-image?user_id=%d&user_image_id=%d', $user_id, $user_image_id);
	    
	    $html = '<div class="thumb">  <a href="'.$deleteurl.'" class="close">&times;</a> <a class="thumbnail" href="'.$largeurl.'"><img class="img-responsive" src="'.$thumburl.'" alt=""></a></div>';
	    
	    $json = [
	        'status' => 'success',
	        'data'   => $html
	    ];
	    
	    header('Content-Type: application/json; charset=UTF-8');
	    
	    exit(json_encode($json));
	}

	else
	{
		$json = [
			'status'  => 'error',
			'data'    => $_SESSION['error']
		];

		unset($_SESSION['error']);

		header('Content-Type: application/json; charset=UTF-8');

		exit(json_encode($json));
	}
}

function goodpost()
{
    clean();
    
    $_SESSION['error'] = [];
    
    if (!isset($_POST['usertitle']) || !$_POST['usertitle'])
    {
        $_SESSION['error'][] = sprintf(lang('err_required'),lang('usertitle'));
    }
    
    if (!isset($_POST['fullname']) || !$_POST['fullname'])
    {
        $_SESSION['error'][] = sprintf(lang('err_required'),lang('fullname'));
    }
    else
    {
        $_POST['fullname'] = ucwords(strtolower($_POST['fullname']));
    }
    
    if (!isset($_POST['mobile_no']) || !$_POST['mobile_no'])
    {
        $_SESSION['error'][] = sprintf(lang('err_required'),lang('mobile_no'));
    }
    else
    {
        if (!preg_match('/^[0-9]{7,}$/', $_POST['mobile_no']))
        {
            $_SESSION['error'][] = sprintf(lang('err_format'),lang('mobile_no'));
        }
    }
    
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
            
            if ($res->num_rows && $res->row['user_id'] != $_GET['user_id'])
            {
                $_SESSION['error'][] = sprintf(lang('err_exists'),$_POST['email']);
            }
            else
            {
                $_POST['email'] = strtolower($_POST['email']);
            }
        }
    }
    
    if ($_SESSION['error']) return false;
    
    return true;
}

if (isset($_POST['profile']))
{
	if (goodpost())
	{
		mysqli_autocommit($mysqli, false);

		try
		{
			$time = time();
				
			$user_id = $_GET['user_id'];
			
			if (isset($_POST['password']) && $_POST['password'])
			{
			    $hashedcrypt = hasher($_POST['password']);
				
				/**
				 * new password
				 */
				
				db_update('user', ['password' => $hashedcrypt], ['user_id' => $user_id]);
			}
			
			/**
			 * user email
			 */
			
			$user = ['email' => $_POST['email'] ];
			
			db_update('user', $user, ['user_id' => $user_id]);
			
			/**
			 * user_attr
			 */
				
			$user_attr = [
			    'usertitle'      => $_POST['usertitle'],
			    'fullname'       => $_POST['fullname'],
			    'mobile_no'      => $_POST['mobile_no'],
			    'account_no'     => $_POST['account_no'],
			    'bank_name'      => $_POST['bank_name'],
			    'holder_name'    => $_POST['holder_name'],
			    'is_marketer'    => $_POST['is_marketer']
			];
			
			db_update('user_attr', $user_attr, ['user_id' => $user_id]);
			
			/**
			 * update $_SESSION['user']
			 */
			
			$_SESSION['user']['usertitle'] = $_POST['usertitle'];
			
			$_SESSION['user']['fullname'] = $_POST['fullname'];
			
			/**
			 * marketer acl_id
			 */

			$sendemail = false;
			
			if ($_POST['is_marketer'])
			{
			    /**
			     * add marketer acl_id
			     */
			    
			    $ismarketer = db_exists('user_acl', ['user_id' => $user_id, 'acl_id' => $acl['marketing'] ]);
			    
			    if (!$ismarketer->num_rows)
			    {
			        $user_acl = [
			            'user_id' => $user_id,
			            'acl_id'  => $acl['marketing']
			        ];
			        
					db_insert('user_acl', $user_acl);
					
					$sendemail = true;
			    }
			}
			else
			{
			    /**
			     * remove marketer acl_id
			     */
			    
			    $where = [
			        'user_id' => $user_id,
			        'acl_id'  => $acl['marketing']
			    ];
			    
			    db_delete('user_acl', $where);
			}
			
			acl_update(true);

			/**
			 * send notification email to the new marketer
			 */

			if ($sendemail)
			{
				$recipient = load_model('superadmin/user')->user($user_id)->row;

				$emaildata = [
					'tpl'          => 'marketer-approved.tpl',
					'to'           => $recipient['email'],
					'subject'      => lang('es_marketer_approved'),
					'replacements' => ['fullname' => sprintf('%s %s', $recipient['usertitle'],$recipient['fullname'])]
				];

				firemail($emaildata);
			}
			
			/**
			 * commit DB
			 */
			
			mysqli_commit($mysqli);
			
			/**
			 * success
			 */
			
			$_SESSION['success'][] = sprintf(lang('succ_updated'),lang('profile'));
		}

		catch(Exception $e)
		{
		    mysqli_rollback($mysqli);
		    
		    $_SESSION['error'][] = $e->getMessage();
		}
	}
}

/**
 * usertitles
 */

$usertitles = load_model('lists')->get('usertitle')->rows;

/**
 * states
 */

$states = load_model('lists')->get('state')->rows;

/**
 * user
 */

$user = load_model('superadmin/user')->user( $_GET['user_id'] )->row;

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
	'href'		=> u('/superadmin/member'),
	'is_active'	=> false
];

$breadcrumbs[] = [
	'text' 		=> lang('edit_member'),
	'href'		=> '',
	'is_active'	=> true
];

$scripts = [
	u(TEMPLATE.'/jquery/jquery.ui.widget.js'),
    u(TEMPLATE.'/jquery/jquery.iframe-transport.js'),
    u(TEMPLATE.'/jquery/jquery.fileupload.js'),
    u(TEMPLATE.'/olumis/js/profile/home.js')
];

$data = [
	'header'		=> tpl('header.tpl', ['title' => lang('edit_member'), 'root' => $root, 'active' => $active]),
	'footer'		=> tpl('footer.tpl', [],false,$scripts),
	'breadcrumbs'	=> $breadcrumbs,
	'usertitles'	=> $usertitles,
    'states'        => $states,
	'user'     		=> $user
];

tpl('superadmin/member/edit.tpl', $data, true);
