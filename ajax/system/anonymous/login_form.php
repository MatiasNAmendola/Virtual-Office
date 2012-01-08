<?
if(!$_SESSION[staff]){
	$title = 'Вход в офис';
	$data = '
	<form onkeypress="if(event.keyCode == 13){Login(\'Do\');return false;}" onsubmit="return false;">
	    <table>
	        <tr>
	            <td valign="top">
	                <input type="text" class="login biginput" placeholder="Логин" required><error class="logininfo inputinfo"></error>
	            </td>
	        </tr>
	        <tr>
	            <td valign="top">
	                <input type="password" class="password biginput" placeholder="Пароль" required><error class="passwordinfo inputinfo"></error>
	            </td>
	        </tr>
	        <tr>
	            <td valign="top">
	                <div class="Button" onclick="Login(\'Do\');return false;">Войти</div>
	            </td>
	        </tr>
	    </table>
	</form>
	';
}
echo json_encode(array('title' => $title, 'data' => $data));
exit();
?>