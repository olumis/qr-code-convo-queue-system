<?php

if (!goodget()) redirect(u('/'));

function goodget()
{
    clean();
    
    $_SESSION['error'] = [];
    
    if (!isset($_GET['route']) || !$_GET['route'])
    {
        $_SESSION['error'][] = sprintf(lang('err_system'),'');
    }
    
    if ($_SESSION['error']) return false;
    
    return true;
}

if (!preg_match('/(?<=page\/)[a-z0-9-\/]+/i', $_GET['route'], $matches))
{
    redirect(u('/'));
}

/**
 * page
 */

$page_seourl = $matches[0];

$page = load_model('superadmin/page')->seourl($page_seourl);

if (!$page->num_rows)
{
    redirect(u('/'));
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
    'text' 		=> $page->row['page_name'],
    'href'		=> '',
    'is_active'	=> true
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => $page->row['page_name'], 'root' => $page->row['page_seourl'], 'active' => $page->row['page_seourl']]),
    'footer'		=> tpl('footer.tpl'),
    'breadcrumbs'	=> $breadcrumbs,
    'page'          => $page->row
];

tpl('page.tpl', $data, true);
