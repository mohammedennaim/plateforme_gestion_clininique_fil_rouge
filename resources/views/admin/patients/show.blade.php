@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails du Patient</h1>
        <a href="{{ route('admin.patients.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;"
                            src="{{ $patient->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($patient->user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                            alt="Photo de profil">
                        <h5 class="font-weight-bold">{{ $patient->user->name }}</h5>
                        <div class="text-gray-500">Patient ID: {{ $patient->id }}</div>
                        <div class="mt-3 d-flex justify-content-center">
                            <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-primary btn-sm mr-2">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePatientModal">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                    <div class="patient-info">
                        <h6 class="font-weight-bold">Informations personnelles</h6>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-envelope mr-2 text-gray-500"></i> <strong>Email:</strong></p>
                            <p>{{ $patient->user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-phone mr-2 text-gray-500"></i> <strong>Téléphone:</strong></p>
                            <p>{{ $patient->user->phone ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-map-marker-alt mr-2 text-gray-500"></i> <strong>Adresse:</strong></p>
                            <p>{{ $patient->address ?? 'Non renseignée' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-tint mr-2 text-danger"></i> <strong>Groupe sanguin:</strong></p>
                            <p>{{ $patient->blood_type ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-shield-alt mr-2 text-gray-500"></i> <strong>Assurance:</strong></p>
                            <p>{{ $patient->name_assurance ?? 'Non renseignée' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-id-card mr-2 text-gray-500"></i> <strong>Numéro d'assurance:</strong></p>
                            <p>{{ $patient->assurance_number ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Appointments Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Historique des Rendez-vous</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                        <i class="fas fa-plus fa-sm"></i> Nouveau rendez-vous
                    </button>
                </div>
                <div class="card-body">
                    @if($patient->appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Médecin</th>
                                        <th>Spécialité</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patient->appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->date->format('d/m/Y') }} à {{ $appointment->time }}</td>
                                        <td>Dr. {{ $appointment->doctor->user->name }}</td>
                                        <td>{{ $appointment->doctor->speciality }}</td>
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
                            <i class="fas fa-calendar-times fa-4x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Aucun rendez-vous trouvé pour ce patient.</p>
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                                <i class="fas fa-plus fa-sm"></i> Programmer un rendez-vous
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Medical Records Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Dossier Médical</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addMedicalRecordModal">
                        <i class="fas fa-plus fa-sm"></i> Ajouter
                    </button>
                </div>
                <div class="card-body">
                    @if($patient->medicalRecords && $patient->medicalRecords->count() > 0)
                        <div class="timeline">
                            @foreach($patient->medicalRecords->sortByDesc('created_at') as $record)
                                <div class="timeline-item">
                                    <div class="timeline-icon bg-primary">
                                        <i class="fas fa-file-medical text-white"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="font-weight-bold">{{ $record->title }}</h6>
                                            <span class="text-gray-500">{{ $record->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <p>{{ $record->description }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.medical-records.show', $record->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-medical-alt fa-4x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Aucun dossier médical trouvé pour ce patient.</p>
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addMedicalRecordModal">
                                <i class="fas fa-plus fa-sm"></i> Créer un dossier médical
                            </button>
                        </div>
                    @endif
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
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Médecin</label>
                        <select class="form-control" id="doctor_id" name="doctor_id" required>
                            <option value="">Sélectionner un médecin</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} ({{ $doctor->speciality }})</option>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Patient Modal -->
<div class="modal fade" id="deletePatientModal" tabindex="-1" aria-labelledby="deletePatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePatientModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce patient ? Cette action est irréversible et supprimera également tous les rendez-vous associés.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Medical Record Modal -->
<div class="modal fade" id="addMedicalRecordModal" tabindex="-1" aria-labelledby="addMedicalRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMedicalRecordModalLabel">Ajouter un dossier médical</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.medical-records.store') }}" method="POST">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="diagnostics" class="form-label">Diagnostic</label>
                        <textarea class="form-control" id="diagnostics" name="diagnostics" rows="3"></textarea>
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

<style>
    .timeline {
        position: relative;
        padding: 1rem 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 1.5rem;
        height: 100%;
        width: 2px;
        background: #e3e6f0;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
        margin-left: 3.5rem;
    }
    
    .timeline-icon {
        position: absolute;
        left: -3.5rem;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        text-align: center;
        line-height: 2.5rem;
    }
    
    .timeline-content {
        background: white;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endsection
