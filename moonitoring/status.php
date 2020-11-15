<?php include "includes/top.php"?>
<div class="title">
    <h1>Moonitoring!</h1>
</div>
<nav>
    <?php include "includes/nav.php"?>
</nav>
<div class="content">
    <div class="panel">
        <h1>Status Page</h1>
        <p>This page contains a quick overview of all the farms and their machines.
            For more information, click the dropdowns. </p>
    </div>
    <div class="panel">
        <h1>Mill Farm</h1>
        <ul class="expand-list status">
            <li>
                <!-- <span class="dot" style="background-color: #f44336;"></span> -->
                <img src="images/error.png" alt="error" class="icon">
                <span class="info">2 Machines not responding</span>
                <span class="resize">▼</span>
                <div class="expanded-box">
                    <p>
                        <ul class="machine-status-list">
                            <li>
                                <span class="machine-id">1</span>
                                No contact for 20 minutes
                                <a href="#">Fix...</a>
                            </li>
                            <li>
                                <span class="machine-id">2</span>
                                No contact for 58 minutes
                                <a href="#">Fix...</a>
                            </li>
                        </ul>
                    </p>
                </div>
            </li>
            <li>
                <!-- <span class="dot" style="background-color: #4CAF50;"></span> -->
                <img src="images/tick.png" alt="good" class="icon">
                <span class="info">8 Machines are normal</span>
                <span class="resize">▼</span>
                <div class="expanded-box">
                    <ul>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                    </ul>
                </div>
            </li>
            <p style="margin-left: 10px;">
                0 machines need attention
            </p>
            <hr>
            <p>
                Last contact: 28 seconds ago
                <a href="#" style="float: right;">more...</a>
            </p>
        </ul>
    </div>
    <div class="panel">
        <h1>Low Farm</h1>
        <ul class="expand-list status">
            <li>
                <!-- <span class="dot" style="background-color: #FF9800;"></span> -->
                <img src="images/warn.png" alt="good" class="icon">
                <span class="info">1 Machine needs attention</span>
                <span class="resize">▼</span>
                <div class="expanded-box">
                    <ul>
                        <li>2</li>
                    </ul>
                </div>
            </li>
            <li>
                <!-- <span class="dot" style="background-color: #4CAF50;"></span> -->
                <img src="images/tick.png" alt="good" class="icon">
                <span class="info">1 Machine is normal</span>
                <span class="resize">▼</span>
                <div class="expanded-box">
                    <ul>
                        <li>1</li>
                    </ul>
                </div>
            </li>
            <p>
                <span style="margin-left: 10px;">0 machines have errors</span>
                <a href="#" style="float: right;">more...</a>
            </p>
        </ul>
    </div>
    <div class="panel">
        <h1>Scoones Farm</h1>
        <ul class="expand-list status">
            <li>
                <!-- <span class="dot" style="background-color: #4CAF50;"></span> -->
                <img src="images/tick.png" alt="good" class="icon">
                <span class="info">8 Machines are normal</span>
                <span class="resize">▼</span>
                <div class="expanded-box">
                    <p>
                        <ul class="machine-status-list">
                            <li>
                                <span class="machine-id">1</span>
                                <p>
                                    Last contact: 2 minutes ago
                                    <br>
                                    Data available:
                                    <!-- <ul class="no-dots">
                                        <li>Ambient temperature</li>
                                        <li>Water temperature</li>
                                        <li>Powder height</li>
                                    </ul> -->
                                </p>
                            </li>
                            <li>
                                <span class="machine-id">2</span>
                            </li>
                            <li>
                                <span class="machine-id">3</span>
                            </li>
                            <li>
                                <span class="machine-id">4</span>
                            </li>
                            <li>
                                <span class="machine-id">5</span>
                            </li>
                        </ul>
                    </p>
                </div>
            </li>
            <p>
                <span style="margin-left: 10px;">0 machines need attention</span>
                <br>
                <span style="margin-left: 10px;">0 machines have errors</span>
                <a href="#" style="float: right;">more...</a>
            </p>
        </ul>
    </div>
</div>
<?php include "includes/bottom.php"?>

<script>
    // Submit post on submit
    $('ul.expand-list li').on('click', function (event) {
        console.log($(this).find("div").toggle());
        console.log($(this).find("span.resize").toggleClass("rotate-180"));
    });
        $("ul.expand-list li").on('click', function(e) { e.stopPropagation(); });

</script>
<?php include "includes/end.php"?>