<?
$auth = new authorization();
echo json_encode($auth->register($_POST));
exit();