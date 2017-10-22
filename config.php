<?php

$host = getHost();
switch ($host) {
    case 'localhost':
        define('URL', 'http://localhost/aldoluberta.com/');
        define('DB_USER', 'root');
        define('DB_PASS', '');
        define('DB_NAME', 'blog_aldo');
        break;
}
define('LIBS', 'libs/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');

// This is for database passwords only
define('HASH_PASSWORD_KEY', '!@123456789ABCDEFGHIJKLMNOPRSTWYZ[¿]{?}<->');

define('CANT_REG_PAGINA', 16);
define('SITE_TITLE', 'Blog de Aldo Luberta Martínez :: ');

define('VENDORS', URL . 'public/vendors/');
define('CSS', URL . 'public/css/');
define('IMAGES', URL . 'public/images/');
define('JS', URL . 'public/js/');

function getHost() {
    $host = $_SERVER['HTTP_HOST'];
    return $host;
}
