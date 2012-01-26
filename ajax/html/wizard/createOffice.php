<?php

/*
 * Dashboard html
 */
?>
<div class="title">Мастер создания офиса</div>
<div class="right">
    <div class="verticalScroll">
        <div class="verticalItem">
            <ul class="topMenu">
                <li class="active">Наименование</li>
                <li>Контакты</li>
                <li>Готово</li>
            </ul>
            <div class="horisontalScroll">
                <div class="item"><?include('createOffice/step1.php');?></div>
                <div class="item"><?include('createOffice/step2.php');?></div>
                <div class="item"><?include('createOffice/finish.php');?></div>
            </div>
        </div>
    </div>
</div>