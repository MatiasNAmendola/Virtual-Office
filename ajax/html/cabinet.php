<?php

/*
 * Office main html
 */
$staff = new staff();
?>
<div class="office">
    <div class="head">
        <div class="user">
            <div class="title">
                <?=$staff->getInfo($staff::STAFF_FIRSTNAME);?>
                <?=$staff->getInfo($staff::STAFF_SECONDNAME);?>
                <?=$staff->getInfo($staff::STAFF_THIRDNAME);?>
                &nbsp;-&nbsp;
                <?=$staff->getInfo($staff::STAFF_EMAIL);?>
            </div>
        </div>
        <div class="logo">
            <div class="title">Office</div>
            <ul>
                <li class="dashboard">Кабинет</li>
                <li class="logout">Выход</li>
            </ul>
        </div>
    </div>
    <div class="page"></div>
    <div class="footer">
        Created by Mihael Isaev
    </div>
</div>