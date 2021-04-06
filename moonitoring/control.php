<?php include "includes/start.php"?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
    integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg=="
    crossorigin="anonymous"></script>
    <script src="js/moment.min.js"></script>
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
        <h1><span id="modal-title">Machine Actions</span><span id="close-modal-btn" class="close-modal-btn">×</span>
        </h1>
        <div id="modal-content">
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
        <div id="farm-info-panel">
        </div>
        <a href="#" id="modal-btn" class="style-button-2" data-modal="farm-edit-modal">Edit</a>
        <!-- <iframe width='100%' height='250px' id='mapcanvas'
            src='https://maps.google.com/maps?q=London,%20United%20Kingdom&Roadmap&z=10&ie=UTF8&iwloc=&output=embed'
            frameborder='0' scrolling='no' marginheight='0' marginwidth='0'>
        </iframe> -->
    </div>

    <div class="panel machine-info slide-container" id="slide-container">
        <div class="slide-machine-list">
            <div class="slide-inner">
                <h1 class="panel-header">Machine List</h1>
                Click on a machine to see more information.
                <hr>
                <table id="machines-table" class="control-panel-machine-list clickable" style="width:100%">
                    <tr>
                        <th style="width:130px">Hardware ID</th>
                        <th>Name</th>
                        <th>Sensors</th>
                        <th>Last Contact</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="slide-top" style="display:none;">
            <div class="slide-close-btn">
                <----- Close Machine Inspector</div>
                    <div class="slide-inner">
                        <h1 class="panel-header">Machine Info</h1>
                        <table id="machine-slide-table" class="control-panel-machine-list" style="width:100%">
                            <tr>
                                <th style="width:130px">Hardware ID</th>
                                <th>Name</th>
                                <th>Sensors</th>
                                <th>Last Contact</th>
                            </tr>
                        </table>
                        <a href="#" id="modal-btn" class="style-button-2" data-modal="machine-edit-modal">Rename</a>

                        <br>
                        <br>
                        <!-- <div class="panel"> -->
                        <h3>Live Sensor Data:</h3>
                        <table id="sensors-table" class="control-panel-machine-list" style="width:65%">
                            <tr>
                                <th>Index</th>
                                <th>pk</th>
                                <th>Description</th>
                                <th></th>
                                <th>Bytes</th>
                                <th>Data</th>
                                <th>Enabled</th>
                            </tr>
                        </table>
                        Last update: <span id="last-update-time"></span>
                        <br>
                        <a href="#" id="modal-btn" class="style-button-2" data-modal="sensor-change-modal">Enable / Disable sensors</a>
                        <br>

                        <br>
                        <h3>Database info:</h3>
                        Note: this data does not update live, so may be out of date. Refresh the page to see up-to-date data for these sections
                        <br>
                        <!-- </div> -->
                        <div class="panel">
                            <h3>Segments:</h3>
                            <table id="segment-table" class="segment-list compact solidcolor"
                                style="width:65%; font-family: 'Courier New', monospace;">
                                <tr>
                                    <th>Index</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                </tr>
                            </table>
                            <br>
                        </div>
                        <div class="panel">
                            <h3>Data Interpreters:</h3>
                            <table id="interpreters-table" class="control-panel-machine-list" style="width:65%">
                                <tr>
                                    <th>Sensor Pk</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Current Data</th>
                                </tr>
                            </table>
                            <a href="#" id="modal-btn" class="style-button-2" data-modal="sensor-change-modal">Add an interpreter</a>
                        </div>
                    </div>
            </div>

        </div>

    </div>
    <?php include "includes/bottom.php"?>
    <script>

        $(document).on('click', "#modal-btn", function (e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            propertySelectMode = "take-prop";
            $("#modal").show();
            var whichModal = $(this).data("modal");
            switch (whichModal) {
                case "farm-edit-modal":
                    openEditFarmModal();
                    break;
                case "machine-edit-modal":
                    openEditMachineModal();
                    break;
                case "sensor-change-modal":
                    $("span#modal-title").html("Enable / Disable sensors");
                    $("div#modal-content").html("Not yet implemented, check again soon");
                    break;
                default:
                    break;
            }
            $("body").addClass("modal-body");
        });

        function closeModal() {
            $("#modal").hide();
            $("div#modal-content").html("");
            $("body").removeClass("modal-body");
        }


        $(document).on('click', "#close-modal-btn", function (event) {
            closeModal();
        });

        function openEditMachineModal() {
            $("span#modal-title").html("Rename Machine");
            var str = "<form class='ajaxForm' id='machine-update-form' action='api/update_machine.php'>";
            str += `<label for='name'>Farm Name:</label><br>`;
            str += `<input type='text' id='name' name='name' value='${selectedMachine.name}'><br>`;
            str += `<input type='hidden' class='farm-pk-hidden-input' name='pk' value='${selectedMachine.pk}'>`;
            str += `<input type="submit" value="Submit">`;
            str += `</form>`;
            $("div#modal-content").html(str);
        }

        function openEditFarmModal() {
            $("span#modal-title").html("Edit Farm");
            var str = "<form class='ajaxForm' id='farm-update-form' action='api/update_farm.php'>";
            str += `<label for='name'>Farm Name:</label><br>`;
            str += `<input type='text' id='name' name='name' value='${selectedFarm.name}'><br>`;
            str += `<label for='location'>Location:</label><br>`;
            str += `<input type='text' id='location' name='location' value='${selectedFarm.location}'><br><br>`;
            str += `<input type='hidden' class='farm-pk-hidden-input' name='pk' value='${selectedFarm.pk}'>`;
            str += `<input type="submit" value="Submit">`;
            str += `</form>`;
            $("div#modal-content").html(str);
        }






        let selectedFarm = null;
        let selectedMachine = null;
        let base = null;
        let farms = [];

        function selectFarm(farm) {
            // Ignore selecting the same farm
            if (selectedFarm == farm) return;
            if (selectedFarm != null) {
                $("a[data-farm_hid='" + selectedFarm.h_id + "']").removeClass("active");
            }
            $("a[data-farm_hid='" + farm.h_id + "']").addClass("active");
            console.log("selecting farm " + farm.h_id)
            selectedFarm = farm;
            closeMachineSlide();
            loadMachines(farm);
            loadFarmInfo(farm);
        }

        function loadFarmInfo(farm) {
            var str = "";
            str += "<h2>" + farm.name + "</h2>\n<p>";
            str += "Location: " + farm.location + "<br>";
            str += "HID: " + farm.h_id + "<br>";
            str += "Created: " + moment(farm.created).local().fromNow() + "<br>";
            str += "Last Contact: " + moment(farm.last_contact).local().fromNow() + "</p>";
            $("#farm-info-panel").html(str);

        }


        $(document).on('click', 'table.control-panel-machine-list tr', function (event) {
            var hid = $(this).data("machine_hid");
            if (hid != undefined) {
                console.log(hid);
                var machine = selectedFarm.machines.find(m => m.h_id == hid);

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
                $("ul.panel.farm-select").html("");
                farms.forEach(f => {
                    $("ul.panel.farm-select").append("<li><a href='#' data-farm_hid='" + f.h_id + "'>" + f.name + "</a></li>");
                });

                if (selectedFarm != null) {
                    var newSelect = farms.find(f => f.pk == selectedFarm.pk);
                    selectFarm((newSelect != null) ? newSelect : farms[0]);
                } else {
                    selectFarm(farms[0]);
                }

            });
        }

        function machineToRow(m) {
            var str = `<tr data-machine_hid="${m.h_id}">`;
            str += `<td>${m.h_id}</td>`;
            str += `<td>${m.name}</td>`;
            str += `<td>${m.sensors.length}</td>`;
            str += `<td>${moment(m.last_contact).local().fromNow()}</td>`;
            str += "</tr>";
            return str;
        }

        function sensorToRow(sensor) {
            var str = `<tr data-sensor-pk='${sensor.pk}' class="editable-row">`;
            str += `<td>${sensor.hardware_index}</td>`;
            str += `<td>${sensor.pk}</td>`;
            str += `<td class="input-col" data-input-name="description"><form class="ajaxForm" action="api/update_sensor.php">${sensor.description}</form></td>`;
            str += `<td class="btn-col"><a class='inline-edit-btn row-edit-open' style='float: right;margin-right: 18px;'>&#9999;&#65039;</a></td>`;
            str += `<td>${sensor.num_segments * 2}</td>`;
            if (sensor.data == null) {
                str += `<td>-</td>`;
            } else {
                var units = sensor.units;
                if (units == null) units = "";
                str += `<td>${sensor.data} ${units}</td>`;
            }
            if (sensor.enabled) {
                str += `<td><span class="dot" style="background-color: #4CAF50;"></span></td>`;
            } else {
                str += `<td><span class="dot" style="background-color: #f44336;"></span></td>`;
            }
            return str + "</tr>";
        }

        function interpreterToRow(interpreter) {
            var str = `<tr data-interpreter-pk='${interpreter.pk}' class="editable-row">`;
            str += `<td>${interpreter.machine_sensor_pk}</td>`;
            str += `<td>${interpreter.type.name}</td>`;
            str += `<td>${interpreter.name}</td>`;
            str += `<td>${interpreter.description}</td>`;
            str += `<td>${interpreter.data}</td>`;
            return str + "</tr>";
        }


        function openRowEdit(row) {
            var inputcol = $(row).find("td.input-col").first();
            var form = $(row).find("td.input-col form").first();
            var btncol = $(row).find("td.btn-col").first();
            var val = inputcol.text();
            var sensorPk = $(row).data("sensor-pk");
            var inputName = inputcol.data("input-name");
            inputcol.data("old-value", val);

            form.html(`<input name="pk" type="hidden" value="${sensorPk}"><input name='${inputName}' type='text' value='${val}'><input class="row-edit-submit" type='submit'>`);
            btncol.html(`<a class='inline-edit-btn row-edit-close' style='float: right;margin-right: 18px;'>&#10060;</a>`)
        }

        function closeRowEdit(row) {
            var inputcol = $(row).find("td.input-col").first();
            var form = $(row).find("td.input-col form").first();
            var btncol = $(row).find("td.btn-col").first();
            var val = inputcol.data("old-value");

            form.html(val);
            btncol.html(`<a class='inline-edit-btn row-edit-open' style='float: right;margin-right: 18px;'>&#9999;&#65039;</a>`);

        }

        $(document).on('click', 'td a.row-edit-open', function (event) {
            openRowEdit($(this).closest("tr"));
        });
        $(document).on('click', 'td a.row-edit-close', function (event) {
            closeRowEdit($(this).closest("tr"));
        });


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
            selectedMachine = machine;
            console.log("Opening slide for machine " + machine);
            $("#machine-slide-table").find("tr:gt(0)").remove();
            $('#machine-slide-table tr:last').after(machineToRow(machine));
            // Open the slide
            $("div.slide-top").animate({
                marginLeft: '0%',
                width: '100%',
                display: 'block',
            }, 100).show();
            $("div.slide-machine-list").animate({
                marginLeft: '0%',
                width: '0%',
                display: 'none',
            }, 0).hide(0);

            // Populate the sensor table
            var str;
            machine.sensors.forEach(s => {
                str += sensorToRow(s);
            });
            // Remove all rows apart from the first one
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
                    segs += `<tr class='start'><td>${i}</td><td>${s.description}</td><td>${machine.segments[i]}</td></tr>`;
                    i++;
                    for (let q = 1; q < s.num_segments; q++) {
                        segs += `<tr style='${style} '><td>${i}</td><td> → extension</td><td>${machine.segments[i]}</td></tr>`;
                        i++;
                    }
                    n++;
                }
            });
            $("#segment-table").find("tr:gt(0)").remove();
            $('#segment-table tr:last').after(segs);

            var intps = "";
            machine.interpreters.forEach(i => {
                intps += interpreterToRow(i);
            });
            $("#interpreters-table").find("tr:gt(0)").remove();
            $('#interpreters-table tr:last').after(intps);

        }

        let lastDataTime = 0;
        window.setInterval(function () {
            if (selectedMachine == null) return;
            $.ajax({
                type: "GET",
                url: "api/all_datapoints.php?machine=300&sensor=1&limit=1",
                // data: form.serialize(), // serializes the form's elements.
                success: function (data) {
                  var json = JSON.parse(data);

                  if (json.length == 1 && json[0].y != null) {
                    if (json[0].x != lastDataTime) {
                        lastDataTime = json[0].x;
                      console.log(json[0].x, json[0].y);
                      updateSensorRows(json[0].y);
                      $("#last-update-time").css("opacity", 0.4);
                      $("#last-update-time").animate({opacity: 1}, 600, 'linear');
                    }
                  }
                }
            });
            $("#last-update-time").html(moment(lastDataTime).local().fromNow());
            $("#last-update-time").attr('title', lastDataTime);

        }, 500);

        let lastData = null;
        function updateSensorRows(data) {
            var sensors = selectedMachine.sensors;
            let q = 0;
            for (let i = 0; i < sensors.length; i++) {
                if (sensors[i].enabled == false) continue;
                var units = sensors[i].units;
                if (units == null) units = "";

                var row = $('#sensors-table tr').eq(i+1);
                console.log($("td", row).eq(5).html(data[q] + " " + units));
                $("td", row).eq(5).css("opacity", 0.5);
                    $("td", row).eq(5).animate({opacity: 1}, 600, 'linear');
                if (lastData != null) {
                    if (data[q] > lastData[q]) {
                        $("td", row).eq(5).css("color", "#4CAF50");
                        $("td", row).eq(5).animate({color: "#46454a",}, 1000, 'linear');
                    } else if (data[q] < lastData[q]) {
                        $("td", row).eq(5).css("color", "#f44336");
                        $("td", row).eq(5).animate({color: "#46454a",}, 1000, 'linear');
                    } else {
                        $("td", row).eq(5).animate({
                            opacity: 1
                        }, 600, 'linear');
                    }
                } else {
                }
                q++;
            }
            lastData = data;
        }




        function closeMachineSlide() {
            selectedMachine = null;
            $("div.slide-top").animate({
                marginLeft: '0%',
                width: '0%',
                display: 'none',
            }, 100).hide(100);
            $("div.slide-machine-list").animate({
                marginLeft: '0%',
                width: '100%',
                display: 'block',
            }, 100).show();

        }


        $(document).on('click', 'ul.panel.farm-select li a', function (event) {
            var hid = $(this).data("farm_hid");
            var farm = farms.find(f => f.h_id == hid);
            selectFarm(farm);
        });

        $(document).on('submit', 'form.ajaxForm', function (e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            console.log(form);
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function (data) {
                    if (data == "success") {
                        console.log("Success!");
                        $("div#modal-content").html("<p style='color: #119817;font-size:20px'>Success</p>");
                        setTimeout(function () {
                            load();
                            closeModal();
                        }, 500);
                    } else {
                        console.log("Failure");
                        alert(data);
                    }
                }
            });
        });

        load();

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