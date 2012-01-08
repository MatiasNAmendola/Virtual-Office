<?

if (!isset($_SESSION['staff']))
	echo json_encode(array('status' => 'NotAuthorized', 'message' => ''));
else
    echo json_encode(array('status' => 'Authorized', 'message' => 'Normal', 'firstrun' => $firstrun));
exit();