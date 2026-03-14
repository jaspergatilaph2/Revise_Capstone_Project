document.addEventListener('DOMContentLoaded', function () {
    const labelsEl = document.getElementById('permitsChartLabels');
    const dataEl = document.getElementById('permitsChartData');
    const chartEl = document.getElementById('permitsOverviewChart');

    if (!labelsEl || !dataEl || !chartEl) return;

    const labels = JSON.parse(labelsEl.textContent);
    const dataCounts = JSON.parse(dataEl.textContent);

    new Chart(chartEl.getContext('2d'), {
        type: 'bar', // You can change to 'pie' or 'doughnut'
        data: {
            labels: labels,
            datasets: [{
                label: 'Permits / Plans',
                data: dataCounts,
                backgroundColor: [
                    'rgba(255, 206, 86, 0.6)',   // Pending - yellow
                    'rgba(54, 162, 235, 0.6)',   // Under Review - blue
                    'rgba(75, 192, 192, 0.6)'    // Approved - green
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.label}: ${context.raw} permits`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
});