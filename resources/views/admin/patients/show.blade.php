@extends('layouts.admin')

@section('title', 'Détails du Patient')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails du Patient</h1>
        <div>
            <a href="" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Retour
            </a>
            <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-sm btn-primary shadow-sm ml-2">
                <i class="fas fa-edit fa-sm text-white-50 mr-1"></i> Modifier
            </a>
            <button type="button" class="btn btn-sm btn-danger shadow-sm ml-2" data-bs-toggle="modal" data-bs-target="#deletePatientModal">
                <i class="fas fa-trash fa-sm text-white-50 mr-1"></i> Supprimer
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Patient Information Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Informations personnelles</h6>
                    <span class="badge {{ $patient->user->active ? 'badge-success' : 'badge-danger' }}">
                        {{ $patient->user->active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle mb-3" src="{{ $patient->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($patient->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $patient->user->name }}" style="width: 120px; height: 120px; border: 4px solid #eaecf4;">
                        <h5 class="font-weight-bold text-gray-800">{{ $patient->user->name }}</h5>
                        <p class="text-gray-600">{{ $patient->blood_type ? 'Groupe sanguin: ' . $patient->blood_type : '' }}</p>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Date de naissance</div>
                        <div class="col-6 text-gray-800">{{ $patient->birth_date ? $patient->birth_date->format('d/m/Y') : 'Non renseigné' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Âge</div>
                        <div class="col-6 text-gray-800">{{ $patient->birth_date ? $patient->birth_date->age . ' ans' : 'Non renseigné' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Sexe</div>
                        <div class="col-6 text-gray-800">{{ $patient->gender ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Email</div>
                        <div class="col-6 text-gray-800">{{ $patient->user->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Téléphone</div>
                        <div class="col-6 text-gray-800">{{ $patient->user->phone ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Adresse</div>
                        <div class="col-6 text-gray-800">{{ $patient->address ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Dernière visite</div>
                        <div class="col-6 text-gray-800">{{ $patient->derniere_visite ? $patient->derniere_visite->format('d/m/Y') : 'Jamais' }}</div>
                    </div>
                </div>
            </div>

            <!-- Insurance Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations d'assurance</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Compagnie</div>
                        <div class="col-6 text-gray-800">{{ $patient->name_assurance ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-gray-600">Numéro</div>
                        <div class="col-6 text-gray-800">{{ $patient->assurance_number ?? 'Non renseigné' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <!-- Patient History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historique médical</h6>
                </div>
                <div class="card-body">
                    @if($patient->medicalRecords && $patient->medicalRecords->count() > 0)
                        <div class="timeline-body">
                            @foreach($patient->medicalRecords->sortByDesc('date') as $record)
                                <div class="timeline-item pb-4 mb-4 border-bottom">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="font-weight-bold text-primary">{{ $record->title }}</h6>
                                        <span class="text-gray-500">{{ $record->date->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="mb-2">{{ $record->description }}</p>
                                    <p class="mb-1 text-gray-600"><strong>Médecin:</strong> Dr. {{ $record->doctor->user->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-notes-medical fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Aucun dossier médical disponible</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Appointments History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Historique des rendez-vous</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                        <i class="fas fa-plus fa-sm"></i> Nouveau rendez-vous
                    </button>
                </div>
                <div class="card-body">
                    @if($patient->appointments && $patient->appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Médecin</th>
                                        <th>Motif</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patient->appointments->sortByDesc('date') as $appointment)
                                        <tr>
                                            <td>
                                                {{ $appointment->date->format('d/m/Y') }}<br>
                                                <span class="text-primary">{{ $appointment->time }}</span>
                                            </td>
                                            <td>Dr. {{ $appointment->doctor->user->name }}</td>
                                            <td>{{ $appointment->reason }}</td>
                                            <td>
                                                @if($appointment->status == 'confirmed')
                                                    <span class="badge badge-success">Confirmé</span>
                                                @elseif($appointment->status == 'pending')
                                                    <span class="badge badge-warning">En attente</span>
                                                @elseif($appointment->status == 'canceled')
                                                    <span class="badge badge-danger">Annulé</span>
                                                @elseif($appointment->status == 'completed')
                                                    <span class="badge badge-info">Terminé</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-menu">
                                                    <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Aucun rendez-vous enregistré</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Patient Modal -->
<div class="modal fade" id="deletePatientModal" tabindex="-1" role="dialog" aria-labelledby="deletePatientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePatientModalLabel">Supprimer ce patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.patients.delete', $patient->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce patient? Cette action est irréversible et supprimera également tous les rendez-vous associés.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAppointmentModalLabel">Nouveau rendez-vous</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    
                    <div class="mb-3">
                        <label for="doctor_id">Médecin</label>
                        <select class="form-control" id="doctor_id" name="doctor_id" required>
                            <option value="">Sélectionner un médecin</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} ({{ $doctor->speciality }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="time">Heure</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason">Motif de consultation</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status">Statut</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">En attente</option>
                            <option value="confirmed">Confirmé</option>
                        </select>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Vérification de la disponibilité du médecin lors de la prise de rendez-vous
        const doctorId = document.getElementById('doctor_id');
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        
        // Fonction pour vérifier la disponibilité
        function checkDoctorAvailability() {
            if (doctorId.value && dateInput.value && timeInput.value) {
                // Ici, vous pourriez faire une requête AJAX pour vérifier la disponibilité
                // Pour l'exemple, nous allons simplement simuler une vérification
                
                // Créer un élément pour le message d'information s'il n'existe pas déjà
                let infoMessage = document.getElementById('availability_message');
                if (!infoMessage) {
                    infoMessage = document.createElement('div');
                    infoMessage.id = 'availability_message';
                    timeInput.parentNode.appendChild(infoMessage);
                }
                
                infoMessage.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Vérification de la disponibilité...';
                infoMessage.className = 'text-info mt-2';
                
                // Simulation d'une vérification asynchrone
                setTimeout(() => {
                    // Dans un cas réel, vous récupéreriez cette information du serveur
                    const isAvailable = Math.random() > 0.3; // 70% de chance d'être disponible
                    
                    if (isAvailable) {
                        infoMessage.innerHTML = '<i class="fas fa-check-circle"></i> Ce créneau est disponible!';
                        infoMessage.className = 'text-success mt-2';
                    } else {
                        infoMessage.innerHTML = '<i class="fas fa-times-circle"></i> Ce médecin n\'est pas disponible à cette date/heure. Veuillez choisir un autre moment.';
                        infoMessage.className = 'text-danger mt-2';
                    }
                }, 1000);
            }
        }
        
        // Ajouter des écouteurs d'événements pour déclencher la vérification
        if (doctorId && dateInput && timeInput) {
            doctorId.addEventListener('change', checkDoctorAvailability);
            dateInput.addEventListener('change', checkDoctorAvailability);
            timeInput.addEventListener('change', checkDoctorAvailability);
        }
    });
</script>
@endsection