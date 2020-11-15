<?php include "includes/start.php" ?>
<?php include "includes/top.php"?>
    <div class="title">
        <h1>Moonitoring!</h1>
    </div>
    <nav>
        <?php include "includes/nav.php"?>
    </nav>
    <div class="content">
        <?php include "includes/panels/quick_status.php"?>
        <div class="panel">
            <h1>No Machines?</h1>
            <p>
                If you have no machines you can order some <a href="#">here</a>. <br>
                Otherwise, you might be having some issues with connecting the machines. View troubleshooting steps <a href="#">here</a>. <br>
                <code>Dev option: add a machine to the database <a href="#">here</a></code>
            </p>
        </div>
        <div class="panel">
            <h1>Farm Sites</h1>
            <ul class="expand-list farm">

                <?php foreach ($farms as $farm): ?>
                    <?php $farm_machines = $farm->getMachines()?>
                    <li>
                        <span class="dot" style="background-color: #4CAF50;"></span>
                        <span class="name"><?=$farm->name?></span>
                        <span class="num-connected"><?=count($farm_machines)?> Machines</span>
                        <span class="resize">▼</span>
                        <div class="expanded-box">
                            <p>
                                <ul class="machine-status-list">
                                    <!-- <li>
                                        <span class="machine-id">1</span>
                                        No contact for 20 minutes
                                        <a href="#">Fix...</a>
                                    </li>
                                    <li>
                                        <span class="machine-id">2</span>
                                        No contact for 58 minutes
                                        <a href="#">Fix...</a>
                                    </li> -->
                                </ul>
                            </p>
                        </div>
                    </li>
                <?php endforeach;?>
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


</script>
<?php include "includes/end.php"?>
