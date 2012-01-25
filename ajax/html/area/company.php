<?php

/*
 * Staff list
 */
?>
<div class="title">Компания</div>
<div class="left">
    <ul>
        <li class="item1 active">Пункт1</li>
        <li class="item2">Пункт2</li>
    </ul>
</div>
<div class="right">
    <div class="verticalScroll">
        <div class="verticalItem">
            <?include('company/item1.php');?>
        </div>
        <div class="verticalItem">
            <?include('company/item2.php');?>
        </div>
    </div>
</div>