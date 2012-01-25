<?php

/*
 * Office main html
 */
$staff = new staff();
?>
<div class="office">
    <div class="head">
        <div class="user">
            <div class="currentOffice">
                <div class="current">
                    <?=$staff->getInfo($staff::STAFF_FULLNAME);?>
                </div>
                <ul>
                    <li>Создать офис</li>
                    <li>Найти работу</li>
                </ul>
            </div>
            <div class="title">
                <?=$staff->getInfo($staff::STAFF_FULLNAME);?>
            </div>
        </div>
        <div class="logo">
            <div class="title">Office</div>
            <ul>
                <li class="dashboard">Кабинет</li>
                <li class="company">Компания</li>
                <li class="settings">Настройки</li>
                <li class="logout">Выход</li>
            </ul>
        </div>
    </div>
    <div class="page"></div>
    <div class="footer">
        Created by Mihael Isaev
    </div>
</div>