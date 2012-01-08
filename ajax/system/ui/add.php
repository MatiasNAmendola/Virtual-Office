<?

$db = new mysqliDB();

$time = time();
$result = $db->insert("INSERT INTO department (IdOrganization, Name) VALUES (?,?)", $_SESSION['staff']['IdOrganization'], $_POST['name']);

if (!$result) {
	echo json_encode(array('status' => 'error', 'message' => 'Ошибка регистрации'));
	exit();
}

echo json_encode(array('status' => 'ok', 'message' => 'ok'));
exit();