<?

$authorization = new authorization();
$authState = $authorization->login($_POST['login'], $_POST['password']);

switch($authState){
  case $authorization->STATE_LOGIN_EMPTY_LOGIN:
    echo json_encode(array('status'   => 'error',
                            'login'    => 'Введите логин',
                            'password' => ''));
    break;
  case $authorization->STATE_LOGIN_WRONG_LOGIN:
    echo json_encode(array('status'   => 'error',
                            'login'    => 'Пользователь не найден',
                            'password' => ''));
    break;
  case $authorization->STATE_LOGIN_EMPTY_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => 'Введите пароль'));
    break;
  case $authorization->STATE_LOGIN_SHORT_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => 'Длина пароля должна быть не менее 6 символов'));
    break;
  case $authorization->STATE_LOGIN_WRONG_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => 'Неверный пароль'));
    break;
  case $authorization->STATE_LOGIN_SUCCESS:
    echo json_encode(array('status' => 'success'));
    break;
}

exit();