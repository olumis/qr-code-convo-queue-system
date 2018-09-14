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
    
    if (!isset($_POST['page_name']) || !$_POST['page_name'])
    {
        $_SESSION['error'][] = sprintf(lang('err_required'),lang('page_name'));
    }
    else
    {
        $_POST['page_name'] = trim($_POST['page_name']);
        $_POST['page_name'] = stripslashes($_POST['page_name']);
        $_POST['page_name'] = html_entity_decode($_POST['page_name']);
        $_POST['page_name'] = rawurldecode($_POST['page_name']);
        $_POST['page_name'] = rip_tags($_POST['page_name']);
        $_POST['page_name'] = strip_tags($_POST['page_name']);
    }
    
    if (!isset($_POST['page_content']) || !$_POST['page_content'])
    {
        $_SESSION['error'][] = sprintf(lang('err_required'),lang('page_content'));
    }
    
    if ($_SESSION['error']) return false;
    
    return true;
}

if (isset($_POST['edit_page']))
{
    if (goodpost())
    {
        mysqli_autocommit($mysqli, false);
        
        $page_seourl = basicseourl($_POST['page_name']);
        
        try
        {
            $page = [
                'page_name'     => $_POST['page_name'],
                'page_content'  => $_POST['page_content'],
                'page_seourl'   => $page_seourl,
                'is_active'     => 1
            ];
            
            db_update('page', $page, ['page_id' => $_GET['page_id']]);
            
            /**
             * commit
             */
            
            mysqli_commit($mysqli);
            
            /**
             * success
             */
            
            $_SESSION['success'][] = sprintf(lang('succ_updated'),lang('page'));
            
            $resp = [
                'status'     => 'success',
                'msg'        => '',
                'return'     => sprintf('/superadmin/page')
            ];
            
            header('Content-Type: application/json;charset=UTF-8');
            
            exit(json_encode($resp));
            
        }
        catch(Exception $e)
        {
            mysqli_rollback($mysqli);
            
            unset($_SESSION['error']);
            
            $resp = [
                'status' => 'error',
                'msg'    => $e->getMessage()
            ];
            
            header('Content-Type: application/json;charset=UTF-8');
            
            exit(json_encode($resp));
        }
    }
    else
    {
        $html = tpl('_error.tpl', [], false);
        
        unset($_SESSION['error']);
        
        $resp = [
            'status' => 'error',
            'msg'    => $html
        ];
        
        header('Content-Type: application/json;charset=UTF-8');
        
        exit(json_encode($resp));
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
    'text' 		=> lang('edit_page'),
    'href'		=> '',
    'is_active'	=> true
];

$links = ['<link rel="stylesheet" href="'. u(TEMPLATE.'/summernote/css/summernote.css?%s', time()).'">'];

$scripts = [
    u(TEMPLATE.'/summernote/js/summernote.min.js'),
    u(TEMPLATE.'/olumis/js/superadmin/page/edit.js')
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => lang('edit_page'), 'root' => $root, 'active' => $active], false, [], $links),
    'footer'		=> tpl('footer.tpl', [], false, $scripts),
    'breadcrumbs'	=> $breadcrumbs,
    'page'          => $page
];

tpl('superadmin/page/edit.tpl', $data,  true);


