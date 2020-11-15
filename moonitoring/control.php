<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Moonitoring!
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
        integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg=="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
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
</head>

<body>
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

    <div class="page-wrap">
        <div class="page">
            <div class="title">
                <h1>Moonitoring!</h1>
            </div>
            <nav>
                <a href="index.html">Home</a>
                <a href="status.html">Status</a>
                <a href="control.html" class="selected">Control Panel</a>
            </nav>
            <div class="content control-panel">
                <ul class="panel farm-select">
                    <li>
                        <a href="#" class="active">Low Farm</a>
                    </li>
                    <li>
                        <a href="#">Mill Farm</a>
                    </li>
                    <li>
                        <a href="#">Scoones Farm</a>
                    </li>
                    <li>
                        <a href="#">...</a>
                    </li>
                </ul>
                <div class="panel farm-info">
                    <h1>Farm Info</h1>
                    <iframe width='100%' height='250px' id='mapcanvas'
                        src='https://maps.google.com/maps?q=London,%20United%20Kingdom&Roadmap&z=10&ie=UTF8&iwloc=&output=embed'
                        frameborder='0' scrolling='no' marginheight='0' marginwidth='0'>
                    </iframe>
                    <p>Do things</p>
                </div>

                <div class="panel machine-info">
                    <h1>Machine List</h1>
                    <ul class="machine-control-panel-list">
                        <li>
                            <span class="dot" style="background-color: #4CAF50;"></span>
                            <!-- <img src="images/tick.png" alt="good" class="icon">  -->
                            <span class="name">Machine 1</span>
                            <div class="options-box machine-options-btn">
                                <img src="images/vertical-menu.png" alt="Menu" class="icon">
                            </div>
                            <div class="data">
                                32°C Heater | 28°C Milk Temp | 19°C Outdoors
                            </div>
                        </li>
                        <li>
                            <span class="dot" style="background-color: #4CAF50;"></span>
                            <!-- <img src="images/tick.png" alt="good" class="icon">  -->
                            <span class="name">Machine 2</span>
                            <div class="options-box">...</div>
                            <div class="data">
                                29°C | 21°C | 12°C
                            </div>
                        </li>
                        <li>
                            <span class="dot" style="background-color: #4CAF50;"></span>
                            <!-- <img src="images/tick.png" alt="good" class="icon">  -->
                            <span class="name">Machine 3</span>
                            <div class="options-box">...</div>
                            <div class="data">
                                31°C | 25°C | 18°C
                            </div>
                        </li>
                        <li>
                            <span class="dot" style="background-color: #4CAF50;"></span>
                            <!-- <img src="images/tick.png" alt="good" class="icon">  -->
                            <span class="name">Machine 4</span>
                            <div class="options-box">...</div>
                            <div class="data">
                                33°C | 27°C | 15°C
                            </div>
                        </li>
                        <li>
                            <span class="dot" style="background-color: #FF9800;"></span>
                            <!-- <img src="images/tick.png" alt="good" class="icon">  -->
                            <span class="name">Machine 5</span>
                            <div class="options-box">...</div>
                            <div class="data">
                                32°C | 21°C | --°C
                            </div>
                        </li>
                        <li>
                            <span class="dot" style="background-color: #f44336;"></span>
                            <!-- <img src="images/tick.png" alt="good" class="icon">  -->
                            <span class="name">Machine 5</span>
                            <div class="options-box">...</div>
                            <div class="data">
                                --
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
                    <!-- <canvas id="myChart" width="400" height="400"></canvas>
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                datasets: [{
                                    label: '# of Votes',
                                    data: [12, 19, 3, 5, 2, 3],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script> -->
                </div>

            </div>
        </div>
        <div class="footer" style="font-family: courier new">
            <p>cl 2020</p>
        </div>
</body>
<!-- <script src="{% static 'moonitoring/scripts/main.js' %}"></script> -->
<script>
    // Submit post on submit
    // $('ul.farm-list li').on('click', function (event) {
    //     event.preventDefault();
    //     console.log("form submitted!") // sanity check
    //     alert("you clicked da button");
    // });

    $(".machine-options-btn").on("click", function(event) {
        propertySelectMode = "take-prop";
        // $("#property-options").load("dynamic/owned_properties.php?pk=" + selectedPlayer.data("pk"));
        // openPropertyModal();
        $("#modal").show();
        $("body").addClass("modal-body");
    });
    $("#close-modal-btn").on("click", function(event) {
        $("#modal").hide();
        $("body").removeClass("modal-body");
    });


</script>

</html>