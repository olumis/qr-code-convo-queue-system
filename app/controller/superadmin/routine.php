<?php

if ( ! isset($_SESSION['user']['user_id']) || !$_SESSION['user']['user_id'])
{
	logout();
	
	redirect('/login');
}

/**
 * is superadmin
 */

if (!in_array($acl['superadmin'], $_SESSION['acl']))
{
    logout();
    
    redirect('/login');
}
