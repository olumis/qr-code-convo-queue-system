<?php

/**
 * pages
 */

$pages = load_model('superadmin/page')->pages();

/**
 * active page
 */

if (strpos($_GET['route'], '/') !== false)
{
    list($root,$active) = explode('/', $_GET['route']);
}
else
{
    $active = 'home';
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
    'href'		=> '',
    'is_active'	=> true
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => lang('page'), 'root' => $root, 'active' => $active]),
    'footer'		=> tpl('footer.tpl'),
    'breadcrumbs'	=> $breadcrumbs,
    'pages'         => $pages
];

tpl('superadmin/page/home.tpl', $data,  true);

