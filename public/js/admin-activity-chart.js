const activityData = @json($monthlyApplications);

    const labels         = activityData.map(d => d.date);
    const permitData     = activityData.map(d => d.permit);
    const archData       = activityData.map(d => d.architectural);
    const structData     = activityData.map(d => d.structural);
    const electricalData = activityData.map(d => d.electrical);
    const plumbingData   = activityData.map(d => d.plumbing);

    new Chart(document.getElementById('activityChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Permit',
                    data: permitData,
                    borderColor: '#0dcaf0',
                    backgroundColor: 'rgba(13, 202, 240, 0.1)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Architectural',
                    data: archData,
                    borderColor: '#6610f2',
                    backgroundColor: 'rgba(102, 16, 242, 0.1)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Structural',
                    data: structData,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Electrical',
                    data: electricalData,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Plumbing',
                    data: plumbingData,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                },
            },
        },
    });