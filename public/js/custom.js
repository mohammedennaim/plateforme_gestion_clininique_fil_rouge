document.addEventListener('DOMContentLoaded', function () {
    // Initialize date and time
    updateDateTime();
    setInterval(updateDateTime, 60000); // Update every minute

    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
            if (sidebar.classList.contains('open')) {
                sidebar.style.left = '0';
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.style.left = '-260px';
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('open');
            sidebar.style.left = '-260px';
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Mobile notifications toggle
    const mobileNotificationsToggle = document.getElementById('mobile-notifications-toggle');
    const mobileNotificationsPanel = document.getElementById('mobile-notifications-panel');

    if (mobileNotificationsToggle && mobileNotificationsPanel) {
        mobileNotificationsToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            mobileNotificationsPanel.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!mobileNotificationsPanel.contains(e.target) && e.target !== mobileNotificationsToggle) {
                mobileNotificationsPanel.classList.add('hidden');
            }
        });
    }

    // Toggle active class on sidebar items
    const sidebarItems = document.querySelectorAll('.sidebar-item');
    const sections = document.querySelectorAll('.dashboard-section');

    sidebarItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            const targetSection = this.getAttribute('data-section');

            // Update active sidebar item
            sidebarItems.forEach(sideItem => sideItem.classList.remove('active'));
            this.classList.add('active');

            // Show the selected section
            sections.forEach(section => {
                section.classList.remove('active');
                section.classList.add('hidden');
            });

            const activeSection = document.getElementById(`${targetSection}-section`);
            if (activeSection) {
                activeSection.classList.remove('hidden');
                setTimeout(() => {
                    activeSection.classList.add('active');
                }, 10);
            }

            // Close sidebar on mobile after selection
            if (window.innerWidth < 768) {
                sidebar.classList.remove('open');
                sidebar.style.left = '-260px';
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Tab handling
    const tabButtons = document.querySelectorAll('.tab-button[data-tab]');

    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const tabContainer = this.closest('div').parentNode;
            const tabId = this.getAttribute('data-tab');

            // Update active tab
            tabContainer.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');

            // Show the selected tab content
            tabContainer.parentNode.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            document.getElementById(tabId).classList.remove('hidden');
        });
    });

    // Task panel tabs
    const activityTab = document.getElementById('tab-activity');
    const tasksTab = document.getElementById('tab-tasks');
    const messagesTab = document.getElementById('tab-messages');

    if (activityTab && tasksTab && messagesTab) {
        activityTab.addEventListener('click', function () {
            this.classList.add('active');
            tasksTab.classList.remove('active');
            messagesTab.classList.remove('active');

            document.getElementById('panel-activity').classList.remove('hidden');
            document.getElementById('panel-tasks').classList.add('hidden');
            document.getElementById('panel-messages').classList.add('hidden');
        });

        tasksTab.addEventListener('click', function () {
            this.classList.add('active');
            activityTab.classList.remove('active');
            messagesTab.classList.remove('active');

            document.getElementById('panel-tasks').classList.remove('hidden');
            document.getElementById('panel-activity').classList.add('hidden');
            document.getElementById('panel-messages').classList.add('hidden');
        });

        messagesTab.addEventListener('click', function () {
            this.classList.add('active');
            activityTab.classList.remove('active');
            tasksTab.classList.remove('active');

            document.getElementById('panel-messages').classList.remove('hidden');
            document.getElementById('panel-activity').classList.add('hidden');
            document.getElementById('panel-tasks').classList.add('hidden');
        });
    }

    // Initialize charts
    initializeCharts();

    // Populate data
    populateAppointmentsList();
    populatePatientsList();
    populateActivityList();
    populateTasksList();
    populateMessagesList();
    populateCalendar();

    // Countdown timer for next appointment
    initializeCountdown();

    // Progress bar animation on load
    animateProgressBars();

    // Chart period buttons
    const chartPeriodButtons = document.querySelectorAll('.chart-period');
    chartPeriodButtons.forEach(button => {
        button.addEventListener('click', function() {
            chartPeriodButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-indigo-600', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700');
            });
            
            this.classList.add('active', 'bg-indigo-600', 'text-white');
            this.classList.remove('bg-white', 'text-gray-700');
            
            const period = this.getAttribute('data-period');
            updateChartForPeriod(period);
        });
    });

    // Quick actions
    const quickActions = document.querySelectorAll('.quick-action');
    quickActions.forEach(action => {
        action.addEventListener('click', function() {
            const actionType = this.getAttribute('data-action');
            handleQuickAction(actionType);
        });
    });

    // Task modal
    const addTaskBtn = document.getElementById('add-task-btn');
    const addTaskModal = document.getElementById('add-task-modal');
    const closeTaskModal = document.getElementById('close-task-modal');
    const cancelTask = document.getElementById('cancel-task');
    const addTaskForm = document.getElementById('add-task-form');

    if (addTaskBtn && addTaskModal) {
        addTaskBtn.addEventListener('click', function() {
            addTaskModal.classList.remove('hidden');
        });
    }

    if (closeTaskModal) {
        closeTaskModal.addEventListener('click', function() {
            addTaskModal.classList.add('hidden');
        });
    }

    if (cancelTask) {
        cancelTask.addEventListener('click', function() {
            addTaskModal.classList.add('hidden');
        });
    }

    if (addTaskForm) {
        addTaskForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const title = document.getElementById('task-title').value;
            const priority = document.getElementById('task-priority').value;
            
            addNewTask(title, priority);
            addTaskModal.classList.add('hidden');
            addTaskForm.reset();
        });
    }

    // Quick action modals
    const closeModalButtons = document.querySelectorAll('.close-modal, .cancel-modal');
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.fixed');
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    });

    // New patient form
    const newPatientForm = document.getElementById('new-patient-form');
    if (newPatientForm) {
        newPatientForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const firstName = document.getElementById('patient-first-name').value;
            const lastName = document.getElementById('patient-last-name').value;
            
            // Show success message
            alert(`Patient ${firstName} ${lastName} ajouté avec succès!`);
            
            // Close modal and reset form
            document.getElementById('new-patient-modal').classList.add('hidden');
            newPatientForm.reset();
        });
    }

    // New appointment form
    const newAppointmentForm = document.getElementById('new-appointment-form');
    if (newAppointmentForm) {
        newAppointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const patientSelect = document.getElementById('appointment-patient');
            const patientName = patientSelect.options[patientSelect.selectedIndex].text;
            const date = document.getElementById('appointment-date').value;
            
            // Show success message
            alert(`Rendez-vous planifié avec ${patientName} pour le ${date}`);
            
            // Close modal and reset form
            document.getElementById('new-appointment-modal').classList.add('hidden');
            newAppointmentForm.reset();
        });
    }

    // Calendar navigation
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const todayBtn = document.getElementById('today-button');
    
    if (prevMonthBtn && nextMonthBtn && todayBtn) {
        let currentDate = new Date();
        
        prevMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendarHeader(currentDate);
            populateCalendar(currentDate);
        });
        
        nextMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendarHeader(currentDate);
            populateCalendar(currentDate);
        });
        
        todayBtn.addEventListener('click', function() {
            currentDate = new Date();
            updateCalendarHeader(currentDate);
            populateCalendar(currentDate);
        });
    }

    // Export revenue button
    const exportRevenueBtn = document.getElementById('export-revenue');
    if (exportRevenueBtn) {
        exportRevenueBtn.addEventListener('click', function() {
            alert('Rapport de revenus exporté en format CSV');
        });
    }
});

