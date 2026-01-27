document.addEventListener('DOMContentLoaded', () => {

    const canvas = document.getElementById('fundingChart');
    if (!canvas || !window.fundingChartData) return;

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: window.fundingChartData.labels,
            datasets: [{
                data: window.fundingChartData.values,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
