<?

$authorization = new authorization();
$authState = $authorization->checkAuthorization();
if(!$authState)
    echo json_encode(array('status' => 'NotAuthorized'));
else
    echo json_encode(array('status' => 'Authorized'));
exit();