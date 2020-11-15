<?php 


?>



<div class="panel">
    <h1>Quick Status</h1>
    <div class="quick-status-panel">
        <p class="overview">
            <span class="quick-status-good">
                <img src="images/tick.png" alt="good" class="icon">
                All good - no problems!
            </span>
            <!-- <span class="quick-status-error">
                <img src="images/error.png" alt="error" class="icon">
                2 machines not responding
            </span>
            <br>
            <span class="quick-status-warn">
                <img src="images/warn.png" alt="warn" class="icon">
                5 running low
            </span> -->
        </p>
        <p class="num-connected">
            <?=count($machines)?> machines connected
            <br> <?=count($farms)?> farm sites online
            <br> Last contact: <?=time_elapsed_string($base->last_contact);?>
        </p>
        <p class="more">
            *<i>We noticed you don't have any machines online</i><br>
            <!-- <a href="status.html"> more info...</a> -->
        </p>
    </div>
</div>