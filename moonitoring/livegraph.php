<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style type="text/css">
    #container {
      max-width: 400px;
      height: 400px;
      margin: auto;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>
  <div id="chart1" style="display: inline-block;height:200px; border:2px black solid;">Loading.... This may take a minute</div>
  <div id="chart2" style="display: inline-block;height:200px; border:2px black solid;">Loading.... This may take a minute</div>
  <div id="chart3" style="display: inline-block;height:200px; border:2px black solid;">Loading.... This may take a minute</div>
  <div id="chart4" style="display: inline-block;height:200px; border:2px black solid;">Loading.... This may take a minute</div>
  <div id="chart5" style="display: inline-block;height:200px; border:2px black solid;">Loading.... This may take a minute</div>
  <script>







    let data = []
    let categories = []

    function makeGraphOptions(name, units) {
    let data = []
    let timestamps = []
      var options = {
        series: [{
          name: name,
          data: data
        }],
        chart: {
          height: 450,
          width: 600,
          type: 'line',
          zoom: {
            enabled: false
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 500
            }
          }
        //   animations: {
        //     enabled: ,
        //     easing: 'easeinout',
        //     speed: 100000,
        //     animateGradually: {
        //       enabled: false,
        //       delay: 10
        //     },
        //     dynamicAnimation: {
        //       enabled: false,
        //       speed: 350000
        //     }
        //   }
        },
        dataLabels: {
          enabled: false,
          style: {
            fontSize: '11px',
            fontWeight: 'bold',
            colors: undefined,
          },
          background: {
            enabled: true,
          }
        },
        stroke: {
          width: 3,
          curve: 'straight',
          dashArray: [0]
        },
        title: {
          text: name,
          align: 'left'
        },
        legend: {
          tooltipHoverFormatter: function (val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
          }
        },
        markers: {
          size: 0,
          hover: {
            sizeOffset: 2
          }
        },
        xaxis: {
          categories: timestamps,
          labels: {
          show: true,
          }
        },
        yaxis: {
          min: 0,
          max: 45,
        },
        tooltip: {
          y: [
            {
              title: {
                formatter: function (val) {
                  return val + " " + units
                }
              }
            }
          ]
        },
        annotations: {
          // yaxis: [
          //   {
          //     y: 21,
          //     y2: 30,
          //     borderColor: '#000',
          //     fillColor: '#75ff7a',
          //     label: {
          //       text: 'Allowed'
          //     }
          //   }
          // ]
        },
        grid: {
          borderColor: '#f1f1f1',
        },

      };
      return options;
    }

    <?php

if (!isset($_GET["limit"])) {
    $limit = 200;
} else {
    $limit = $_GET["limit"];
}
?>
var chart1 = new ApexCharts(document.querySelector("#chart1"), makeGraphOptions("Air Temperature", "*C"));
var chart2 = new ApexCharts(document.querySelector("#chart2"), makeGraphOptions("Analogue 1 Temperature", "*C"));
var chart3 = new ApexCharts(document.querySelector("#chart3"), makeGraphOptions("Analogue 2 Temperature", "*C"));
var chart4 = new ApexCharts(document.querySelector("#chart4"), makeGraphOptions("Analogue 3 Temperature", "*C"));
var chart5 = new ApexCharts(document.querySelector("#chart5"), makeGraphOptions("Analogue 4 Temperature", "*C"));
chart1.render();
chart2.render();
chart3.render();
chart4.render();
chart5.render();
var last = 0;
$.ajax({
                type: "GET",
                url: "api/all_datapoints.php?machine=300&sensor=1&limit=10&shorthand",
                // data: form.serialize(), // serializes the form's elements.
                success: function (data) {
                  var json = JSON.parse(data).reverse();
                  console.log("Got json");
                  for (let i = 0; i < json.length; i++) {
                    const dat = json[i];
                      last = dat.x;
                      console.log(dat.x, dat.y);
                      var datapoints = dat.y
                      chart1.appendData([{  data: [{x:last, y:datapoints[0]}] }] );
                      chart2.appendData([{  data: [{x:last, y:datapoints[1]}] }] );
                      chart3.appendData([{  data: [{x:last, y:datapoints[2]}] }] );
                      chart4.appendData([{  data: [{x:last, y:datapoints[3]}] }] );
                      chart5.appendData([{  data: [{x:last, y:datapoints[4]}] }] );
                    }
                    window.setInterval(function () {
    $.ajax({
                type: "GET",
                url: "api/all_datapoints.php?machine=300&sensor=1&limit=1&shorthand",
                // data: form.serialize(), // serializes the form's elements.
                success: function (data) {
                  var json = JSON.parse(data);
                  if (json.length == 1 && json[0].y != null) {
                    if (json[0].x != last) {
                      last = json[0].x;
                      console.log(json[0].x, json[0].y);
                      var datapoints = json[0].y
                      console.log(json);
                      chart1.appendData([{  data: [{x:last, y:datapoints[0]}] }] );
                      chart2.appendData([{  data: [{x:last, y:datapoints[1]}] }] );
                      chart3.appendData([{  data: [{x:last, y:datapoints[2]}] }] );
                      chart4.appendData([{  data: [{x:last, y:datapoints[3]}] }] );
                      chart5.appendData([{  data: [{x:last, y:datapoints[4]}] }] );
                    }
                  }


                  // // console.log(json);
                  // var dat = [];
                  // var timestamps = [];
                  // for (let i = json.length - 1; i >= 0; i--) {
                  //   timestamps.push(json[i][0]);
                  //   dat.push(json[i][1]);
                  //   // chart.updateOptions(makeGraphOptions(dat, timestamps))

                  // }


                }
            });
}, 200);



                  }
            });









  </script>


</body>

</html>
