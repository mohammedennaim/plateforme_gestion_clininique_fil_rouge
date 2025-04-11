
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarToggleTop = document.getElementById('sidebarToggleTop');
    const body = document.querySelector('body');
    const sidebar = document.querySelector('.sidebar');

    function toggleSidebar() {
        body.classList.toggle('sidebar-toggled');
        sidebar.classList.toggle('toggled');
        localStorage.setItem('sidebarState', sidebar.classList.contains('toggled') ? 'toggled' : 'expanded');
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    if (sidebarToggleTop) {
        sidebarToggleTop.addEventListener('click', toggleSidebar);
    }

    const sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState === 'toggled') {
        body.classList.add('sidebar-toggled');
        sidebar.classList.add('toggled');
    }

    document.querySelectorAll('.deletePatientBtn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.getElementById('deletePatientForm').setAttribute('action', `/admin/patients/${id}`);
        });
    });

    document.querySelectorAll('.deleteDoctorBtn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.getElementById('deleteDoctorForm').setAttribute('action', `/admin/medecins/${id}`);
        });
    });

    document.querySelectorAll('.deleteAppointmentBtn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.getElementById('deleteAppointmentForm').setAttribute('action', `/admin/rendez-vous/${id}`);
        });
    });

    const genderChart = new Chart(
        document.getElementById('genderChart').getContext('2d'),
        {
            type: 'pie',
            data: {
                labels: ['Hommes', 'Femmes'],
                datasets: [{
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        }
    );

    document.getElementById('toggleChartType').addEventListener('click', function () {
        if (appointmentsChart.config.type === 'bar') {
            appointmentsChart.config.type = 'line';
            appointmentsChart.data.datasets[0].tension = 0.4;
            appointmentsChart.data.datasets[0].fill = true;
        } else {
            appointmentsChart.config.type = 'bar';
            appointmentsChart.data.datasets[0].tension = 0;
            appointmentsChart.data.datasets[0].fill = false;
        }
        appointmentsChart.update();
    });

    document.getElementById('refreshDashboard').addEventListener('click', function () {
        this.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm text-white-50"></i> Actualisation...';
        this.disabled = true;

        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Tableau de bord actualisé',
                text: 'Les données ont été mises à jour avec succès!',
                timer: 2000,
                showConfirmButton: false
            });
            this.innerHTML = '<i class="fas fa-sync-alt fa-sm text-white-50"></i> Actualiser';
            this.disabled = false;
        }, 1500);
    });

    document.getElementById('refreshChart').addEventListener('click', function () {
        const loadingToast = Swal.fire({
            title: 'Actualisation...',
            html: 'Mise à jour des données en cours',
            timer: 1500,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        loadingToast.then(() => {
            const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'];
            const newData = months.map(() => Math.floor(Math.random() * 50) + 50);

            appointmentsChart.data.datasets[0].data = newData;
            appointmentsChart.update();

            Swal.fire({
                icon: 'success',
                title: 'Données actualisées',
                showConfirmButton: false,
                timer: 1500
            });
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('toggle-availability')) {
            e.preventDefault();
            const doctorId = e.target.getAttribute('data-doctor-id');
            const currentStatus = e.target.getAttribute('data-status');
            const newStatus = currentStatus === 'available' ? 'unavailable' : 'available';

            // Simuler une mise à jour de la disponibilité
            Swal.fire({
                title: 'Changer la disponibilité?',
                text: `Voulez-vous marquer ce médecin comme ${newStatus === 'available' ? 'disponible' : 'indisponible'}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1cc88a',
                cancelButtonColor: '#e74a3b',
                confirmButtonText: 'Oui, changer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(() => {
                        e.target.setAttribute('data-status', newStatus);
                        e.target.textContent = newStatus === 'available' ? 'Marquer comme indisponible' : 'Marquer comme disponible';

                        const badge = document.querySelector(`#availability-badge-${doctorId}`);
                        if (badge) {
                            badge.className = newStatus === 'available' ? 'badge badge-success' : 'badge badge-warning';
                            badge.textContent = newStatus === 'available' ? 'Disponible' : 'Non disponible';
                        }

                        Swal.fire({
                            title: 'Mise à jour réussie!',
                            text: `Le médecin est maintenant ${newStatus === 'available' ? 'disponible' : 'indisponible'}.`,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }, 800);
                }
            });
        }
    });

    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    window.confirmAppointment = function (id) {
        Swal.fire({
            title: 'Confirmer ce rendez-vous?',
            text: "Cette action enverra une notification au patient.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1cc88a',
            cancelButtonColor: '#e74a3b',
            confirmButtonText: 'Oui, confirmer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/rendez-vous/${id}/confirm`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    window.cancelAppointment = function (id) {
        Swal.fire({
            title: 'Annuler ce rendez-vous?',
            text: "Cette action enverra une notification au patient et libérera ce créneau horaire.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, annuler',
            cancelButtonText: 'Retour'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/rendez-vous/${id}/cancel`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    // Check for flash messages in data attributes
    const successMessage = document.querySelector('[data-flash-success]')?.getAttribute('data-flash-success');
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Succès!',
            text: successMessage,
            timer: 3000,
            showConfirmButton: false
        });
    }

    const errorMessage = document.querySelector('[data-flash-error]')?.getAttribute('data-flash-error');
    if (errorMessage) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur!',
            text: errorMessage,
            confirmButtonColor: '#4e73df'
        });
    }
    
    const scrollTopButton = document.querySelector('.scroll-to-top');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 100) {
            scrollTopButton.style.display = 'block';
            setTimeout(() => scrollTopButton.style.opacity = 1, 50);
        } else {
            scrollTopButton.style.opacity = 0;
            setTimeout(() => {
                if (scrollTopButton.style.opacity === '0') {
                    scrollTopButton.style.display = 'none';
                }
            }, 300);
        }
    });

    scrollTopButton.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    document.getElementById('specialite_filter')?.addEventListener('change', function () {
        const specialiteId = this.value;
        const rows = document.querySelectorAll('#doctorsTable tbody tr');

        rows.forEach(row => {
            const specialiteCell = row.querySelector('td:nth-child(2)').getAttribute('data-specialite-id');
            if (specialiteId === '' || specialiteCell === specialiteId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('doctor_id')?.addEventListener('change', checkDoctorAvailability);
    document.getElementById('date')?.addEventListener('change', checkDoctorAvailability);
    document.getElementById('heure')?.addEventListener('change', checkDoctorAvailability);

    function checkDoctorAvailability() {
        const doctorId = document.getElementById('doctor_id')?.value;
        const date = document.getElementById('date')?.value;
        const time = document.getElementById('heure')?.value;
        const availabilityMessage = document.getElementById('availability_message');

        if (doctorId && date && time && availabilityMessage) {
            availabilityMessage.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Vérification de la disponibilité...';
            availabilityMessage.className = 'text-info mt-2';

            setTimeout(() => {
                const isAvailable = Math.random() > 0.3;

                if (isAvailable) {
                    availabilityMessage.innerHTML = '<i class="fas fa-check-circle"></i> Ce créneau est disponible!';
                    availabilityMessage.className = 'text-success mt-2';
                } else {
                    availabilityMessage.innerHTML = '<i class="fas fa-times-circle"></i> Ce créneau n\'est pas disponible. Veuillez choisir un autre horaire.';
                    availabilityMessage.className = 'text-danger mt-2';
                }
            }, 1000);
        }
    }
});
document.addEventListener('DOMContentLoaded', function () {
    function updateDateTime() {
        const now = new Date();

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateElement = document.getElementById('currentDate');
        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('fr-FR', options);
        }

        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }

    updateDateTime();
    setInterval(updateDateTime, 60000);

    const searchInput = document.getElementById('globalSearch');
    const searchDropdown = document.querySelector('.search-dropdown');

    if (searchInput && searchDropdown) {
        searchInput.addEventListener('focus', function () {
            searchDropdown.classList.remove('d-none');
        });

        document.addEventListener('click', function (event) {
            if (!searchInput.contains(event.target) && !searchDropdown.contains(event.target)) {
                searchDropdown.classList.add('d-none');
            }
        });
    }

    const notificationItems = document.querySelectorAll('.notification-list .dropdown-item');
    notificationItems.forEach(item => {
        item.addEventListener('mouseenter', function () {
            this.style.backgroundColor = 'rgba(78, 115, 223, 0.05)';
            const actionButtons = this.querySelector('.action-buttons');
            if (actionButtons) actionButtons.style.opacity = '1';
        });

        item.addEventListener('mouseleave', function () {
            if (!this.classList.contains('unread')) {
                this.style.backgroundColor = '';
            }
            const actionButtons = this.querySelector('.action-buttons');
            if (actionButtons) actionButtons.style.opacity = '0';
        });
    });

    const quickActionButtons = document.querySelectorAll('.quick-actions .btn');
    quickActionButtons.forEach(button => {
        button.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        });

        button.addEventListener('mouseleave', function () {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
    
    const userMenuItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
    userMenuItems.forEach(item => {
        item.addEventListener('mouseenter', function () {
            this.style.backgroundColor = 'rgba(78, 115, 223, 0.05)';
        });

        item.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '';
        });
    });
});
