<?
if(!$_SESSION[staff]){
	$rand = rand(555,99999);
	$title = 'Регистрация';
	$data = '
	<form onkeypress="if(event.keyCode == 13){Registration(\'Do\');return false;}" onsubmit="return false;">
	    <table>
	        <tr>
	            <td>
	                <input type="text" class="email biginput" placeholder="Электронная почта" required><error class="emailinfo inputinfo"></error>
	            </td>
	        </tr>
	        <tr>
	            <td>
	                <input type="text" class="login biginput" placeholder="Логин" required><error class="logininfo inputinfo"></error>
	            </td>
	        </tr>
	        <tr>
	            <td>
	                <input type="password" class="password biginput" placeholder="Пароль" required><error class="passwordinfo inputinfo"></error>
	            </td>
	        </tr>
	        <tr>
	            <td>
	                <input type="password" class="repassword biginput" placeholder="Повторите пароль" required><error class="repasswordinfo inputinfo"></error>
	            </td>
	        </tr>
	        <tr>
	            <td>
	                <img class="captcha" src="/content/scripts/captcha/index.php?'.$rand.'" border="0" style="cursor:pointer;" onclick="$(this).attr(\'src\',\'/content/scripts/captcha/index.php?\'+Math.random());"/>
	            </td>
	        </tr>
	        <tr>
	            <td>
	                <input type="test" class="code biginput" placeholder="Защитный код" required><error class="codeinfo inputinfo"></error>
	            </td>
	        </tr>
	        <tr>
	            <td>
	                <div class="Button" onclick="Registration(\'Do\');return false;">Зарегистрироваться</div>
	            </td>
	        </tr>
	    </table>
	</form>
	';
}
echo json_encode(array('title' => $title, 'data' => $data));
exit();
?>