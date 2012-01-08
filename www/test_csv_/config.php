<?
define('SITE_PATH', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
define('CLASS_PATH', SITE_PATH.DS.'classes/');

function __autoload($class_name)
{
    $class_file = CLASS_PATH.DS.$class_name.'.php';
    if (file_exists($class_file)) {
        require_once($class_file);
    }
}
header('Content-Type: text/html; charset=UTF-8');

