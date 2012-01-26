<?

$authorization = new authorization();
$authorization->logout();
echo json_encode(array('status' => 'LoggedOut'));
exit();