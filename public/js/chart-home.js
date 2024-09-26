$(function () {
    /* ChartJS
     * -------
     * Data and config for chartjs
     */
    'use strict';
    var doughnutPieData = {
        datasets: [{
            data: [forSale, sold],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
            'Por vender'+' ('+forSale+')',
            'Vendidos'+' ('+sold+')',
        ]
    };
    var doughnutPieOptions = {
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };

    if ($("#stockCanva").length) {
        var doughnutChartCanvas = $("#stockCanva").get(0).getContext("2d");
        var doughnutChart = new Chart(doughnutChartCanvas, {
            type: 'doughnut',
            data: doughnutPieData,
            options: doughnutPieOptions
        });
    }
    /* Grafica por categorias */
    //categoriesSales = JSON.parse(categoriesSales);
    var categories = [];
    var sales = [];
    var color = [];
    for (var i = 0; i < categoriesSales.length; i++) {
        categories.push(categoriesSales[i].name+' ('+categoriesSales[i].total+')');
        sales.push(categoriesSales[i].total);
        color.push(categoriesSales[i].color);
    }

    var doughnutPieDataByCategory = {


        datasets: [{
            data: sales,
            backgroundColor: color,
            borderColor: color,

        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: categories
    };
    var doughnutPieOptionsByCategory = {
        //los numeros visibles en la grafica
        legend: {
            display: true,
            position: 'left',
        },
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };
    if ($("#pieChartByCategory").length) {
        var pieChartCanvas = $("#pieChartByCategory").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
          type: 'pie',
          data: doughnutPieDataByCategory,
          options: doughnutPieOptionsByCategory,
        });
      }
      filterGraph('week');
});
//grafica de barras
function filterGraph(value) {
    //ruta get /sales-graph/{value}
    $.get('/sales-graph/' + value, function (data) {
        //convierte el data en arrays separador labelGraph y total.
        var label = [];
        var total = [];
        var backgroundColor = [];
        var borderColor = [];
        for (var i = 0; i < data.length; i++) {
            label.push(data[i].labelGraph);
            total.push(data[i].total);
            //Genera colores aleatorio
            backgroundColor.push('rgba(' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ',0.2)');
            borderColor.push('rgba(' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ',1)');

        }

        var data = {
            labels: label,
            datasets: [{
              label: '# of Votes',
              data: total,
              backgroundColor: backgroundColor,
              borderColor: borderColor,
              borderWidth: 1,
              fill: false
            }]
          };
          var options = {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                },
                gridLines: {
                  color: "rgba(204, 204, 204,0.1)"
                }
              }],
              xAxes: [{
                gridLines: {
                  color: "rgba(204, 204, 204,0.1)"
                }
              }]
            },
            legend: {
              display: false
            },
            elements: {
              point: {
                radius: 0
              }
            }
          };
        if ($("#barChart").length) {
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: data,
              options: options
            });
          }
    });
}
