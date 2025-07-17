<div class="col-md-4">
    <div>
        <canvas id="gatewayTransaction" style="height: 200px;width: 350px;"></canvas>
    </div>
    <div>
        <div class="text-center mt-3">
            <h2 class="text-xl mb-3  text-gray-800"><span class="text-2xl">⛩️</span> درگاه تراکنش</h2>
            <div class="flex justify-center  text-sm">
                <div class="flex align-content-center items-center px-3" style="color: #0180e0">
                    <svg class="w-2 h-2"><use href="#circle"></use></svg>
                    <span class="px-1"> آنلاین<span class="text-xs text-gray-500">({{$transactionsCount[0]}})</span></span>
                </div>
                <div class="flex align-content-center items-center px-3" style="color: #dcb310">
                    <svg class="w-2 h-2"><use href="#circle"></use></svg>
                    <span class="px-1">اسنپ‌پی <span class="text-xs text-gray-500">({{$transactionsCount[1]}})</span></span>
                </div>
                <div class="flex align-content-center items-center px-3" style="color: #17a673">
                    <svg class="w-2 h-2"><use href="#circle"></use></svg>
                    <span class="px-1">نقدی <span class="text-xs text-gray-500">({{$transactionsCount[2]}})</span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    Chart.defaults.global.defaultFontColor = '#858796';
    // Pie Chart Example
    var ctx = document.getElementById("gatewayTransaction");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [ "آنلاین","اسنپ پی" , "کارت به کارت"],
            datasets: [{
                data: @json($transactionsCount),
                backgroundColor: [ '#dcb310','#0180e0', '#17a673'],
                hoverBackgroundColor: [ '#dcb310' ,'#0180e0', '#17a673'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
</script>
