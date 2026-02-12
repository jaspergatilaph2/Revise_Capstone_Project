document.addEventListener('DOMContentLoaded', function () {
    const labelsEl = document.getElementById('activityChartLabels');
    const dataEl = document.getElementById('activityChartData');
    const chartEl = document.getElementById('activityChart');

    if (!labelsEl || !dataEl || !chartEl) return; // exit if any element missing

    const labels = JSON.parse(labelsEl.textContent);
    const dataCounts = JSON.parse(dataEl.textContent);

    new Chart(chartEl.getContext('2d'), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Permit Applications',
                data: dataCounts,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',   // Monday - blue
                    'rgba(255, 206, 86, 0.6)',   // Tuesday - yellow
                    'rgba(255, 99, 132, 0.6)',   // Wednesday - red
                    'rgba(75, 192, 192, 0.6)',   // Thursday - teal
                    'rgba(153, 102, 255, 0.6)',  // Friday - purple
                    'rgba(255, 159, 64, 0.6)',   // Saturday - orange
                    'rgba(201, 203, 207, 0.6)'   // Sunday - grey
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',     // Monday
                    'rgba(255, 206, 86, 1)',     // Tuesday
                    'rgba(255, 99, 132, 1)',     // Wednesday
                    'rgba(75, 192, 192, 1)',     // Thursday
                    'rgba(153, 102, 255, 1)',    // Friday
                    'rgba(255, 159, 64, 1)',     // Saturday
                    'rgba(201, 203, 207, 1)'     // Sunday
                ],

                borderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // keeps the pie circular
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
