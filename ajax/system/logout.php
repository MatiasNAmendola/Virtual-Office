<?

session_destroy();
echo json_encode(array('status' => 'LoggedOut', 'message' => ''));
exit();