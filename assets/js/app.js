document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-confirm]').forEach((element) => {
        element.addEventListener('click', (event) => {
            if (!window.confirm(element.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    const printButtons = document.querySelectorAll('[data-print]');
    printButtons.forEach((button) => button.addEventListener('click', () => window.print()));

    const chartElement = document.getElementById('slotChart');
    if (chartElement && window.Chart) {
        const data = JSON.parse(chartElement.dataset.chart);
        new Chart(chartElement, {
            type: 'doughnut',
            data: {
                labels: ['Available', 'Occupied', 'Maintenance'],
                datasets: [{
                    data: [data.Available || 0, data.Occupied || 0, data.Maintenance || 0],
                    backgroundColor: ['#198754', '#dc3545', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
});
