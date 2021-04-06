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
  <div id="chart1" style="display: inline-block;height:500px; border:2px black solid;">Loading.... This may take a minute</div>
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
          height: 600,
          width: 1600,
          type: 'line',
          zoom: {
            enabled: false
          },
          animations: {
            enabled: false,
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
          width: 2,
        //   curve: 'straight',
          curve: 'smooth',
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
var chart1 = new ApexCharts(document.querySelector("#chart1"), makeGraphOptions("All Temps", "*C"));
chart1.render();
var last = 0;
$.ajax({
                type: "GET",
                url: "api/all_datapoints.php?machine=300&sensor=1&limit=2000&shorthand",
                // data: form.serialize(), // serializes the form's elements.
                success: function (data) {
                  var json = JSON.parse(data).reverse();
                  var newdata1 = [];
                  var newdata2 = [];
                  var newdata3 = [];
                  var newdata4 = [];
                  var newdata5 = [];
                  for (let i = 0; i < json.length; i++) {
                    const dat = json[i];
                      last = dat.x;
                      var datapoints = dat.y
                      newdata1.push({x:last, y:datapoints[0]});
                      newdata2.push({x:last, y:datapoints[1]});
                      newdata3.push({x:last, y:datapoints[2]});
                      newdata4.push({x:last, y:datapoints[3]});
                      newdata5.push({x:last, y:datapoints[4]});
                    }
                    chart1.appendSeries({name: "Analog 1", data: newdata1});
                    chart1.appendSeries({name: "Analog 2", data: newdata2});
                    chart1.appendSeries({name: "Analog 3", data: newdata3});
                    chart1.appendSeries({name: "Analog 4", data: newdata4});
                    chart1.appendSeries({name: "Analog 5", data: newdata5});
                    return;
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
                      chart1.appendSeries({name: "Analog 1", data: [{x:last, y:datapoints[0]}] } );
                      chart1.appendSeries({name: "Analog 2", data: [{x:last, y:datapoints[1]}] } );
                      chart1.appendSeries({name: "Analog 3", data: [{x:last, y:datapoints[2]}] } );
                      chart1.appendSeries({name: "Analog 4", data: [{x:last, y:datapoints[3]}] } );
                      chart1.appendSeries({name: "Analog 5", data: [{x:last, y:datapoints[4]}] } );
                    }
                  }
                }
            });
}, 200);



                  }
            });









  </script>


</body>

</html>
