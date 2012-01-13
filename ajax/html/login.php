<?php

/*
 * Template for login page
 */
?>
<div class="loginForm">
    <div class="logo"></div>
    <form>
        <span class="title">Вход в офис</span>
        <table>
            <tr>
                <td class="right"><?=$L[label][Email];?></td>
                <td class="left">
                    <input type="text" class="email">
                    <span class="info emailInfo"></span>
                </td>
            </tr>
            <tr>
                <td class="right"><?=$L[label][Password];?></td>
                <td class="left">
                    <input type="password" class="password">
                    <span class="info passwordInfo"></span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="buttonsArea">
                    <span class="buttonForgot"><?=$L[button][Forgot];?></span>
                    <span class="buttonEnter"><?=$L[button][Enter];?></span>
                </td>
            </tr>
        </table>
    </form>
</div>
