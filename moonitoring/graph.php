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
  <div id="chart" style="width: 100%; height:100%; border:2px black solid;">Loading.... This may take a minute</div>
  <script>







    let data = []
    let categories = []

    function makeGraphOptions(data, timestamps) {
      var options = {
        series: [{
          name: "Temperature",
          data: data
        }],
        chart: {
          height: 600,
          width: 1500,
          type: 'line',
          zoom: {
            enabled: false
          },
          animations: {
            enabled: false,
            easing: 'easeinout',
            speed: 100000,
            animateGradually: {
              enabled: false,
              delay: 10
            },
            dynamicAnimation: {
              enabled: false,
              speed: 350000
            }
          }
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
          text: 'Water Usage',
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
                  return val + " °C"
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
    $.ajax({
                type: "GET",
                url: "api/datapoints.php?machine=<?=$_GET["machine"]?>&sensor=<?=$_GET["sensor"]?>&limit=<?=$limit?>",
                // data: form.serialize(), // serializes the form's elements.
                success: function (data) {
                  console.log(data);
                  var json = JSON.parse(data);
                  var dat = [];
                  var timestamps = [];
                  for (let i = json.length - 1; i >= 0; i--) {
                    timestamps.push(json[i].x);
                    dat.push(json[i].y);
                    if (json[i].y < 0) console.log(json[i]);
                  }
                  var chart = new ApexCharts(document.querySelector("#chart"), makeGraphOptions(dat, timestamps));
                  chart.render();

                }
            });




  </script>



</body>

</html>
