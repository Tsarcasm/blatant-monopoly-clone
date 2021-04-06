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
  <div id="chart1" style="width: 100%; height:300px; border:2px black solid;">Loading.... This may take a minute</div>
  <div id="chart2" style="width: 100%; height:300px; border:2px black solid;">Loading.... This may take a minute</div>
  <div id="chart3" style="width: 100%; height:300px; border:2px black solid;">Loading.... This may take a minute</div>
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
          height: 300,
          width: 1000,
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
    <?php

if (!isset($_GET["limit"])) {
    $limit = 200;
} else {
    $limit = $_GET["limit"];
}
?>

var chart1 = new ApexCharts(document.querySelector("#chart1"), makeGraphOptions("Air Temperature", "*C"));
var chart2 = new ApexCharts(document.querySelector("#chart2"), makeGraphOptions("Water Temperature", "*C"));
var chart3 = new ApexCharts(document.querySelector("#chart3"), makeGraphOptions("Total water usage", "litres"));
chart1.render();
chart2.render();
chart3.render();
var last = 0;
$.ajax({
            type: "GET",
            url: "api/all_datapoints.php?machine=2&limit=400",
            // data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                var json = JSON.parse(data);

                var d1 = [];
                var d2 = [];
                var d3 = [];

                for (let index = 0; index < json.length; index++) {
                    var element = json[index];
                    d1.push({x:element.x, y:element.y[0]})
                    d2.push({x:element.x, y:element.y[1]})
                    d3.push({x:element.x, y:element.y[2]})
                }
                chart1.appendData([{  data: d1.reverse() }] );
                chart2.appendData([{  data: d2.reverse() }] );
                chart3.appendData([{  data: d3.reverse() }] );



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






  </script>


</body>

</html>
