<?php

/**
 * faculties
 */

$faculties = load_model('lists')->get('faculty', 1, 9999);

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
    'text' 		=> lang('faculty'),
    'href'		=> '',
    'is_active'	=> true
];

$data = [
    'header'		=> tpl('header.tpl', ['title' => lang('faculty'), 'root' => $root, 'active' => $active]),
    'footer'		=> tpl('footer.tpl'),
    'breadcrumbs'	=> $breadcrumbs,
    'faculties'     => $faculties
];

tpl('superadmin/faculty/home.tpl', $data,  true);

