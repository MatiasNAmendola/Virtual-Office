<?php

/*
 * Office main html
 */
$staff = new staff();
?>
<div class="office">
    <div class="head">
        <div class="user">
            <div class="title"><?=$staff->getInfo($staff::USER_EMAIL);?></div>
            <ul>
                <li class="logout"><?=$L[label][Logout];?></li>
            </ul>
        </div>
        <div class="logo"></div>
    </div>
</div>