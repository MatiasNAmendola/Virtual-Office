<?php

error_reporting (E_ALL);

include('kcaptcha.php');

//session_name('znep.in');
ini_set('session.gc_maxlifetime', 31536000);
session_start();

$captcha = new KCAPTCHA();

//if($_REQUEST[session_name()]){
switch($_GET[area]){
    case "register":
        $_SESSION['captcha_register']['captcha_keystring'] = $captcha->getKeyString();
        break;
}
	
//}

?>