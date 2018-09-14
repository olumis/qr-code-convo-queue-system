<?php

if (!goodget()) redirect(u('/superadmin'));

function goodget()
{
    if (isset($_GET) && $_GET)
    {
        $_GET = array_map('trim',               $_GET);
        $_GET = array_map('stripslashes',       $_GET);
        $_GET = array_map('rawurldecode',       $_GET);
        $_GET = array_map('html_entity_decode', $_GET);
        $_GET = array_map('rip_tags',           $_GET);
        $_GET = array_map('strip_tags',         $_GET);
    }
    
    $_SESSION['error'] = [];
    
    if (!isset($_GET['page_id']) || !$_GET['page_id'])
    {
        $_SESSION['error'][] = sprintf(lang('err_required'),lang('entry'));
    }
    else
    {
        $_GET['page_id'] = (int)$_GET['page_id'];
    }
    
    if ($_SESSION['error']) return false;
    
    return true;
}

function goodpost()
{
    $_SESSION['error'] = [];
    
    /* nothing to do yet */
    
    if ($_SESSION['error']) return false;
    
    return true;
}

if (isset($_POST['delete_page']))
{
    if (goodpost())
    {
        mysqli_autocommit($mysqli, false);
        
        try
        {
            $page = [
                'is_active' => 0
            ];
            
            db_update('page', $page, ['page_id' => $_GET['page_id']]);
            
            /**
             * commit
             */
            
            mysqli_commit($mysqli);
            
            /**
             * success
             */
            
            $_SESSION['success'][] = sprintf(lang('succ_deleted'),lang('page'));
            
            redirect(u('/superadmin/page'));
            
        }
        catch(Exception $e)
        {
            mysqli_rollback($mysqli);
            
            $_SESSION['success'][] = $e->getMessage();
        }
    }
}

/**
 * page
 */

$page = load_model('superadmin/page')->page($_GET['page_id'])->row;

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
    'text' 		=> lang('page'),
    'href'		=> u('/superadmin/page'),
    'is_active'	=> false
];

$breadcrumbs[] = [
    'text' 		=> lang('delete_page'),
    'href'		=> '',
    'is_active'	=> true
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => lang('delete_page'), 'root' => $root, 'active' => $active]),
    'footer'		=> tpl('footer.tpl'),
    'breadcrumbs'	=> $breadcrumbs,
    'page'          => $page
];

tpl('superadmin/page/delete.tpl', $data,  true);


