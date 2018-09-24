<?php

function goodupload()
{
	clean();

	$_SESSION['error'] = array();

	goodimage();

	if ($_SESSION['error']) return false;

	return true;
}

if (isset($_POST['upload']))
{
	if (goodupload())
	{
		$imgpath = $_FILES['image']['tmp_name'];
			
		$filename = makefilename($_GET['user_id']);
			
		$where = getcwd() .'/'. PATH_IMG .'/profile/';

		/**
		 * dimension
		 */
			
		$dimension = [
			'large'		=> crop($imgpath, $filename, $where, 0, 0, true),
			'medium'	=> crop($imgpath, $filename, $where, 500, 0),
			'thumb'		=> crop($imgpath, $filename, $where, 300, 300)
		];
		
		$user_id = $_GET['user_id'];
		
		db_delete('user_image', ['user_id' => $user_id]);
		
		db_insert('user_image', ['user_id' => $user_id, 'dimension' => serialize($dimension)]);

		$user_image_id = mysqli_insert_id($mysqli);

		$thumburl = u('/img/profile/%s', $dimension['thumb']);

		$largeurl = u('/img/profile/%s', $dimension['large']);

		$deleteurl = sprintf(u('/').'superadmin/member/delete-image?user_image_id=%d&user_id=%d', $user_image_id, $user_id);

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

	if (!isset($_POST['has_profile_pic']))
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('profile_picture'));
	}

	if (!isset($_POST['fullname']) || !$_POST['fullname'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('fullname'));
	}

	if (!isset($_POST['faculty']) || !$_POST['faculty'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('faculty'));
	}

	if (!isset($_POST['student_id']) || !$_POST['student_id'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('student_id'));
	}

	if ($_SESSION['error']) return false;
	
	return true;
}

$posted = [];

/**
 * update profile except for superadmin
 */

if (isset($_POST['profile']))
{
	if ($_GET['user_id'] == $_SESSION['user']['user_id'] && in_array($acl['superadmin'], $_SESSION['acl']))
	{
		$_SESSION['error'][] = lang('err_adm_nochange');

		redirect(u('/profile'));
	}

	if (goodpost())
	{
		mysqli_autocommit($mysqli, false);

		try
		{
			$time = time();
				
			$user_id = $_GET['user_id'];

			/**
			 * new password
			 */
			
			if (isset($_POST['password']) && $_POST['password'])
			{
				$hashedcrypt = hasher($_POST['password']);

				db_update('user', ['password' => $hashedcrypt], ['user_id' => $user_id]);
			}

			/**
			 * qr password
			 */

			$qrp = db_exists('user', ['user_id' => $user_id]);

			if ($qrp->num_rows && !$qrp->row['qr_password'])
			{
				$user = [
					'qr_password' => hash('sha512', hasher(random_bytes(16)))
				];
	
				db_update('user', $user, ['user_id' => $user_id]);
			}

			/**
			 * is this user now an admin?
			 */

			if (isset($_POST['is_superadmin']) && $_POST['is_superadmin'])
			{
				$user = [
					'is_superadmin' => 1
				];
	
				db_update('user', $user, ['user_id' => $user_id]);

				/**
				 * acl
				 * - delete user previous 'superadmin'
				 * - insert 'superadmin'
				 */

				$where = [
					'user_id' => $user_id,
					'acl_id'  => $acl['superadmin']
				];
					
				db_delete('user_acl', $where);
				
				$issuperadmin = db_exists('user_acl', ['user_id' => $user_id, 'acl_id' => $acl['superadmin'] ]);
				
				if (!$issuperadmin->num_rows)
				{
					$user_acl = [
						'user_id' => $user_id,
						'acl_id'  => $acl['superadmin']
					];
						
					db_insert('user_acl', $user_acl);
				}
				
				acl_update(true);
			}
			else
			{
				$user = [
					'is_superadmin' => 0
				];
	
				db_update('user', $user, ['user_id' => $user_id]);

				/**
				 * acl
				 * - delete user previous 'superadmin'
				 */

				$where = [
					'user_id' => $user_id,
					'acl_id'  => $acl['superadmin']
				];
					
				db_delete('user_acl', $where);

				acl_update(true);
			}

			/**
			 * user_attr
			 */
				
			$user_attr = [
			    'fullname'		=> $_POST['fullname'],
			    'faculty'		=> $_POST['faculty'],
			    'student_id'	=> $_POST['student_id'],
			];
				
			db_update('user_attr', $user_attr, ['user_id' => $user_id]);

			/**
			 * acl
			 * - delete 'icp'
			 * - insert 'admin'
			 */
				
			$where = [
			    'user_id' => $user_id,
			    'acl_id'  => $acl['icp']
			];
				
			db_delete('user_acl', $where);
			
			/**
			 * add admin acl_id, i.e admin == member
			 */
			
			$isadmin = db_exists('user_acl', ['user_id' => $user_id, 'acl_id' => $acl['admin'] ]);
			
			if (!$isadmin->num_rows)
			{
				$user_acl = [
				    'user_id' => $user_id,
				    'acl_id'  => $acl['admin']
				];
					
				db_insert('user_acl', $user_acl);
			}
			
			acl_update(true);
			
			/**
			 * commit DB
			 */
			
			mysqli_commit($mysqli);
			
			/**
			 * success
			 */
			
			$_SESSION['success'][] = sprintf(lang('succ_updated'),lang('profile'));

			/**
			 * refresh 
			 */

			 redirect(u('/superadmin/member/edit?user_id=%d',$_GET['user_id']));
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
 * faculties
 */

$faculties = load_model('lists')->get('faculty')->rows;

/**
 * $user
 */

$user = load_model('superadmin/user')->user( $_GET['user_id'] )->row;

/**
 * active page
 */

$root = $active = '';

if (strpos($_GET['route'], '/') !== false)
{
	list($root, $active) = explode('/', $_GET['route']);
}

if (in_array($acl['icp'], $_SESSION['acl']))
{
	$active = $root = 'profile';
}
else
{
	$root = 'superadmin'; $active = 'profile';
}

/**
 * breadcrumbs
 */

$breadcrumbs[] = [
	'text' 		=> lang('dashboard'),
	'href'		=> u('admin'),
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
	'header'		=> tpl('header.tpl', ['title' => lang('profile'), 'root' => $root, 'active' => $active]),
	'footer'		=> tpl('footer.tpl',[], false, $scripts),
	'breadcrumbs'	=> $breadcrumbs,
	'posted'		=> $posted,
	'user'			=> $user,
	'faculties'		=> $faculties
];

tpl('superadmin/member/edit.tpl', $data, true);




