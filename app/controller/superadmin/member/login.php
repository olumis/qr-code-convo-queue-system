<?php

if (!goodget())
{
	redirect(u('/superadmin/member'));
}
else
{
	X($_GET['user_id']);
	
	redirect(u('/admin'));
}

function goodget()
{
	clean();
	
	$_SESSION['error'] = array();
	
	if (!isset($_GET['user_id']) || !$_GET['user_id'])
	{
		$_SESSION['error'][] = sprintf(lang('err_required'),lang('member'));
	}
	else
	{
		$_GET['user_id'] = (int)$_GET['user_id'];
		
		$res = db_exists('user', ['user_id' => $_GET['user_id']]);
		
		if (!$res->num_rows)
		{
			$_SESSION['error'][] = sprintf(lang('err_nonexistence'),lang('member'));
		}
		else
		{
		    /**
		     * make sure I am a superadmin
		     */
		    
		    if (!$res->row['is_superadmin'])
		    {
		        $_SESSION['error'][] = sprintf(lang('err_system'),lang('member'));
		    }
		}
	}
	
	if ($_SESSION['error']) return false;
	
	return true;
}