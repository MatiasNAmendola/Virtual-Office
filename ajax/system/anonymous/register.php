<?

$db = new mysqliDB();
$db2 = new mysqliDB();

$errors = 0;

//Проверка email
$result = $db->selectRow('SELECT * FROM staff WHERE Email = ?', $_POST['email']);
$result2 = $db2->selectRow('SELECT * FROM staff WHERE Login = ?', $_POST['login']);
if (!isset($_POST['email']) || !strlen(trim($_POST['email']))) {
	$err[email] = 'Не указан email';
	$errors++;
}elseif(!preg_match("/^[a-z0-9](([_\.-]?[a-z0-9]+)*){0,19}@([a-z0-9]([_-]?[a-z0-9]+)?\.){1,3}[a-z]{2,6}$/i", $_POST['email'])){
    $err[email] = 'Неверный формат email';
	$errors++;
}elseif($db->queryInfo['num_rows']>0){
    $err[email] = 'Данный email уже используется';
    $errors++;
}else{$err[email]='';}

//Проверка логина

if (!isset($_POST['login']) || !strlen(trim($_POST['login']))) {
	$err[login] = 'Не указан логин';
	$errors++;
}elseif(preg_match('/[^0-9a-zA-Z]/', $_POST['login'])){
    $err[login] = 'Логин может содержать только латинские буквы и цифры';
	$errors++;
}elseif($db2->queryInfo['num_rows']>0){
    $err[login] = 'Данный логин уже используется';
	$errors++;
}else{$err[login]='';}

//Проверка пароля
if (!isset($_POST['password']) || !strlen($_POST['password'])) {
	$err[password] = 'Не указан пароль';
	$errors++;
}elseif(strlen($_POST['password'])<6){
    $err[password] = 'Длина пароля должна быть не менее 6 символов';
	$errors++;
}else{$err[password]='';}
if (!isset($_POST['repassword']) || !strlen($_POST['repassword'])) {
	$err[repassword] = 'Не указан повтор пароля';
	$errors++;
}elseif($_POST['password']!==$_POST['repassword']){
    $err[repassword] = 'Пароли не совпадают';
	$errors++;
}else{$err[repassword]='';}

if (!isset($_POST['code']) || !strlen(trim($_POST['code']))) {
	$err['code'] = 'Введите код, или нажмите на картинку';
	$errors++;
}elseif($_SESSION['captcha_keystring']!==$_POST['code']){
    $err['code'] = 'Неверно введен код защиты';
	$errors++;
}else{$err[code]='';}

if ($errors>0) {
	echo json_encode(array('status' => 'error',
                            'email' => $err[email],
                            'login' => $err[login],
                            'password' => $err[password],
                            'repassword' => $err[repassword],
                            'code' => $err[code],
                            'message' => ''));
	exit();
}

$password = md5($_POST['password']);

$db = new mysqliDB();
$time = time();
$result = $db->insert("INSERT INTO staff (Email, Login, Password) VALUES (?,?,?)", 
	$_POST['email'], $_POST['login'], $password);

if (!$result) {
	echo json_encode(array('status' => 'error', 'message' => 'Ошибка регистрации'));
	exit();
}

//TODO   Здесь отправляем письмо с подтверждением регистрации

echo json_encode(array('status' => 'ok', 'message' => 'ok'));
exit();