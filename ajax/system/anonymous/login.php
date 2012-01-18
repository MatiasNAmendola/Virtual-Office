<?

$authorization = new authorization();
$authState = $authorization->login($_POST['login'], $_POST['password'], $authorization::LOGIN_BY_EMAIL);

switch($authState){
  case $authorization::STATE_LOGIN_EMPTY_LOGIN:
    echo json_encode(array('status'   => 'error',
                            'login'    => $L[label][loginState][emptyLogin],
                            'password' => ''));
    break;
  case $authorization::STATE_LOGIN_WRONG_LOGIN:
    echo json_encode(array('status'   => 'error',
                            'login'    => $L[label][loginState][wrongLogin],
                            'password' => ''));
    break;
  case $authorization::STATE_LOGIN_EMPTY_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => $L[label][loginState][emptyPassword]));
    break;
  case $authorization::STATE_LOGIN_SHORT_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => $L[label][loginState][lengthPassword]));
    break;
  case $authorization::STATE_LOGIN_WRONG_PASSWORD:
    echo json_encode(array('status'   => 'error',
                            'login'    => '',
                            'password' => $L[label][loginState][wrongPassword]));
    break;
  case $authorization::STATE_LOGIN_SUCCESS:
    echo json_encode(array('status' => 'success'));
    break;
}

exit();