// Update date and time
function updateDateTime() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateTimeElement = document.getElementById('current-date-time');
    
    if (dateTimeElement) {
        const formattedDate = now.toLocaleDateString('fr-FR', options);
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        
        dateTimeElement.textContent = `${formattedDate} - ${hours}:${minutes}`;
    }
}

// Initialize countdown timer
function initializeCountdown() {
    const countdownEl = document.getElementById('appointment-countdown');
    if (countdownEl) {
        // Get appointment time from the element or set a default
        let targetTimeStr = countdownEl.getAttribute('data-appointment-time');
        let targetTime;

        if (targetTimeStr) {
            targetTime = new Date(targetTimeStr);
        } else {
            // Default fallback time
            targetTime = new Date();
            targetTime.setHours(targetTime.getHours() + 1);
        }

        function updateCountdown() {
            const now = new Date();
            if (now > targetTime) {
                countdownEl.textContent = 'En cours';
                countdownEl.parentNode.classList.remove('bg-red-100', 'text-red-800');
                countdownEl.parentNode.classList.add('bg-green-100', 'text-green-800');
                countdownEl.previousElementSibling.classList.remove('fa-clock');
                countdownEl.previousElementSibling.classList.add('fa-check-circle');
                return;
            }

            const diff = targetTime - now;
            const minutes = Math.floor(diff / 1000 / 60);
            const seconds = Math.floor((diff / 1000) % 60);

            countdownEl.textContent = `Dans ${minutes}m ${seconds}s`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
}

// Animate progress bars
function animateProgressBars() {
    const progressBars = document.querySelectorAll('.progress-bar-fill');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });
}

