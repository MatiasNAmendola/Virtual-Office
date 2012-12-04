<?php

/*
 * Template for login page
 */
$auth = new authorization();
$l = new language();
?>
<div class="loginForm">
    <div class="logo">Office</div>
    <form class="Login">
        <span class="title"><?=$l->get('title_Login');?></span>
        <table>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_Email');?></td>
                <td class="left">
                    <input type="text" class="email">
                    <span class="info emailInfo"></span>
                </td>
            </tr>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_Password');?></td>
                <td class="left">
                    <input type="password" class="password">
                    <span class="info passwordInfo"></span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="buttonsArea">
                    <?if($auth->getRegistrationStatus()!==$auth::REGISTRATION_STATUS_CLOSED){?>
                    <span class="button Registration"><?=$l->get('button_Registration');?></span>
                    <?}?>
                    <span class="button Enter"><?=$l->get('button_Enter');?></span>
                </td>
            </tr>
        </table>
    </form>
    <?if($auth->getRegistrationStatus()!==$auth::REGISTRATION_STATUS_CLOSED){?>
    <form class="Reg">
        <span class="title"><?=$l->get('title_Registration');?></span>
        <table>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_FirstName');?></td>
                <td class="left">
                    <input type="text" class="firstName">
                    <span class="info firstNameInfo"></span>
                </td>
            </tr>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_SecondName');?></td>
                <td class="left">
                    <input type="text" class="secondName">
                    <span class="info secondNameInfo"></span>
                </td>
            </tr>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_Email');?></td>
                <td class="left">
                    <input type="text" class="email">
                    <span class="info emailInfo"></span>
                </td>
            </tr>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_Password');?></td>
                <td class="left">
                    <input type="password" class="password">
                    <span class="info passwordInfo"></span>
                </td>
            </tr>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_PasswordConfirm');?></td>
                <td class="left">
                    <input type="password" class="passwordConfirm">
                    <span class="info passwordConfirmInfo"></span>
                </td>
            </tr>
            <?if($auth->getRegistrationStatus()==$auth::REGISTRATION_STATUS_INVITE){?>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_Invite');?></td>
                <td class="left">
                    <input type="text" class="invite">
                    <span class="info inviteInfo"></span>
                </td>
            </tr>
            <?}?>
            <tr>
                <td class="right" valign="middle"><?=$l->get('label_Captcha');?></td>
                <td class="left">
                    <img class="captcha" src="/content/scripts/php/captcha/?area=register" title="<?=$l->get('label_CaptchaClickForUpdate');?>">
                </td>
            </tr>
            <tr>
                <td class="right" valign="top"><?=$l->get('label_CaptchaConfirm');?></td>
                <td class="left">
                    <input type="text" class="captchaConfirm">
                    <span class="info captchaConfirmInfo"></span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="buttonsArea">
                    <span class="button Cancel"><?=$l->get('button_Cancel');?></span>
                    <span class="button Register"><?=$l->get('button_Register');?></span>
                </td>
            </tr>
        </table>
    </form>
    <?}?>
</div>
