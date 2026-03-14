document.addEventListener('DOMContentLoaded', function () {
    const labelsEl = document.getElementById('activityChartLabels');
    const dataEl = document.getElementById('activityChartData');
    const chartEl = document.getElementById('activityChart');

    if (!labelsEl || !dataEl || !chartEl) return; // exit if any element missing

    // Parse JSON safely
    let labels = [];
    let dataCounts = [];
    try {
        labels = JSON.parse(labelsEl.textContent) || [];
        dataCounts = JSON.parse(dataEl.textContent) || [];
    } catch (e) {
        console.error('Error parsing chart data:', e);
        labels = [];
        dataCounts = [];
    }

    // If counts are empty, fill with zeros for 7 days
    if (dataCounts.length === 0) {
        dataCounts = Array(7).fill(0);
    }

    // If labels are empty, fill with day names
    if (labels.length === 0) {
        labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    }

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
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(201, 203, 207, 1)'
                ],
                borderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // keeps pie circular
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.label}: ${context.raw} applications`;
                        }
                    }
                }
            }
        }
    });
});