<div class="col-md-4">
    <div>
        <canvas id="registeredUser" style="height: 200px;width: 350px;"></canvas>
    </div>
    <div>
        <div class="text-center mt-3">
            <h2 class="text-xl mb-3  text-gray-800"><span class="text-2xl">🗿</span> کاربران</h2>
            <div class="flex justify-center text-sm">
                <div class="flex align-content-center items-center px-3" >
                    <span class="px-1"><span class="text-xs text-gray-500">{{count($registeredUser)}} نفر</span></span>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    Chart.defaults.global.defaultFontColor = '#858796';
    // Pie Chart Example
    var ctx = document.getElementById("registeredUser");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($userLabels),
            datasets: [{
                data: @json($registeredUser),
                backgroundColor: ['#0180e0', '#dcb310', '#17a673'],
                hoverBackgroundColor: ['#0180e0', '#dcb310' , '#17a673'],
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





