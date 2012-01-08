<?
$data = '
<div class="item itemlogin selected" onclick="Login(this);">Вход</div>
<div class="item itemregister" onclick="Registration(this);">Регистрация</div>
';
echo json_encode(array('data' => $data));
exit();
?>