<canvas id="doughnutChart"></canvas>

<script>
    var ctx = document.getElementById('doughnutChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($labels),
            datasets: [{
                data: @json($data),
                backgroundColor: ['rgba(224, 70, 56, 1)', 'rgba(245, 194, 17, 1)', 'rgba(45, 204, 112, 1)', 'rgba(53, 152, 219, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>