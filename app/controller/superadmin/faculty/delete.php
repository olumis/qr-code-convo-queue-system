<?php

if (!goodget()) redirect(u('/superadmin'));

function goodget()
{
    clean();
    
    $_SESSION['error'] = [];
    
    if (!isset($_GET['faculty_id']) || !$_GET['faculty_id'])
    {
        $_SESSION['error'][] = sprintf(lang('err_required'),lang('entry'));
    }
    else
    {
        $_GET['faculty_id'] = (int)$_GET['faculty_id'];
    }
    
    if ($_SESSION['error']) return false;
    
    return true;
}

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

if (isset($_POST['delete_faculty']))
{
    if (goodpost())
    {
        mysqli_autocommit($mysqli, false);

        try
        {
            db_delete('list_faculty', ['faculty_id' => $_GET['faculty_id']]);
            
            /**
             * commit
             */
            
            mysqli_commit($mysqli);
            
            /**
             * success
             */
            
            $_SESSION['success'][] = sprintf(lang('succ_deleted'),lang('faculty'));

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
 * faculty
 */

$faculty = load_model('lists')->one('faculty', $_GET['faculty_id'])->row;

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
    'text' 		=> lang('delete_faculty'),
    'href'		=> '',
    'is_active'	=> true
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => lang('delete_faculty'), 'root' => $root, 'active' => $active]),
    'footer'		=> tpl('footer.tpl'),
    'breadcrumbs'	=> $breadcrumbs,
    'faculty'       => $faculty
];

tpl('superadmin/faculty/delete.tpl', $data,  true);


