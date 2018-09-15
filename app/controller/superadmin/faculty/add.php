<?php

function goodpost()
{
    clean();

    $_SESSION['error'] = [];
    
    if (!isset($_POST['name']) || !$_POST['name'])
    {
        $_SESSION['error'][] = sprintf(lang('err_required'),lang('faculty_name'));
    }
    
    if ($_SESSION['error']) return false;
    
    return true;
}

if (isset($_POST['add_faculty']))
{
    if (goodpost())
    {
        mysqli_autocommit($mysqli, false);

        try
        {
            $faculty = [
                'name'  => $_POST['name']
            ];
            
            db_insert('list_faculty', $faculty);
            
            /**
             * commit
             */
            
            mysqli_commit($mysqli);
            
            /**
             * success
             */
            
            $_SESSION['success'][] = sprintf(lang('succ_added'),lang('faculty'));

            /**
             * go back
             */
            
            redirect(u('/superadmin/faculty'));
            
        }
        catch(Exception $e)
        {
            mysqli_rollback($mysqli);
            
            $_SESSION['error'][] = $e->getMessage();
        }
    }
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
    'text' 		=> lang('dashboard'),
    'href'		=> u('/superadmin'),
    'is_active'	=> false
];

$breadcrumbs[] = [
    'text' 		=> lang('faculty'),
    'href'		=> u('/superadmin/faculty'),
    'is_active'	=> false
];

$breadcrumbs[] = [
    'text' 		=> lang('add_faculty'),
    'href'		=> '',
    'is_active'	=> true
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => lang('add_faculty'), 'root' => $root, 'active' => $active]),
    'footer'		=> tpl('footer.tpl'),
    'breadcrumbs'	=> $breadcrumbs
];

tpl('superadmin/faculty/add.tpl', $data,  true);


