document.addEventListener('DOMContentLoaded', function () {

    const chartEl = document.getElementById('monthChart');
    if (!chartEl) return;

    const labels = JSON.parse(chartEl.dataset.labels);
    const data = JSON.parse(chartEl.dataset.data);

    new Chart(chartEl.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Permit Applications',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

});