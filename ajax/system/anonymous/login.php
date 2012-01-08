<?
$db = new mysqliDB();
$db2 = new mysqliDB();
$password = md5($_POST['password']);

//Проверка логина
$result = $db->selectRow('SELECT * FROM staff WHERE Login = ? AND Password = ?', $_POST['login'], $password);
$result2 = $db2->selectRow('SELECT * FROM staff WHERE Login = ?', $_POST['login']);
if (!isset($_POST['login']) || !strlen(trim($_POST['login']))) {
	$err[login] = 'Введите логин';
	$errors++;
}elseif(!$db2->queryInfo['num_rows']){
    $err[login] = 'Неверные данные';
	$errors++;
}else{$err[login]='';}

//Проверка пароля
if (!isset($_POST['password']) || !strlen($_POST['password'])) {
	$err[password] = 'Введите пароль';
	$errors++;
}elseif(strlen($_POST['password'])<6){
    $err[password] = 'Длина пароля должна быть не менее 6 символов';
	$errors++;
}elseif((!$db->queryInfo['num_rows']) && (!$db2->queryInfo['num_rows'])){
    $err[password] = 'Неверные данные';
}elseif((!$db->queryInfo['num_rows']) && ($db2->queryInfo['num_rows']>0)){
    $err[password] = 'Неверные данные';
	$errors++;
}else{$err[password]='';}

if ($errors>0) {
	echo json_encode(array('login' => $err[login],
                            'password' => $err[password],
                            'message' => ''));
	exit();
}
/*$result_firm = $db->selectRow('SELECT * FROM organizations WHERE Id = ?', $result['LastFirmId']);
if($db->queryInfo[num_rows]>0){
    $_SESSION[Firm] = $result_firm;
}else{
    $result_firm = $db->selectRow('SELECT * FROM organizations WHERE IdUser = ?', $result['Id']);
    $_SESSION[Firm] = $result_firm;
}*/
$_SESSION[staff] = $result;
$date = time();

if(!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}else{$ip=$_SERVER['REMOTE_ADDR'];}

//$db->update("UPDATE Users SET DateLastActivity=?, IPLastActivity=?, LastFirmId=? WHERE Id = ?",array($date,$ip,$result_firm[Id],$result[Id]));

echo json_encode(array('status' => 'ok', 'message' => 'Добро пожаловать, '.$result['SecondName'].' '.$result['FirstName'], 'key' => 'OK'));
exit();