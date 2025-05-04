@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil du Médecin</h1>
        <a href="" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;"
                            src="{{ $doctor->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($doctor->user->name).'&color=4E73DF&background=F0F4FD' }}" 
                            alt="Photo de profil">
                        <h5 class="font-weight-bold">Dr. {{ $doctor->user->name }}</h5>
                        <div class="text-primary">{{ $doctor->speciality }}</div>
                        <div class="text-gray-500">ID: {{ $doctor->id }}</div>
                        <div class="mt-3 d-flex justify-content-center">
                            <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-primary btn-sm mr-2">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteDoctorModal">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                    <div class="doctor-info">
                        <h6 class="font-weight-bold">Coordonnées</h6>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-envelope mr-2 text-gray-500"></i> <strong>Email:</strong></p>
                            <p>{{ $doctor->user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-phone mr-2 text-gray-500"></i> <strong>Téléphone:</strong></p>
                            <p>{{ $doctor->user->phone ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-hospital mr-2 text-gray-500"></i> <strong>Cabinet:</strong></p>
                            <p>{{ $doctor->nombre_cabinet }}</p>
                        </div>
                        
                        <h6 class="font-weight-bold mt-4">Disponibilité</h6>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-clock mr-2 text-gray-500"></i> <strong>Statut:</strong></p>
                            <p>
                                @if($doctor->is_available)
                                    <span class="badge badge-success">Disponible</span>
                                @else
                                    <span class="badge badge-warning">Non disponible</span>
                                @endif
                            </p>
                        </div>
                        <button class="btn btn-outline-primary btn-block toggle-availability" 
                                data-doctor-id="{{ $doctor->id }}" 
                                data-status="{{ $doctor->is_available ? 'available' : 'unavailable' }}">
                            <i class="fas fa-exchange-alt mr-1"></i>
                            {{ $doctor->is_available ? 'Marquer comme indisponible' : 'Marquer comme disponible' }}
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Schedule Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Horaires</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                        <i class="fas fa-edit fa-sm"></i>
                    </button>
                </div>
                <div class="card-body">
                    @if($doctor->schedules && $doctor->schedules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-borderless" width="100%" cellspacing="0">
                                <tbody>
                                    @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $index => $day)
                                        @php
                                            $daySchedule = $doctor->schedules->where('day', $index + 1)->first();
                                        @endphp
                                        <tr>
                                            <td class="font-weight-bold">{{ $day }}</td>
                                            <td>
                                                @if($daySchedule && $daySchedule->is_working)
                                                    {{ $daySchedule->start_time }} - {{ $daySchedule->end_time }}
                                                @else
                                                    <span class="text-gray-500">Fermé</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Aucun horaire défini.</p>
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                                <i class="fas fa-plus fa-sm"></i> Définir les horaires
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Appointments Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Rendez-vous à venir</h6>
                    <div>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                            <i class="fas fa-plus fa-sm"></i> Nouveau rendez-vous
                        </button>
                        <a href="" class="btn btn-info btn-sm ml-2">
                            <i class="fas fa-calendar fa-sm"></i> Voir tout
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($upcomingAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th>Patient</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->date->format('d/m/Y') }}</td>
                                        <td>{{ $appointment->time }}</td>
                                        <td>
                                            <div class="patient-profile">
                                                <img src="{{ $appointment->patient->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($appointment->patient->user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                                     alt="Patient" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                                                <span>{{ $appointment->patient->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($appointment->status == 'confirmed')
                                                <span class="badge badge-success">Confirmé</span>
                                            @elseif($appointment->status == 'pending')
                                                <span class="badge badge-warning">En attente</span>
                                            @elseif($appointment->status == 'canceled')
                                                <span class="badge badge-danger">Annulé</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-menu">
                                                <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($appointment->status == 'pending')
                                                    <button class="btn btn-success btn-sm" onclick="confirmAppointment({{ $appointment->id }})">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="cancelAppointment({{ $appointment->id }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-check fa-4x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Aucun rendez-vous à venir pour ce médecin.</p>
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                                <i class="fas fa-plus fa-sm"></i> Programmer un rendez-vous
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Performance Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performance</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Rendez-vous ce mois</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyAppointmentsCount }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Taux de complétion</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($completionRate, 1) }}%</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Revenus générés</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalRevenue, 2) }} Dh</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Évaluation moyenne</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <div class="text-warning">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($averageRating))
                                                            <i class="fas fa-star"></i>
                                                        @elseif($i - 0.5 <= $averageRating)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                    ({{ number_format($averageRating, 1) }})
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-star fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="chart-container mt-4">
                        <canvas id="appointmentsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAppointmentModalLabel">Nouveau Rendez-vous</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.appointments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Patient</label>
                        <select class="form-control" id="patient_id" name="patient_id" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Heure</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                        <div id="availability_message" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Motif</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix (Dh)</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="300.00" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Schedule Modal -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Modifier les horaires</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.doctors.update-schedule', $doctor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $index => $day)
                            @php
                                $daySchedule = $doctor->schedules->where('day', $index + 1)->first();
                                $isWorking = $daySchedule ? $daySchedule->is_working : false;
                                $startTime = $daySchedule ? $daySchedule->start_time : '09:00';
                                $endTime = $daySchedule ? $daySchedule->end_time : '17:00';
                            @endphp
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input day-checkbox" type="checkbox" value="1" 
                                                   id="is_working_{{ $index + 1 }}" name="days[{{ $index + 1 }}][is_working]" 
                                                   {{ $isWorking ? 'checked' : '' }}
                                                   data-day="{{ $index + 1 }}">
                                            <label class="form-check-label font-weight-bold" for="is_working_{{ $index + 1 }}">
                                                {{ $day }}
                                            </label>
                                        </div>
                                        <div class="row day-hours" id="day-hours-{{ $index + 1 }}" {{ !$isWorking ? 'style="display: none;"' : '' }}>
                                            <div class="col">
                                                <label>Début</label>
                                                <input type="time" class="form-control" name="days[{{ $index + 1 }}][start_time]" value="{{ $startTime }}">
                                            </div>
                                            <div class="col">
                                                <label>Fin</label>
                                                <input type="time" class="form-control" name="days[{{ $index + 1 }}][end_time]" value="{{ $endTime }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Doctor Modal -->
