<?php

/*
 * Dashboard html
 */
?>
<div class="title">Кабинет</div>
<div class="left">
    <ul>
        <li class="list active">Рабочий стол</li>
        <li class="add">Мои данные</li>
    </ul>
</div>
<div class="right">
    <div class="verticalScroll">
        <div class="verticalItem">
            <?include('dashboard/desktop.php');?>
        </div>
        <div class="verticalItem">
            <?include('dashboard/settings.php');?>
        </div>
    </div>
</div>