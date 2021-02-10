<?php include "includes/start.php"?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
    integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg=="
    crossorigin="anonymous"></script>
<style>
    @media screen and (min-width: 1000px) {
        .page-wrap {
            /* min-width: 1000px; */
            width: 100%;
            /* margin: 0px auto; */
        }

        body {
            /* margin: 0px; */
        }

        .content {
            padding: 20px 0px;
        }

        html {
            margin-left: 0px !important;
        }
    }

    @media screen and (min-width: 1400px) {
        .page-wrap {
            min-width: 1400px;
            width: 90%;
            margin: 0px auto;
        }
    }
</style>
<?php include "includes/top.php"?>

<div id="modal" class="modal">
    <div class="modal-content panel">
        <h1>Machine Actions <span id="close-modal-btn" class="close-modal-btn">×</span></h1>
        Machine: 1</code>
        <hr>
        <div id="property-options">
            Loading...
        </div>
    </div>
</div>
<div class="title">
    <h1>Moonitoring!</h1>
</div>
<nav>
    <?php include "includes/nav.php"?>
</nav>
<div class="content control-panel">
    <ul class="panel farm-select">
    </ul>
    <div class="panel farm-info">
        <h1>Farm Info</h1>
        <iframe width='100%' height='250px' id='mapcanvas'
            src='https://maps.google.com/maps?q=London,%20United%20Kingdom&Roadmap&z=10&ie=UTF8&iwloc=&output=embed'
            frameborder='0' scrolling='no' marginheight='0' marginwidth='0'>
        </iframe>
        <p>Do things</p>
        <div class="menuBtn">click</div>
    </div>

    <div class="panel machine-info slide-container" id="slide-container">
        <div class="slide-machine-list">
            <h1 class="panel-header">Machine List</h1>
            Click on a machine to see more information.
            <hr>
            <table id="machines-table" class="control-panel-machine-list clickable" style="width:100%">
                <tr>
                    <th style="width:150px">Hardware ID</th>
                    <th>Name</th>
                    <th>Sensors</th>
                    <th>Last Contact</th>
                </tr>
            </table>
        </div>
        <div class="slide-top" style="display:none;">
            <div class="slide-close-btn">
                <----- Close Machine Inspector</div>
                    <div class="slide-inner">
                        <h1 class="panel-header">Machine Info</h1>
                        <table id="machine-slide-table"class="control-panel-machine-list" style="width:100%">
                            <tr>
                                <th style="width:150px">Hardware ID</th>
                                <th>Name</th>
                                <th>Sensors</th>
                                <th>Last Contact</th>
                            </tr>
                            <tr>
                                <td>18</td>
                                <td>Temperature Sensor</td>
                                <td>
                                    2
                                </td>
                                <td>2 Minutes Ago</td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        <div class="panel">
                            <h3>Hardware Sources:</h3>
                            <table id="sensors-table" class="control-panel-machine-list" style="width:65%">
                                <tr>
                                    <th>Index</th>
                                    <th>Type</th>
                                    <th>Bytes</th>
                                    <th>Enabled</th>
                                </tr>
                            </table>
                            <br>
                            <button>Refresh Data Sources</button>
                        </div>
                        <div class="panel" >
                            <h3>Segments:</h3>
                            <table id="segment-table" class="segment-list compact solidcolor" style="width:65%; font-family: 'Courier New', monospace;">
                                <tr>
                                    <th>Index</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                </tr>
                            </table>
                            <br>
                            <button>Refresh Data Sources</button>
                        </div>
                        <div class="panel">
                            <h3>Data Interpreters:</h3>
                        </div>
                </div>
            </div>

        </div>

    </div>
    <?php include "includes/bottom.php"?>
    <script>

        // $(".machine-options-btn").on("click", function(event) {
        //     propertySelectMode = "take-prop";
        //     // $("#property-options").load("dynamic/owned_properties.php?pk=" + selectedPlayer.data("pk"));
        //     // openPropertyModal();
        //     $("#modal").show();
        //     $("body").addClass("modal-body");
        // });

        // $("#close-modal-btn").on("click", function(event) {
        //     $("#modal").hide();
        //     $("body").removeClass("modal-body");
        // });






        let selectedFarm = null;
        let base = null;
        let farms = [];

        function selectFarm(farm) {
            // Ignore selecting the same farm
            if (selectedFarm == farm) return;
            if (selectedFarm != null) {
                $("a[data-farm_hid='" + selectedFarm.h_id +"']").removeClass("active");
            }
            $("a[data-farm_hid='" + farm.h_id +"']").addClass("active");
            console.log("selecting farm " + farm.h_id)
            selectedFarm = farm;
            closeMachineSlide();
            loadMachines(farm);
        }

        $(document).on('click', 'table.control-panel-machine-list tr', function (event) {
            var hid = $(this).data("machine_hid");
            if (hid != undefined) {
                console.log(hid);
                var machine = selectedFarm.machines.find(m=>m.h_id == hid);

                openMachineSlide(machine);
            }
        });
        $('.slide-close-btn').click(function (event) {
            closeMachineSlide()
        });

        function load() {
            console.log("Loading json");
            $.get("api/get_network.php", function (data, status) {
                if (status == "success") {
                    // alert("Loading success!")
                } else {
                    alert("Loading failure");
                    return;
                }
                base = JSON.parse(data);
                farms = base.farms;
                farms.forEach(f => {
                    $("ul.panel.farm-select").append("<li><a href='#' data-farm_hid='"+f.h_id+"'>"+f.name+"</a></li>");
                });
                selectFarm(farms[0]);

            });
        }

        function machineToRow(m) {
            var str = `<tr data-machine_hid="${m.h_id}">`;
            str += `<td>${m.h_id}</td>`;
            str += `<td>${m.name}</td>`;
            str += `<td>${m.sensors.length}</td>`;
            str += `<td>Just now</td>`;
            str+="</tr>";
            return str;
        }

        function sensorToRow(sensor) {
            var str = `<tr>`;
            str += `<td>${sensor.hardware_index}</td>`;
            str += `<td>${sensor.description}</td>`;
            str += `<td>${sensor.num_segments}</td>`;
            if (sensor.enabled) {
                str += `<td><span class="dot" style="background-color: #4CAF50;"></span></td>`;
            } else {
                str += `<td><span class="dot" style="background-color: red;"></span></td>`;
            }
            return str;
        }


        function loadMachines(farm) {
            //First clear the machines table
            $("#machines-table").find("tr:gt(0)").remove();
            var machines = farm.machines;
            var str;
            machines.forEach(m => {
                str += machineToRow(m);
            });
            if (machines.length == 0) {
                str = "<tr><td style='text-align: center' colspan='4'>This farm has no machines registered<td></tr>";
            }
            $('#machines-table tr:last').after(str);
        }

        function openMachineSlide(machine) {
            console.log("Opening slide for machine " + machine);
            $("#machine-slide-table").find("tr:gt(0)").remove();
            $('#machine-slide-table tr:last').after(machineToRow(machine));
            // Open the slide
            $("div.slide-top").animate({
                marginLeft: '0%',
                width:'100%',
                display:'block',
            }, 100).show();

            // Populate the sensor table
            var str;
            machine.sensors.forEach(s => {
                str += sensorToRow(s);
            });
            $("#sensors-table").find("tr:gt(0)").remove();
            $('#sensors-table tr:last').after(str);

            var segs;
            var i = 0;
            var n = 0;
            machine.sensors.forEach(s => {
                var style = ""
                if (s.enabled) {
                    if (n % 2 != 0) {
                        // style = "background-color: #f5f5f5;";
                    }
                    segs += `<tr class='start'><td>${i}</td><td>${s.description}</td><td></td></tr>`;
                    i++;
                    for (let q = 1; q < s.num_segments; q++) {
                        segs += `<tr style='${style} '><td>${i}</td><td> → extension</td><td></td></tr>`;
                        i++;
                    }
                    n++;
                }
            });

            $("#segment-table").find("tr:gt(0)").remove();
            $('#segment-table tr:last').after(segs);

        }
        function closeMachineSlide() {
            $("div.slide-top").animate({
                marginLeft: '0%',
                width:'0%',
                display:'none',
            }, 100).hide(100);

        }


        load();

        $(document).on('click', 'ul.panel.farm-select li a', function (event) {
            var hid = $(this).data("farm_hid");
            var farm = farms.find(f=>f.h_id == hid);
            selectFarm(farm);
        });

    // $('.menuBtn').click(function(event) {
    //     console.log("Loading json");
    //     $.get("api/get_network.php", function(data, status){
    //         if (status == "success") {
    //             alert("Loading success!")
    //         }

    //         alert("Data: " + data + "\nStatus: " + status);
    //     });
    // });


    </script>
    <?php include "includes/end.php"?>