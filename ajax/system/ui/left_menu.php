<?
if($_SESSION[staff]){
	$data = '
	<div class="item selected" onclick="SelectLeftItem(this);Section(\'department\');">Отделы</div>
	<div class="item" onclick="SelectLeftItem(this);Section(\'tasks\');">Задачи</div>
	<div class="item" onclick="Logout();">Выход</div>
	';
}
echo json_encode(array('data' => $data));
exit();