<?php
if (!defined('ROOT_DIR')) {
    define("ROOT_DIR", __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
}
if (!defined('DB_DIR')) {
    define("DB_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR);
}
if (!defined('LANGUAGE')) {
    define("LANGUAGE", 'en');
}
$_SERVER['DB_DIR'] = DB_DIR;
