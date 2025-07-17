<div class="col-md-4">
    <div><canvas id="statusTransaction" style="height: 200px;width: 350px;"></canvas></div>
    <div>
        <div class="text-center mt-3">
            <h2 class="text-xl mb-3 text-gray-800"><span class="text-2xl">🤑</span>  وضعیت تراکنش</h2>
            <div class="flex justify-center text-sm">
                <div class="flex align-content-center items-center px-3" style="color: #1cc88a">
                    <svg class="w-2 h-2"><use href="#circle"></use></svg>
                    <span class="px-1">موفق <span class="text-xs text-gray-500">({{$statusTransactionsCount[0]}})</span></span>
                </div>
                <div class="flex align-content-center items-center" style="color: #ff6384">
                    <svg class="w-2 h-2"><use href="#circle"></use></svg>
                    <span class="px-1">ناموفق <span class="text-xs text-gray-500">({{$statusTransactionsCount[1]}})</span></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    Chart.defaults.global.defaultFontColor = '#858796';
    // Pie Chart Example
    var ctx = document.getElementById("statusTransaction");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["موفق", "ناموفق"],
            datasets: [{
                data: @json($statusTransactionsCount),
                backgroundColor: [ '#1cc88a', '#FF6384FF'],
                hoverBackgroundColor: [ '#17a673' , '#FF6384FF'],
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
