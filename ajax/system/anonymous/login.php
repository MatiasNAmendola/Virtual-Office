<?

$authorization = new authorization();
$authState = $authorization->login($_POST['login'], $_POST['password']);

switch($authState){
  case $authorization::STATE_LOGIN_EMPTY_LOGIN:
    echo json_encode(array('status'   => 'error',
                            'login'    => 'Empty login',
                            'password' => ''));
    break;
  case $authorization::STATE_LOGIN_WRONG_LOGIN:
    echo json_encode(array('status'   => 'error',
                            'login'    => 'Wrong user',
                            'password' => ''));
    break;
  case $authorization::STATE_LOGIN_EMPTY_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => 'Empty password'));
    break;
  case $authorization::STATE_LOGIN_SHORT_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => 'Length of pasword < 6 characters'));
    break;
  case $authorization::STATE_LOGIN_WRONG_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => 'Wrong password'));
    break;
  case $authorization::STATE_LOGIN_SUCCESS:
    echo json_encode(array('status' => 'success'));
    break;
}

exit();