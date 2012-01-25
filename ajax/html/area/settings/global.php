<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul class="topMenu">
    <li class="active">Общее</li>
    <li>Безопасность</li>
    <li>Оповещения</li>
</ul>
<div class="horisontalScroll">
    <div class="item"><?include('activity/general.php');?></div>
    <div class="item"><?include('activity/security.php');?></div>
    <div class="item"><?include('activity/notifications.php');?></div>
</div>