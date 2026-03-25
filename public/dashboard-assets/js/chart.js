document.addEventListener('DOMContentLoaded', () => {

    const trafficChart = document.getElementById('trafficChart');
    if(trafficChart){
        const patients = parseInt(trafficChart.getAttribute('data-patients')) || 0;
        const doctors = parseInt(trafficChart.getAttribute('data-doctors')) || 0;
        const appointments = parseInt(trafficChart.getAttribute('data-appointments')) || 0;

        new Chart(trafficChart.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Patients', 'Doctors', 'Appointments'],
                datasets: [{
                    data: [patients, doctors, appointments],
                    backgroundColor: ['#43A9D4', '#68D137', '#7256C5'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '75%'
            }
        });
    }
       
    const barChart = document.getElementById('barChart');
    if (barChart){
        new Chart(barChart.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                datasets: [
                {
                    label: 'Segment 1',
                    data: [35, 28, 34, 32, 40, 20, 45, 25, 30, 35],
                    backgroundColor: '#7256C5',
                    barThickness: 20 
                },
                {
                    label: 'Segment 2',
                    data: [45, 35, 45, 48, 50, 40, 55, 42, 35, 40],
                    backgroundColor: '#68D137',
                    borderRadius: 8,
                    barThickness: 20 
                }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true
                }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                    grid: {
                        display: true
                    },
                    ticks: {
                        display: false
                    }
                    }
                },
            }
        });
    }
       
   
});
