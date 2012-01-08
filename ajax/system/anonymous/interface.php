<?
$bar = '
<table>
    <tr>
        <td valign="middle"><img src="/content/images/sobaka.png"></td>
        <td valign="top">
            <input type="text" placeholder="email" class="Email email" tabindex="1"  onkeypress="if((event.keyCode==13)&&($(this).val()!==\'\')){Login(\'Form\');return false;}">
        </td>
        <td valign="top">
            <input value="Войти" type="submit" class="Button" tabindex="2">
        </td>
    </tr>
</table>
';
$data = '
<div class="Welcome">
    <table>
        <tr><td>Управляйте бизнесом online</td></tr>
        <tr><td><span class="text">Мы представляем Вам online офис, используя который, Вы можете создать свою организацию в интернете, устроиться на работу или просто воспользоваться услугами какой-либо организации.</span></td></tr>
    </table>
</div>
<div class="QuickRegister">
    <table width="100%">
        <tr><td>Впервые у нас?</td></tr>
        <tr><td>Присоединяйтесь!</td></tr>
        <tr><td><div class="hr"></div></td></tr>
        <tr><td><input type="text" placeholder="email" class="inputtext newemail"><error class="r_email"></error></td></tr>
        <tr><td><input type="text" placeholder="имя" class="inputtext newname"><error class="r_newname"></error></td></tr>
        <tr><td><input type="text" placeholder="фамилия" class="inputtext newsurename"><error class="r_surename"></error></td></tr>
        <tr><td><input type="password" placeholder="пароль" class="inputtext newpassword"><error class="r_password"></error></td></tr>
        <tr><td><input type="password" placeholder="повторите пароль" class="inputtext newrepassword"><error class="r_repassword"></error></td></tr>
        <tr><td><input type="submit" value="Войти" class="inputbutton"></td></tr>
    </table>
</div>';

    echo json_encode(array('bar' => $bar, 'data' => $data));
	exit();
?>