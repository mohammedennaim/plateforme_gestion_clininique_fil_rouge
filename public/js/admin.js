// Toggle the side navigation
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');
    
    if (sidebar && content) {
        sidebar.classList.toggle('toggled');
        content.classList.toggle('toggled');
    }
}

// Close any open menu accordions when window is resized below 768px
window.addEventListener('resize', () => {
    if (window.innerWidth < 768) {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.classList.add('toggled');
        }
    }
});

// Prevent the content wrapper from scrolling when the fixed side navigation hovered over
document.querySelector('body.fixed-nav .sidebar').addEventListener('mousewheel DOMMouseScroll', (e) => {
    if (window.innerWidth > 768) {
        const e0 = e.originalEvent;
        const delta = e0.wheelDelta || -e0.detail;
        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
        e.preventDefault();
    }
});

// Scroll to top button appear
document.addEventListener('scroll', () => {
    const scrollToTop = document.querySelector('.scroll-to-top');
    if (scrollToTop) {
        if (document.documentElement.scrollTop > 100) {
            scrollToTop.style.display = 'block';
        } else {
            scrollToTop.style.display = 'none';
        }
    }
});

// Smooth scrolling using jQuery easing
document.querySelector('a.scroll-to-top').addEventListener('click', (e) => {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    }
});

// Initialize charts
function initCharts() {
    // Area Chart
    const areaChartCtx = document.getElementById('appointmentsChart');
    if (areaChartCtx) {
        new Chart(areaChartCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Appointments',
                    lineTension: 0.3,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value) {
                                return '$' + value;
                            }
                        },
                        gridLines: {
                            color: 'rgb(234, 236, 244)',
                            zeroLineColor: 'rgb(234, 236, 244)',
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: 'rgb(255,255,255)',
                    bodyFontColor: '#858796',
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': $' + tooltipItem.yLabel;
                        }
                    }
                }
            }
        });
    }

    // Pie Chart
    const pieChartCtx = document.getElementById('patientsChart');
    if (pieChartCtx) {
        new Chart(pieChartCtx, {
            type: 'doughnut',
            data: {
                labels: ['With Insurance', 'Without Insurance'],
                datasets: [{
                    data: [55, 45],
                    backgroundColor: ['#4e73df', '#1cc88a'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673'],
                    hoverBorderColor: 'rgba(234, 236, 244, 1)',
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: 'rgb(255,255,255)',
                    bodyFontColor: '#858796',
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
    }
}

// Initialize all charts when the page loads
document.addEventListener('DOMContentLoaded', () => {
    initCharts();
});

// Handle request approvals and rejections
function approveRequest(requestId) {
    // Implement approval logic here
    console.log('Approving request:', requestId);
    // You would typically make an AJAX call to your backend here
}

function rejectRequest(requestId) {
    // Implement rejection logic here
    console.log('Rejecting request:', requestId);
    // You would typically make an AJAX call to your backend here
}

// Handle search functionality
function handleSearch(event) {
    event.preventDefault();
    const searchInput = document.querySelector('.search-input');
    const searchTerm = searchInput.value.trim();
    
    if (searchTerm) {
        // Implement search logic here
        console.log('Searching for:', searchTerm);
        // You would typically make an AJAX call to your backend here
    }
}

// Add event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Search form submission
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }

    // Toggle sidebar button
    const sidebarToggle = document.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    // Scroll to top button
    const scrollToTop = document.querySelector('.scroll-to-top');
    if (scrollToTop) {
        scrollToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
}); 