<div class="modal fade" id="deleteDoctorModal" tabindex="-1" aria-labelledby="deleteDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDoctorModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce médecin ? Cette action est irréversible et supprimera également tous les rendez-vous associés.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle schedule day hours
        const dayCheckboxes = document.querySelectorAll('.day-checkbox');
        dayCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const dayId = this.getAttribute('data-day');
                const hoursDiv = document.getElementById(`day-hours-${dayId}`);
                if (this.checked) {
                    hoursDiv.style.display = 'flex';
                } else {
                    hoursDiv.style.display = 'none';
                }
            });
        });

        // Availability toggle
        const availabilityToggle = document.querySelector('.toggle-availability');
        if (availabilityToggle) {
            availabilityToggle.addEventListener('click', function() {
                const doctorId = this.getAttribute('data-doctor-id');
                const currentStatus = this.getAttribute('data-status');
                const newStatus = currentStatus === 'available' ? 'unavailable' : 'available';
                
                // Show confirmation dialog
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
                        // Submit form to update availability
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('admin.doctors.toggle-availability', '') }}/${doctorId}`;
                        form.style.display = 'none';
                        
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
            });
        }

        // Check doctor availability
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        
        function checkAvailability() {
            const date = dateInput.value;
            const time = timeInput.value;
            const doctorId = "{{ $doctor->id }}";
            const messageDiv = document.getElementById('availability_message');
            
            if (date && time) {
                messageDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Vérification de la disponibilité...';
                messageDiv.className = 'text-info mt-2';
                
                // Send AJAX request to check availability
                fetch(`{{ route('admin.check-doctor-availability') }}?doctor_id=${doctorId}&date=${date}&time=${time}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.available) {
                            messageDiv.innerHTML = '<i class="fas fa-check-circle"></i> Ce créneau est disponible!';
                            messageDiv.className = 'text-success mt-2';
                        } else {
                            messageDiv.innerHTML = '<i class="fas fa-times-circle"></i> Ce créneau n\'est pas disponible. Veuillez choisir un autre horaire.';
                            messageDiv.className = 'text-danger mt-2';
                        }
                    })
                    .catch(error => {
                        console.error('Error checking availability:', error);
                        messageDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Erreur lors de la vérification. Veuillez réessayer.';
                        messageDiv.className = 'text-danger mt-2';
                    });
            }
        }
        
        if (dateInput && timeInput) {
            dateInput.addEventListener('change', checkAvailability);
            timeInput.addEventListener('change', checkAvailability);
        }

        // Appointments chart
        const ctx = document.getElementById('appointmentsChart').getContext('2d');
        const appointmentsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($appointmentChartLabels),
                datasets: [{
                    label: 'Rendez-vous',
                    data: @json($appointmentChartData),
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Rendez-vous des 3 derniers mois',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    });
    
    // Function to confirm appointment
    function confirmAppointment(id) {
        Swal.fire({
            title: 'Confirmer ce rendez-vous?',
            text: "Une notification sera envoyée au patient.",
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
                form.action = `{{ url('admin/appointments') }}/${id}/confirm`;
                
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
    }
    
    // Function to cancel appointment
    function cancelAppointment(id) {
        Swal.fire({
            title: 'Annuler ce rendez-vous?',
            text: "Une notification sera envoyée au patient et ce créneau horaire sera libéré.",
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
                form.action = `{{ url('admin/appointments') }}/${id}/cancel`;
                
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
    }
</script>
@endsection
