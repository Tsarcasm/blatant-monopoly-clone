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
</head>

<body>
  <div id="chart" style="width: 600px; height:200px; border:2px black solid;"></div>
  <script>

    function randomWalk(steps) {
      steps = steps >>> 0 || 100;
      var points = [],
        value = 21,
        t;

      for (t = 0; t < steps; t += 1) {
        value = 25 + Math.round(Math.random() * 10 - 5)
        points.push([t, value]);
      }

      return points;
    }


    let data = []
    let categories = []

    for (let i = 0; i < 25; i++) {
      // data.push(Math.floor(Math.random() * 30) + 5)
      categories.push(i)
    }


    function makeGraphOptions(data, timestamps) {
      var options = {
        series: [{
          name: "Temperature",
          data: randomWalk(25)
        }],
        chart: {
          height: 350,
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
          text: 'Outside Temperature',
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
          categories: timestamps
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
          yaxis: [
            {
              y: 21,
              y2: 30,
              borderColor: '#000',
              fillColor: '#75ff7a',
              label: {
                text: 'Allowed'
              }
            }
          ]
        },
        grid: {
          borderColor: '#f1f1f1',
        },

      };
      return options;
    }
    var chart = new ApexCharts(document.querySelector("#chart"), makeGraphOptions(data, categories));
    chart.render();



  </script>



</body>

</html>