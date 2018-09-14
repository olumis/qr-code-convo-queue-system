<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

error_reporting(E_ALL);

ini_set('display_errors', true);

mb_internal_encoding('UTF-8');

mb_http_output('UTF-8');

define('DEV', true);
define('MAINTENANCE', false);
define('PAGE_LIMIT', 5);
define('TEMPLATE', 'default');
define('PATH_IMG', 'public'.DIRECTORY_SEPARATOR.'img');

define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'convo');
define('DB_PASSWORD', 'UnB06QyeBnKOMdn4');
define('DB_DATABASE', 'convo');

define('URL', 'https://convo.sys/');
define('WS_URL', 'wss://convo.sys/wss');