// Initialize charts
function initializeCharts() {
    if (typeof Chart !== 'undefined') {
        // Patient visits chart
        const visitsCtx = document.getElementById('patientVisitsChart');
        if (visitsCtx) {
            window.patientVisitsChart = new Chart(visitsCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Visites patients',
                        data: [65, 59, 80, 81, 56, 55, 72, 78, 80, 85, 90, 95],
                        fill: true,
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderColor: 'rgba(99, 102, 241, 0.8)',
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: 'rgba(99, 102, 241, 1)',
                        pointBorderWidth: 2
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
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#1e293b',
                            bodyColor: '#1e293b',
                            borderColor: 'rgba(99, 102, 241, 0.5)',
                            borderWidth: 1,
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(226, 232, 240, 0.5)'
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        }
                    }
                }
            });
        }

        // Revenue chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            window.revenueChart = new Chart(revenueCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Consultations', 'Traitements', 'Tests Labo', 'Médicaments', 'Autres'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(148, 163, 184, 0.8)'
                        ],
                        borderColor: 'white',
                        borderWidth: 2,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                padding: 20,
                                font: {
                                    size: 12
                                },
                                color: '#4b5563'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#1e293b',
                            bodyColor: '#1e293b',
                            borderColor: 'rgba(148, 163, 184, 0.5)',
                            borderWidth: 1,
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    }
                }
            });
        }

        // Age distribution chart (demographics tab)
        const ageDistributionCtx = document.getElementById('ageDistributionChart');
        if (ageDistributionCtx) {
            new Chart(ageDistributionCtx, {
                type: 'bar',
                data: {
                    labels: ['0-18', '19-30', '31-45', '46-60', '61-75', '76+'],
                    datasets: [{
                        label: 'Nombre de patients',
                        data: [28, 45, 67, 52, 38, 18],
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        borderColor: 'rgba(99, 102, 241, 1)',
                        borderWidth: 1
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
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Gender distribution chart (demographics tab)
        const genderDistributionCtx = document.getElementById('genderDistributionChart');
        if (genderDistributionCtx) {
            new Chart(genderDistributionCtx, {
                type: 'pie',
                data: {
                    labels: ['Femmes', 'Hommes', 'Autres'],
                    datasets: [{
                        data: [142, 103, 3],
                        backgroundColor: [
                            'rgba(236, 72, 153, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(107, 114, 128, 0.8)'
                        ],
                        borderColor: 'white',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        }

        // Revenue evolution chart (revenue tab)
        const revenueEvolutionCtx = document.getElementById('revenueEvolutionChart');
        if (revenueEvolutionCtx) {
            new Chart(revenueEvolutionCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Revenus 2025',
                        data: [38000, 42000, 40000, 45800, 0, 0, 0, 0, 0, 0, 0, 0],
                        borderColor: 'rgba(99, 102, 241, 1)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.4
                    }, {
                        label: 'Revenus 2024',
                        data: [32000, 36000, 35000, 40000, 38000, 42000, 45000, 43000, 40000, 42000, 44000, 48000],
                        borderColor: 'rgba(209, 213, 219, 1)',
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' MAD';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Doctor performance chart (performance tab)
        const doctorPerformanceCtx = document.getElementById('doctorPerformanceChart');
        if (doctorPerformanceCtx) {
            new Chart(doctorPerformanceCtx, {
                type: 'bar',
                data: {
                    labels: ['Dr. Dupont', 'Dr. Moreau', 'Dr. Petit', 'Dr. Dubois', 'Dr. Laurent'],
                    datasets: [{
                        label: 'Patients par jour',
                        data: [12, 9, 10, 8, 11],
                        backgroundColor: 'rgba(99, 102, 241, 0.8)'
                    }, {
                        label: 'Satisfaction (sur 10)',
                        data: [9.2, 8.7, 9.5, 8.9, 9.1],
                        backgroundColor: 'rgba(16, 185, 129, 0.8)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
}

// Update chart for different periods
function updateChartForPeriod(period) {
    if (!window.patientVisitsChart) return;
    
    let labels, data;
    
    switch(period) {
        case 'week':
            labels = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            data = [12, 15, 18, 14, 20, 8, 5];
            break;
        case 'month':
            labels = ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'];
            data = [45, 52, 48, 40];
            break;
        case 'year':
            labels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            data = [65, 59, 80, 81, 56, 55, 72, 78, 80, 85, 90, 95];
            break;
        default:
            return;
    }
    
    window.patientVisitsChart.data.labels = labels;
    window.patientVisitsChart.data.datasets[0].data = data;
    window.patientVisitsChart.update();
    
    // Update total visits text
    const totalVisitsElement = document.getElementById('total-visits-month');
    if (totalVisitsElement) {
        let total = data.reduce((a, b) => a + b, 0);
        totalVisitsElement.textContent = total;
    }
}

// Populate appointments list
function populateAppointmentsList() {
    const appointmentsList = document.getElementById('today-appointments-list');
    if (!appointmentsList) return;
    
    const appointments = [
        {
            patient: { name: 'Sophie Moreau', avatar: 'https://ui-avatars.com/api/?name=Sophie+Moreau&background=6366F1&color=ffffff' },
            doctor: { name: 'Dr. Dupont' },
            time: '12:30',
            status: 'confirmed',
            statusColor: 'green-600'
        },
        {
            patient: { name: 'Jean Petit', avatar: 'https://ui-avatars.com/api/?name=Jean+Petit&background=10B981&color=ffffff' },
            doctor: { name: 'Dr. Dupont' },
            time: '14:00',
            status: 'confirmed',
            statusColor: 'green-600'
        },
        {
            patient: { name: 'Marie Dubois', avatar: 'https://ui-avatars.com/api/?name=Marie+Dubois&background=F97316&color=ffffff' },
            doctor: { name: 'Dr. Dupont' },
            time: '15:15',
            status: 'pending',
            statusColor: 'amber-600'
        },
        {
            patient: { name: 'Pierre Martin', avatar: 'https://ui-avatars.com/api/?name=Pierre+Martin&background=EF4444&color=ffffff' },
            doctor: { name: 'Dr. Dupont' },
            time: '16:30',
            status: 'confirmed',
            statusColor: 'green-600'
        },
        {
            patient: { name: 'Isabelle Laurent', avatar: 'https://ui-avatars.com/api/?name=Isabelle+Laurent&background=8B5CF6&color=ffffff' },
            doctor: { name: 'Dr. Dupont' },
            time: '17:45',
            status: 'confirmed',
            statusColor: 'green-600'
        }
    ];
    
    appointmentsList.innerHTML = '';
    
    appointments.forEach(appointment => {
        const appointmentCard = document.createElement('li');
        appointmentCard.className = 'appointment-card';
        appointmentCard.innerHTML = `
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="${appointment.patient.avatar}" alt="${appointment.patient.name}">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-indigo-600">${appointment.patient.name}</p>
                            <p class="text-xs text-gray-500">${appointment.doctor.name} • ${appointment.time}</p>
                            <div class="flex items-center mt-1">
                                <span class="status-indicator status-${appointment.status}"></span>
                                <span class="text-xs font-medium text-${appointment.statusColor}">${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-1.5 rounded-full text-indigo-600 hover:bg-indigo-50 transition-colors">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="p-1.5 rounded-full text-green-600 hover:bg-green-50 transition-colors">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        appointmentsList.appendChild(appointmentCard);
    });
}

// Populate patients list
function populatePatientsList() {
    const patientListing = document.getElementById('patient-listing');
    if (!patientListing) return;
    
    const patients = [
        {
            name: 'Sophie Moreau',
            id: '2458',
            avatar: 'https://ui-avatars.com/api/?name=Sophie+Moreau&background=6366F1&color=ffffff',
            age: '42',
            gender: 'Femme',
            phone: '+212 6 12 34 56 78',
            lastVisit: '15 Mars 2025',
            nextAppointment: '12 Avr 2025'
        },
        {
            name: 'Jean Petit',
            id: '2459',
            avatar: 'https://ui-avatars.com/api/?name=Jean+Petit&background=10B981&color=ffffff',
            age: '35',
            gender: 'Homme',
            phone: '+212 6 23 45 67 89',
            lastVisit: '28 Mars 2025',
            nextAppointment: '12 Avr 2025'
        },
        {
            name: 'Marie Dubois',
            id: '2460',
            avatar: 'https://ui-avatars.com/api/?name=Marie+Dubois&background=F97316&color=ffffff',
            age: '29',
            gender: 'Femme',
            phone: '+212 6 34 56 78 90',
            lastVisit: '2 Avr 2025',
            nextAppointment: '12 Avr 2025'
        },
        {
            name: 'Pierre Martin',
            id: '2461',
            avatar: 'https://ui-avatars.com/api/?name=Pierre+Martin&background=EF4444&color=ffffff',
            age: '58',
            gender: 'Homme',
            phone: '+212 6 45 67 89 01',
            lastVisit: '5 Avr 2025',
            nextAppointment: '12 Avr 2025'
        },
        {
            name: 'Isabelle Laurent',
            id: '2462',
            avatar: 'https://ui-avatars.com/api/?name=Isabelle+Laurent&background=8B5CF6&color=ffffff',
            age: '47',
            gender: 'Femme',
            phone: '+212 6 56 78 90 12',
            lastVisit: '8 Avr 2025',
            nextAppointment: '12 Avr 2025'
        },
        {
            name: 'Thomas Bernard',
            id: '2463',
            avatar: 'https://ui-avatars.com/api/?name=Thomas+Bernard&background=EC4899&color=ffffff',
            age: '52',
            gender: 'Homme',
            phone: '+212 6 67 89 01 23',
            lastVisit: '10 Avr 2025',
            nextAppointment: '15 Avr 2025'
        },
        {
            name: 'Camille Roux',
            id: '2464',
            avatar: 'https://ui-avatars.com/api/?name=Camille+Roux&background=14B8A6&color=ffffff',
            age: '31',
            gender: 'Femme',
            phone: '+212 6 78 90 12 34',
            lastVisit: '11 Avr 2025',
            nextAppointment: '18 Avr 2025'
        },
        {
            name: 'Lucas Fournier',
            id: '2465',
            avatar: 'https://ui-avatars.com/api/?name=Lucas+Fournier&background=F59E0B&color=ffffff',
            age: '25',
            gender: 'Homme',
            phone: '+212 6 89 01 23 45',
            lastVisit: '11 Avr 2025',
            nextAppointment: '20 Avr 2025'
        },
        {
            name: 'Emma Girard',
            id: '2466',
            avatar: 'https://ui-avatars.com/api/?name=Emma+Girard&background=6366F1&color=ffffff',
            age: '38',
            gender: 'Femme',
            phone: '+212 6 90 12 34 56',
            lastVisit: '12 Avr 2025',
            nextAppointment: '26 Avr 2025'
        }
    ];
    
    patientListing.innerHTML = '';
    
    patients.forEach(patient => {
        const patientCard = document.createElement('div');
        patientCard.className = 'patient-card bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm';
        patientCard.innerHTML = `
            <div class="px-4 py-4 sm:px-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden bg-indigo-100">
                        <img src="${patient.avatar}" alt="${patient.name}">
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-indigo-600">${patient.name}</h3>
                                <p class="text-sm text-gray-500">ID: #P-${patient.id}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                Actif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 px-4 py-4 sm:px-6 bg-gray-50">
                <div class="grid grid-cols-3 gap-2 text-sm">
                    <div>
                        <p class="text-gray-500">Âge</p>
                        <p class="font-medium">${patient.age} ans</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Genre</p>
                        <p class="font-medium">${patient.gender}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Téléphone</p>
                        <p class="font-medium">${patient.phone}</p>
                    </div>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <p class="text-gray-500">Dernière visite</p>
                        <p class="font-medium">${patient.lastVisit}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Prochain RDV</p>
                        <p class="font-medium text-indigo-600">${patient.nextAppointment}</p>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 flex justify-between border-t border-gray-200">
                <div class="patient-actions flex space-x-2">
                    <button class="text-sm text-indigo-600 hover:text-indigo-500">
                        <i class="fas fa-file-medical"></i>
                    </button>
                    <button class="text-sm text-emerald-600 hover:text-emerald-500">
                        <i class="fas fa-calendar-plus"></i>
                    </button>
                    <button class="text-sm text-blue-600 hover:text-blue-500">
                        <i class="fas fa-comments"></i>
                    </button>
                </div>
                <button class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                    Voir détails
                </button>
            </div>
        `;
        patientListing.appendChild(patientCard);
    });
    
    // Update appointment patient select options
    const appointmentPatientSelect = document.getElementById('appointment-patient');
    if (appointmentPatientSelect) {
        patients.forEach(patient => {
            const option = document.createElement('option');
            option.value = `patient-${patient.id}`;
            option.textContent = patient.name;
            appointmentPatientSelect.appendChild(option);
        });
    }
}

// Populate activity list
function populateActivityList() {
    const activityList = document.getElementById('activity-list');
    if (!activityList) return;
    
    const activities = [
        {
            type: 'appointment',
            icon: 'calendar-check',
            iconColor: 'bg-emerald-100 text-emerald-600',
            title: 'Rendez-vous confirmé',
            description: 'Sophie Moreau a confirmé son rendez-vous pour aujourd\'hui à 12:30',
            time: 'Il y a 35 minutes'
        },
        {
            type: 'patient',
            icon: 'user-plus',
            iconColor: 'bg-indigo-100 text-indigo-600',
            title: 'Nouveau patient',
            description: 'Lucas Fournier a été ajouté comme nouveau patient',
            time: 'Il y a 2 heures'
        },
        {
            type: 'lab',
            icon: 'flask',
            iconColor: 'bg-amber-100 text-amber-600',
            title: 'Résultats d\'analyses',
            description: 'Les résultats d\'analyses de Marie Dubois sont disponibles',
            time: 'Il y a 3 heures'
        },
        {
            type: 'message',
            icon: 'envelope',
            iconColor: 'bg-blue-100 text-blue-600',
            title: 'Nouveau message',
            description: 'Dr. Laurent a envoyé un message concernant le patient Pierre Martin',
            time: 'Il y a 5 heures'
        },
        {
            type: 'prescription',
            icon: 'prescription',
            iconColor: 'bg-purple-100 text-purple-600',
            title: 'Ordonnance créée',
            description: 'Une nouvelle ordonnance a été créée pour Isabelle Laurent',
            time: 'Il y a 1 jour'
        }
    ];
    
    activityList.innerHTML = '';
    
    activities.forEach((activity, index) => {
        const activityItem = document.createElement('li');
        activityItem.className = 'mb-6';
        
        // Add connecting line for all but the last item
        if (index < activities.length - 1) {
            activityItem.classList.add('pb-6', 'border-l-2', 'border-gray-200', 'ml-3');
        }
        
        activityItem.innerHTML = `
            <div class="relative flex items-start">
                <div class="absolute -left-5 mt-0.5">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full ${activity.iconColor}">
                        <i class="fas fa-${activity.icon}"></i>
                    </div>
                </div>
                <div class="ml-6">
                    <h4 class="text-sm font-medium text-gray-900">${activity.title}</h4>
                    <p class="mt-1 text-sm text-gray-600">${activity.description}</p>
                    <p class="mt-1 text-xs text-gray-500">${activity.time}</p>
                </div>
            </div>
        `;
        
        activityList.appendChild(activityItem);
    });
}

// Populate tasks list
function populateTasksList() {
    const taskList = document.getElementById('task-list');
    if (!taskList) return;
    
    const tasks = [
        {
            id: 1,
            text: 'Appeler Sophie Moreau pour confirmer son rendez-vous',
            checked: true,
            priority: 'high'
        },
        {
            id: 2,
            text: 'Vérifier les résultats d\'analyses de Marie Dubois',
            checked: false,
            priority: 'high'
        },
        {
            id: 3,
            text: 'Mettre à jour le dossier médical de Jean Petit',
            checked: false,
            priority: 'medium'
        },
        {
            id: 4,
            text: 'Préparer l\'ordonnance pour Pierre Martin',
            checked: false,
            priority: 'medium'
        },
        {
            id: 5,
            text: 'Planifier une réunion avec l\'équipe médicale',
            checked: false,
            priority: 'low'
        }
    ];
    
    taskList.innerHTML = '';
    
    tasks.forEach(task => {
        const taskItem = document.createElement('div');
        taskItem.className = 'task-item flex items-start';
        
        // Add priority color
        let priorityColor = '';
        switch(task.priority) {
            case 'high':
                priorityColor = 'border-l-4 border-red-500 pl-3';
                break;
            case 'medium':
                priorityColor = 'border-l-4 border-amber-500 pl-3';
                break;
            case 'low':
                priorityColor = 'border-l-4 border-green-500 pl-3';
                break;
        }
        
        taskItem.classList.add(priorityColor);
        
        taskItem.innerHTML = `
            <div class="task-checkbox ${task.checked ? 'checked' : ''}" data-task-id="${task.id}"></div>
            <div class="ml-3 flex-1">
                <p class="text-sm text-gray-700 task-text ${task.checked ? 'checked' : ''}">${task.text}</p>
            </div>
            <button class="text-gray-400 hover:text-gray-600 delete-task" data-task-id="${task.id}">
                <i class="fas fa-trash-alt"></i>
            </button>
        `;
        
        taskList.appendChild(taskItem);
    });
    
    // Add task checkbox event listeners
    const taskCheckboxes = document.querySelectorAll('.task-checkbox');
    taskCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function() {
            const taskItem = this.closest('.task-item');
            const taskText = taskItem.querySelector('.task-text');
            
            this.classList.toggle('checked');
            taskText.classList.toggle('checked');
        });
    });
    
    // Add delete task event listeners
    const deleteTaskButtons = document.querySelectorAll('.delete-task');
    deleteTaskButtons.forEach(button => {
        button.addEventListener('click', function() {
            const taskItem = this.closest('.task-item');
            taskItem.remove();
            
            // Update task count
            const taskCount = document.getElementById('task-count');
            if (taskCount) {
                const currentCount = parseInt(taskCount.textContent);
                taskCount.textContent = currentCount - 1;
            }
        });
    });
}

// Add new task
function addNewTask(title, priority) {
    const taskList = document.getElementById('task-list');
    if (!taskList) return;
    
    const taskId = Date.now();
    const taskItem = document.createElement('div');
    taskItem.className = 'task-item flex items-start';
    
    // Add priority color
    let priorityColor = '';
    switch(priority) {
        case 'high':
            priorityColor = 'border-l-4 border-red-500 pl-3';
            break;
        case 'medium':
            priorityColor = 'border-l-4 border-amber-500 pl-3';
            break;
        case 'low':
            priorityColor = 'border-l-4 border-green-500 pl-3';
            break;
    }
    
    taskItem.classList.add(priorityColor);
    
    taskItem.innerHTML = `
        <div class="task-checkbox" data-task-id="${taskId}"></div>
        <div class="ml-3 flex-1">
            <p class="text-sm text-gray-700 task-text">${title}</p>
        </div>
        <button class="text-gray-400 hover:text-gray-600 delete-task" data-task-id="${taskId}">
            <i class="fas fa-trash-alt"></i>
        </button>
    `;
    
    taskList.prepend(taskItem);
    
    // Add task checkbox event listener
    const checkbox = taskItem.querySelector('.task-checkbox');
    checkbox.addEventListener('click', function() {
        const taskText = taskItem.querySelector('.task-text');
        
        this.classList.toggle('checked');
        taskText.classList.toggle('checked');
    });
    
    // Add delete task event listener
    const deleteButton = taskItem.querySelector('.delete-task');
    deleteButton.addEventListener('click', function() {
        taskItem.remove();
        
        // Update task count
        const taskCount = document.getElementById('task-count');
        if (taskCount) {
            const currentCount = parseInt(taskCount.textContent);
            taskCount.textContent = currentCount - 1;
        }
    });
    
    // Update task count
    const taskCount = document.getElementById('task-count');
    if (taskCount) {
        const currentCount = parseInt(taskCount.textContent);
        taskCount.textContent = currentCount + 1;
    }
}

// Populate messages list
function populateMessagesList() {
    const messageList = document.getElementById('message-list');
    if (!messageList) return;
    
    const messages = [
        {
            sender: 'Dr. Laurent',
            avatar: 'https://ui-avatars.com/api/?name=Dr+Laurent&background=6366F1&color=ffffff',
            message: 'Bonjour, pouvez-vous me transmettre le dossier médical de Pierre Martin ?',
            time: 'Il y a 2 heures',
            unread: true
        },
        {
            sender: 'Marie Dubois',
            avatar: 'https://ui-avatars.com/api/?name=Marie+Dubois&background=F97316&color=ffffff',
            message: 'Bonjour Docteur, je voulais savoir si mes résultats d\'analyses sont disponibles.',
            time: 'Il y a 3 heures',
            unread: true
        },
        {
            sender: 'Secrétariat',
            avatar: 'https://ui-avatars.com/api/?name=Secretariat&background=10B981&color=ffffff',
            message: 'Rappel : réunion d\'équipe demain à 9h dans la salle de conférence.',
            time: 'Il y a 5 heures',
            unread: true
        },
        {
            sender: 'Jean Petit',
            avatar: 'https://ui-avatars.com/api/?name=Jean+Petit&background=10B981&color=ffffff',
            message: 'Merci pour la consultation d\'hier, j\'ai commencé le traitement comme prescrit.',
            time: 'Il y a 1 jour',
            unread: true
        }
    ];
    
    messageList.innerHTML = '';
    
    messages.forEach(message => {
        const messageItem = document.createElement('div');
        messageItem.className = 'message-item p-4 hover:bg-gray-50';
        
        if (message.unread) {
            messageItem.classList.add('border-l-4', 'border-indigo-500', 'pl-3');
        }
        
        messageItem.innerHTML = `
            <div class="flex items-start">
                <img class="h-10 w-10 rounded-full mr-3" src="${message.avatar}" alt="${message.sender}">
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between">
                        <p class="text-sm font-medium text-gray-900">${message.sender}</p>
                        <p class="text-xs text-gray-500">${message.time}</p>
                    </div>
                    <p class="text-sm text-gray-600 truncate">${message.message}</p>
                </div>
            </div>
        `;
        
        messageList.appendChild(messageItem);
    });
    
    // Update mobile notifications list
    const mobileNotificationsList = document.getElementById('mobile-notifications-list');
    if (mobileNotificationsList) {
        mobileNotificationsList.innerHTML = '';
        
        messages.forEach(message => {
            const notificationItem = document.createElement('div');
            notificationItem.className = 'p-4 hover:bg-gray-50';
            
            notificationItem.innerHTML = `
                <div class="flex items-start">
                    <img class="h-8 w-8 rounded-full mr-3" src="${message.avatar}" alt="${message.sender}">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">${message.sender}</p>
                        <p class="text-xs text-gray-600 truncate">${message.message}</p>
                        <p class="text-xs text-gray-500 mt-1">${message.time}</p>
                    </div>
                </div>
            `;
            
            mobileNotificationsList.appendChild(notificationItem);
        });
    }
}

// Populate calendar
function populateCalendar(date = new Date()) {
    const calendarDays = document.getElementById('calendar-days');
    if (!calendarDays) return;
    
    calendarDays.innerHTML = '';
    
    // Update calendar header
    updateCalendarHeader(date);
    
    const year = date.getFullYear();
    const month = date.getMonth();
    
    // Get first day of month and last date
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    
    // Adjust for Monday as first day of week (0 = Monday, 6 = Sunday)
    const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;
    
    // Add empty days for the beginning of the month
    for (let i = 0; i < adjustedFirstDay; i++) {
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day text-gray-400';
        calendarDays.appendChild(dayElement);
    }
    
    // Generate appointments data for the month
    const appointmentsData = generateMonthAppointments(year, month, lastDate);
    
    // Add days of the month
    const today = new Date();
    for (let day = 1; day <= lastDate; day++) {
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day relative';
        dayElement.textContent = day;
        
        // Check if this day has appointments
        const currentDate = new Date(year, month, day);
        const dateString = currentDate.toDateString();
        const hasAppointments = appointmentsData.some(appt => new Date(appt.date).toDateString() === dateString);
        
        if (hasAppointments) {
            dayElement.classList.add('has-appointments');
        }
        
        // Check if this is today
        if (today.getDate() === day && today.getMonth() === month && today.getFullYear() === year) {
            dayElement.classList.add('active');
        }
        
        // Add click event
        dayElement.addEventListener('click', function() {
            document.querySelectorAll('.calendar-day').forEach(d => {
                if (!d.classList.contains('text-gray-400')) {
                    d.classList.remove('active');
                }
            });
            this.classList.add('active');
        });
        
        calendarDays.appendChild(dayElement);
    }
    
    // Update appointment counts
    updateAppointmentCounts(appointmentsData);
}

// Update calendar header
function updateCalendarHeader(date) {
    const calendarMonthYear = document.getElementById('calendar-month-year');
    if (calendarMonthYear) {
        const options = { month: 'long', year: 'numeric' };
        calendarMonthYear.textContent = date.toLocaleDateString('fr-FR', options);
    }
}

// Generate appointments data for the month
function generateMonthAppointments(year, month, lastDate) {
    const appointments = [];
    
    // Generate some random appointments for the month
    const numAppointments = Math.floor(Math.random() * 30) + 20; // 20-50 appointments
    
    for (let i = 0; i < numAppointments; i++) {
        const day = Math.floor(Math.random() * lastDate) + 1;
        const hour = Math.floor(Math.random() * 8) + 9; // 9 AM - 5 PM
        const minute = Math.random() < 0.5 ? 0 : 30; // Either on the hour or half past
        
        const date = new Date(year, month, day, hour, minute);
        
        appointments.push({
            date: date,
            patient: `Patient ${i + 1}`,
            type: Math.random() < 0.7 ? 'Consultation' : 'Suivi'
        });
    }
    
    return appointments;
}

// Update appointment counts
function updateAppointmentCounts(appointments) {
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);
    
    const todayString = today.toDateString();
    const tomorrowString = tomorrow.toDateString();
    
    const todayAppointments = appointments.filter(appt => new Date(appt.date).toDateString() === todayString);
    const tomorrowAppointments = appointments.filter(appt => new Date(appt.date).toDateString() === tomorrowString);
    
    const todayAppointmentsLabel = document.getElementById('today-appointments-label');
    const tomorrowAppointmentsLabel = document.getElementById('tomorrow-appointments-label');
    
    if (todayAppointmentsLabel) {
        todayAppointmentsLabel.textContent = `${todayAppointments.length} aujourd'hui`;
    }
    
    if (tomorrowAppointmentsLabel) {
        tomorrowAppointmentsLabel.textContent = `${tomorrowAppointments.length} demain`;
    }
}

// Handle quick actions
function handleQuickAction(actionType) {
    switch(actionType) {
        case 'new-patient':
            document.getElementById('new-patient-modal').classList.remove('hidden');
            break;
        case 'new-appointment':
            document.getElementById('new-appointment-modal').classList.remove('hidden');
            break;
        case 'medical-records':
            // Navigate to medical records section
            document.querySelector('.sidebar-item[data-section="medical-records"]').click();
            break;
        case 'vital-signs':
            alert('Fonctionnalité de signes vitaux en cours de développement');
            break;
        case 'prescriptions':
            alert('Fonctionnalité d\'ordonnances en cours de développement');
            break;
        case 'analytics':
            // Navigate to analytics section
            document.querySelector('.sidebar-item[data-section="analytics"]').click();
            break;
        default:
            break;
    }
}