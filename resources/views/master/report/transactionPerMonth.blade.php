<canvas id="successTransaction"></canvas>
<canvas id="successTransaction"></canvas>

<script>
    var ctx = document.getElementById('successTransaction').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: "تراکنش های موفق",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: @json($successTransactions),
            },
                {
                    label: "تراکنش های ناموفق",
                    lineTension: 0.3,
                    backgroundColor: "rgba(255, 99, 132, 0.05)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(255, 99, 132, 1)",
                    pointBorderColor: "rgba(255, 99, 132, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(255, 99, 132, 1)",
                    pointHoverBorderColor: "rgba(255, 99, 132, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: @json($failTransactions),
                }
            ],
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return number_format(value) + ' تومان ';
                        },
                        fontFamily: 'RRF'
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                        font: {
                            size:34
                        },

                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawOnChartArea: false
                    },
                    ticks: {
                        fontFamily: 'RRF'
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawOnChartArea: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        drawOnChartArea: false
                    }
                }]

            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                titleFontFamily: 'RRF',
                bodyFontFamily : 'RRF',
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 20,
                yPadding: 20,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return  number_format(tooltipItem.yLabel ) + ' ' + 'تومان';
                    }
                }
            }
        }
    });
</script>
