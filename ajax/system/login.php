<?

$authorization = new authorization();
echo json_encode($authorization->login($_POST, $authorization::LOGIN_BY_EMAIL));
exit();