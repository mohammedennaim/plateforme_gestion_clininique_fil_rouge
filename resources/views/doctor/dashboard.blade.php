@extends('layouts.doctor')
@section('title', 'Tableau de Bord Médecin')
@section('styles')
    <style>
        /* Styles généraux */
        .text-primary-custom {
            color: #4e73df;
        }

        .text-success-custom {
            color: #1cc88a;
        }

        .text-warning-custom {
            color: #f6c23e;
        }

        .text-danger-custom {
            color: #e74a3b;
        }

        .text-info-custom {
            color: #36b9cc;
        }

        /* Cards des rendez-vous */
        .appointment-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 4px solid transparent;
        }

        .appointment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .appointment-pending {
            border-left-color: #f6c23e;
        }

        .appointment-confirmed {
            border-left-color: #1cc88a;
        }

        .appointment-cancelled {
            border-left-color: #e74a3b;
        }

        .appointment-completed {
            border-left-color: #4e73df;
        }

        /* Badges de statut */
        .status-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10rem;
        }

        /* Chat et messages */
        .chat-container {
            height: 450px;
            display: flex;
            flex-direction: column;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            background: #f8f9fc;
            border-radius: 0.35rem;
        }

        .chat-message {
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            max-width: 80%;
            position: relative;
        }

        .chat-message.outgoing {
            background-color: #4e73df;
            color: white;
            align-self: flex-end;
            margin-left: auto;
        }

        .chat-message.incoming {
            background-color: #e9ecef;
            color: #3a3b45;
            align-self: flex-start;
        }

        /* Badges de notification */
        .nav-notification-badge {
            position: absolute;
            top: 0.25rem;
            right: 0.75rem;
            font-size: 0.7rem;
        }

        /* Avatar et photos de profil */
        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Cards statistiques */
        .stat-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-patients {
            border-left-color: #4e73df;
        }

        .stat-appointments {
            border-left-color: #1cc88a;
        }

        .stat-pending {
            border-left-color: #f6c23e;
        }

        .stat-revenue {
            border-left-color: #36b9cc;
        }

        /* Calendrier */
        .calendar-day {
            height: 100px;
            transition: background-color 0.2s;
        }

        .calendar-day:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .calendar-event {
            border-radius: 0.25rem;
            padding: 0.25rem;
            margin-bottom: 0.25rem;
            font-size: 0.8rem;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .calendar-event:hover {
            transform: scale(1.02);
        }

        .calendar-event-primary {
            background-color: rgba(78, 115, 223, 0.15);
            border-left: 3px solid #4e73df;
        }

        .calendar-event-success {
            background-color: rgba(28, 200, 138, 0.15);
            border-left: 3px solid #1cc88a;
        }

        .calendar-event-warning {
            background-color: rgba(246, 194, 62, 0.15);
            border-left: 3px solid #f6c23e;
        }

        /* Statistiques et graphiques */
        .stats-container {
            height: 300px;
        }

        /* Liste des patients */
        .patient-list-item {
            transition: background-color 0.2s;
            border-left: 3px solid transparent;
        }

        .patient-list-item:hover {
            background-color: rgba(78, 115, 223, 0.05);
            border-left-color: #4e73df;
        }

        /* Prescription numérique */
        .prescription-form label {
            font-weight: 600;
            color: #4e73df;
        }

        .medicine-item {
            background-color: #f8f9fc;
            border-radius: 0.35rem;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
            border-left: 3px solid #4e73df;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <!-- En-tête de la page -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Tableau de Bord Médecin</h1>
                <p class="text-muted">Bienvenue, Dr. Martin. Vous avez <span class="font-weight-bold text-primary">8</span>
                    rendez-vous aujourd'hui.</p>
            </div>
            <div class="d-flex">
                <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm mr-2"
                    data-toggle="modal" data-target="#availabilityModal">
                    <i class="fas fa-calendar fa-sm text-primary-50"></i> Disponibilités
                </button>
                <div class="dropdown mr-2">
                    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dropdown-toggle" type="button"
                        id="reportsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-download fa-sm text-white-50"></i> Rapports
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="reportsDropdown">
                        <a class="dropdown-item" href="#"><i class="fas fa-file-pdf fa-sm fa-fw mr-2 text-danger"></i>
                            Rapport mensuel</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-file-medical fa-sm fa-fw mr-2 text-primary"></i>
                            Statistiques patients</a>
                        <a class="dropdown-item" href="#"><i
                                class="fas fa-file-invoice-dollar fa-sm fa-fw mr-2 text-success"></i> Rapport financier</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-500"></i>
                            Paramètres des rapports</a>
                    </div>
                </div>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                    data-target="#newAppointmentModal">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Nouveau Rendez-vous
                </a>
            </div>
        </div>

        <!-- Cartes statistiques -->
        <div class="row">
            <!-- Patients totaux -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100 py-2 stat-card stat-patients">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Patients Totaux</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPatients ?? 124 }}</div>
                                <div class="small text-success mt-2">
                                    <i class="fas fa-arrow-up fa-sm"></i> +5% ce mois
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rendez-vous du jour -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100 py-2 stat-card stat-appointments">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Rendez-vous Aujourd'hui</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayAppointments ?? 8 }}</div>
                                <div class="small text-muted mt-2">
                                    Prochain dans <span class="text-primary">25 min</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demandes en attente -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100 py-2 stat-card stat-pending">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Demandes en Attente</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingRequests ?? 12 }}</div>
                                <div class="small text-danger mt-2">
                                    <i class="fas fa-exclamation-circle fa-sm"></i> 3 urgentes
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenu mensuel -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100 py-2 stat-card stat-revenue">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Revenu Mensuel
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $monthlyRevenue ?? '4 250 €' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 75%"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="small text-success mt-2">
                                    <i class="fas fa-arrow-up fa-sm"></i> +8% vs dernier mois
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ligne de contenu principale -->
        <div class="row">
            <!-- Rendez-vous à venir -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Rendez-vous à Venir</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Filtrer par:</div>
                                <a class="dropdown-item" href="#">Aujourd'hui</a>
                                <a class="dropdown-item" href="#">Cette Semaine</a>
                                <a class="dropdown-item" href="#">Ce Mois</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Tous</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            // Données de rendez-vous d'exemple (à remplacer par les données réelles)
                            $appointments = [
                                [
                                    'id' => 1,
                                    'patient_name' => 'Marie Dupont',
                                    'patient_avatar' => 'https://randomuser.me/api/portraits/women/45.jpg',
                                    'date' => '2025-04-02',
                                    'time' => '09:30:00',
                                    'reason' => 'Bilan annuel',
                                    'status' => 'confirmed',
                                    'notes' => 'Antécédents de diabète type 2'
                                ],
                                [
                                    'id' => 2,
                                    'patient_name' => 'Jean Lefebvre',
                                    'patient_avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
                                    'date' => '2025-04-02',
                                    'time' => '11:00:00',
                                    'reason' => 'Suivi post-opératoire',
                                    'status' => 'pending',
                                    'notes' => 'Opération genou droit il y a 2 semaines'
                                ],
                                [
                                    'id' => 3,
                                    'patient_name' => 'Émilie Moreau',
                                    'patient_avatar' => 'https://randomuser.me/api/portraits/women/22.jpg',
                                    'date' => '2025-04-03',
                                    'time' => '14:15:00',
                                    'reason' => 'Révision traitement',
                                    'status' => 'confirmed',
                                    'notes' => 'Hypertension artérielle'
                                ],
                                [
                                    'id' => 4,
                                    'patient_name' => 'Michel Bernard',
                                    'patient_avatar' => 'https://randomuser.me/api/portraits/men/34.jpg',
                                    'date' => '2025-04-03',
                                    'time' => '16:45:00',
                                    'reason' => 'Douleurs thoraciques',
                                    'status' => 'confirmed',
                                    'notes' => 'Urgence relative - Antécédents cardiaques'
                                ],
                            ];
                        @endphp

                        <!-- Barre de filtres et recherche -->
                        <div class="mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary active">Tous</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary">Aujourd'hui</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary">Demain</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" placeholder="Rechercher un patient...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @forelse($appointments as $appointment)
                            <div class="card mb-3 shadow-sm appointment-card appointment-{{ $appointment['status'] }}">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <img src="{{ $appointment['patient_avatar'] }}" class="avatar"
                                                alt="{{ $appointment['patient_name'] }}">
                                        </div>
                                        <div class="col">
                                            <h6 class="mb-0 font-weight-bold">{{ $appointment['patient_name'] }}</h6>
                                            <div class="small text-muted">
                                                {{ \Carbon\Carbon::parse($appointment['date'])->locale('fr')->format('D j M Y') }}
                                                à
                                                {{ \Carbon\Carbon::parse($appointment['time'])->format('H:i') }}
                                            </div>
                                            <div class="small mt-1">
                                                <span class="font-weight-bold">Motif:</span> {{ $appointment['reason'] }}
                                                @if(isset($appointment['notes']))
                                                    <span class="text-danger ml-2" data-toggle="tooltip"
                                                        title="{{ $appointment['notes'] }}">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-md-right mt-2 mt-md-0">
                                            @if($appointment['status'] == 'pending')
                                                <span class="badge badge-warning status-badge">En Attente</span>
                                            @elseif($appointment['status'] == 'confirmed')
                                                <span class="badge badge-success status-badge">Confirmé</span>
                                            @elseif($appointment['status'] == 'cancelled')
                                                <span class="badge badge-danger status-badge">Annulé</span>
                                            @elseif($appointment['status'] == 'completed')
                                                <span class="badge badge-primary status-badge">Terminé</span>
                                            @endif
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn btn-sm" type="button" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if($appointment['status'] == 'pending')
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-check-circle text-success fa-sm mr-2"></i> Confirmer
                                                        </a>
                                                    @endif
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#medicalRecordModal">
                                                        <i class="fas fa-file-medical text-primary fa-sm mr-2"></i> Dossier
                                                        Médical
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#chatModal">
                                                        <i class="fas fa-comments text-info fa-sm mr-2"></i> Envoyer Message
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#prescriptionModal">
                                                        <i class="fas fa-prescription fa-sm mr-2 text-success"></i> Nouvelle
                                                        Ordonnance
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    @if($appointment['status'] != 'cancelled' && $appointment['status'] != 'completed')
                                                        <a class="dropdown-item text-danger" href="#">
                                                            <i class="fas fa-times-circle fa-sm mr-2"></i> Annuler
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <img src="{{ asset('images/empty-calendar.svg') }}" alt="Aucun Rendez-vous"
                                    style="width: 120px; opacity: 0.5;">
                                <p class="mt-3 text-muted">Aucun rendez-vous à venir</p>
                                <a href="#" class="btn btn-sm btn-primary">Voir Calendrier</a>
                            </div>
                        @endforelse

                        @if(count($appointments) > 0)
                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-sm btn-outline-primary">Voir Tous les Rendez-vous</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Analyse des tendances - NOUVEAU BLOC -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Analyse des Tendances</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Ce Mois</a>
                                <a class="dropdown-item" href="#">Ce Trimestre</a>
                                <a class="dropdown-item" href="#">Cette Année</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="stats-container mb-4">
                            <canvas id="appointmentsTrend"></canvas>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Répartition par Type de Consultation</h6>
                                <div class="stats-container mt-2" style="height: 200px;">
                                    <canvas id="consultationTypes"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Satisfaction Patients</h6>
                                <div class="stats-container mt-2" style="height: 200px;">
                                    <canvas id="patientSatisfaction"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite -->
            <div class="col-lg-4 mb-4">
                <!-- Zone de messagerie -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Messages Patients</h6>
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#chatModal">
                            <i class="fas fa-comments fa-sm"></i> Ouvrir Discussion
                        </a>
                    </div>
                    <div class="card-body chat-container">
                        <div class="nav nav-tabs mb-3" id="chat-tabs" role="tablist">
                            <a class="nav-link active" id="chat-all-tab" data-toggle="tab" href="#chat-all" role="tab"
                                aria-selected="true">
                                Tous <span class="badge badge-danger ml-1">3</span>
                            </a>
                            <a class="nav-link" id="chat-unread-tab" data-toggle="tab" href="#chat-unread" role="tab"
                                aria-selected="false">
                                Non lus <span class="badge badge-danger ml-1">2</span>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="chat-all">
                                <div class="chat-messages">
                                    @php
                                        // Messages de chat d'exemple
                                        $chatMessages = [
                                            [
                                                'patient' => [
                                                    'name' => 'Marie Dupont',
                                                    'avatar' => 'https://randomuser.me/api/portraits/women/45.jpg',
                                                ],
                                                'unread' => true,
                                                'messages' => [
                                                    [
                                                        'type' => 'incoming',
                                                        'text' => 'Bonjour Dr. Martin, j\'ai des maux de tête sévères depuis deux jours. Devrais-je m\'inquiéter?',
                                                        'time' => '09:45'
                                                    ],
                                                    [
                                                        'type' => 'outgoing',
                                                        'text' => 'Bonjour Marie, ressentez-vous d\'autres symptômes comme des nausées ou une sensibilité à la lumière?',
                                                        'time' => '09:48'
                                                    ],
                                                    [
                                                        'type' => 'incoming',
                                                        'text' => 'Oui, je me sens un peu nauséeuse, surtout le matin.',
                                                        'time' => '09:52'
                                                    ],
                                                ]
                                            ],
                                            [
                                                'patient' => [
                                                    'name' => 'Jean Lefebvre',
                                                    'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
                                                ],
                                                'unread' => true,
                                                'messages' => [
                                                    [
                                                        'type' => 'incoming',
                                                        'text' => 'Dr. Martin, je voulais vous demander si je dois continuer le traitement que vous m\'avez prescrit la dernière fois?',
                                                        'time' => 'Hier'
                                                    ],
                                                ]
                                            ],
                                        ];
                                    @endphp

                                    @foreach($chatMessages as $conversation)
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ $conversation['patient']['avatar'] }}" class="avatar mr-3"
                                                alt="{{ $conversation['patient']['name'] }}">
                                            <div>
                                                <h6 class="mb-0 font-weight-bold">
                                                    {{ $conversation['patient']['name'] }}
                                                    @if(isset($conversation['unread']) && $conversation['unread'])
                                                        <span class="badge badge-danger ml-2">Nouveau</span>
                                                    @endif
                                                </h6>
                                                <div class="small text-muted">{{ count($conversation['messages']) }} messages
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ml-auto" data-toggle="modal"
                                                data-target="#chatModal">Voir</a>
                                        </div>

                                        @foreach($conversation['messages'] as $index => $message)
                                            @if($index < 2)
                                                <div class="chat-message {{ $message['type'] }} mb-3">
                                                    <div class="mb-1">
                                                        @if($message['type'] == 'incoming')
                                                            <span
                                                                class="small font-weight-bold">{{ $conversation['patient']['name'] }}</span>
                                                        @else
                                                            <span class="small font-weight-bold">Vous</span>
                                                        @endif
                                                        <span class="small text-muted ml-2">{{ $message['time'] }}</span>
                                                    </div>
                                                    {{ $message['text'] }}
                                                </div>
                                            @endif
                                        @endforeach

                                        @if(count($conversation['messages']) > 2)
                                            <div class="text-center mb-4">
                                                <a href="#" class="small">Voir conversation complète</a>
                                            </div>
                                        @endif

                                        @if(!$loop->last)
                                            <hr class="my-3">
                                        @endif
                                    @endforeach

                                    <div class="text-center mt-3">
                                        <a href="#" class="btn btn-sm btn-outline-primary">Voir Tous les Messages</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="chat-unread">
                                <div class="chat-messages">
                                    @foreach($chatMessages as $conversation)
                                        @if(isset($conversation['unread']) && $conversation['unread'])
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ $conversation['patient']['avatar'] }}" class="avatar mr-3"
                                                    alt="{{ $conversation['patient']['name'] }}">
                                                <div>
                                                    <h6 class="mb-0 font-weight-bold">
                                                        {{ $conversation['patient']['name'] }}
                                                        <span class="badge badge-danger ml-2">Nouveau</span>
                                                    </h6>
                                                    <div class="small text-muted">{{ count($conversation['messages']) }} messages
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-sm btn-outline-primary ml-auto" data-toggle="modal"
                                                    data-target="#chatModal">Voir</a>
                                            </div>

                                            <!-- Affichage du dernier message non lu -->
                                            <div class="chat-message {{ end($conversation['messages'])['type'] }} mb-3">
                                                <div class="mb-1">
                                                    @if(end($conversation['messages'])['type'] == 'incoming')
                                                        <span
                                                            class="small font-weight-bold">{{ $conversation['patient']['name'] }}</span>
                                                    @else
                                                        <span class="small font-weight-bold">Vous</span>
                                                    @endif
                                                    <span
                                                        class="small text-muted ml-2">{{ end($conversation['messages'])['time'] }}</span>
                                                </div>
                                                {{ end($conversation['messages'])['text'] }}
                                            </div>

                                            @if(!$loop->last)
                                                <hr class="my-3">
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Rechercher dans les messages...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prochains Rendez-vous -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Prochain Rendez-vous</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $nextAppointment = $appointments[0] ?? null;
                        @endphp

                        @if($nextAppointment)
                            <div class="text-center mb-3">
                                <img src="{{ $nextAppointment['patient_avatar'] }}" class="avatar"
                                    alt="{{ $nextAppointment['patient_name'] }}" style="width: 80px; height: 80px;">
                                <h5 class="mt-2 mb-0 font-weight-bold">{{ $nextAppointment['patient_name'] }}</h5>
                                <div class="text-muted">Patient #{{ 1000 + $nextAppointment['id'] }}</div>
                            </div>

                            <div class="row text-center">
                                <div class="col-6 border-right">
                                    <div class="font-weight-bold text-primary">Date</div>
                                    <div class="h5 mb-0">{{ \Carbon\Carbon::parse($nextAppointment['date'])->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="font-weight-bold text-primary">Heure</div>
                                    <div class="h5 mb-0">{{ \Carbon\Carbon::parse($nextAppointment['time'])->format('H:i') }}
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="small">
                                <div class="font-weight-bold mb-1">Motif de consultation</div>
                                <p>{{ $nextAppointment['reason'] }}</p>

                                @if(isset($nextAppointment['notes']))
                                    <div class="font-weight-bold mb-1">Notes</div>
                                    <p class="text-danger">{{ $nextAppointment['notes'] }}</p>
                                @endif
                            </div>

                            <div class="mt-3 d-flex justify-content-between">
                                <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                    data-target="#medicalRecordModal">
                                    <i class="fas fa-file-medical mr-1"></i> Dossier
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-success" data-toggle="modal"
                                    data-target="#prescriptionModal">
                                    <i class="fas fa-prescription mr-1"></i> Ordonnance
                                </a>
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#appointmentDetailsModal">
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </a>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-check fa-4x text-light mb-3"></i>
                                <p class="text-muted">Aucun rendez-vous programmé</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Notifications -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Notifications</h6>
                        <a href="#" class="btn btn-sm btn-outline-primary">Tout marquer comme lu</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 font-weight-bold">Nouveau rendez-vous</h6>
                                    <small class="text-danger">Il y a 15 min</small>
                                </div>
                                <p class="mb-1">Marie Dupont a demandé un rendez-vous pour demain à 14h30.</p>
                                <small class="text-primary">Cliquez pour confirmer</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 font-weight-bold">Message de patient</h6>
                                    <small class="text-muted">Hier</small>
                                </div>
                                <p class="mb-1">Jean Lefebvre a une question sur son traitement.</p>
                                <small class="text-primary">Voir le message</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 font-weight-bold">Résultats d'analyses</h6>
                                    <small class="text-muted">Il y a 2 jours</small>
                                </div>
                                <p class="mb-1">Résultats d'analyses disponibles pour Émilie Moreau.</p>
                                <small class="text-primary">Consulter les résultats</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 font-weight-bold">Rappel de conférence</h6>
                                    <small class="text-muted">Il y a 3 jours</small>
                                </div>
                                <p class="mb-1">Conférence sur les avancées en cardiologie le 15 avril.</p>
                                <small class="text-primary">Voir les détails</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendrier hebdomadaire -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Calendrier Hebdomadaire</h6>
                <div>
                    <button class="btn btn-sm btn-outline-primary mr-2">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="font-weight-bold">02 - 08 Avril 2025</span>
                    <button class="btn btn-sm btn-outline-primary ml-2">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%">Heure</th>
                                <th style="width: 15%">Lundi 02/04</th>
                                <th style="width: 15%">Mardi 03/04</th>
                                <th style="width: 15%">Mercredi 04/04</th>
                                <th style="width: 15%">Jeudi 05/04</th>
                                <th style="width: 15%">Vendredi 06/04</th>
                                <th style="width: 15%">Samedi 07/04</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'] as $hour)
                                <tr>
                                    <td class="font-weight-bold text-primary">{{ $hour }}</td>
                                    @foreach([1, 2, 3, 4, 5, 6] as $day)
                                        <td class="calendar-day">
                                            @if($day == 1 && $hour == '09:30')
                                                <div class="calendar-event calendar-event-primary">
                                                    <div class="small font-weight-bold">Marie Dupont</div>
                                                    <div class="small">Bilan annuel</div>
                                                </div>
                                            @endif
                                            @if($day == 1 && $hour == '11:00')
                                                <div class="calendar-event calendar-event-warning">
                                                    <div class="small font-weight-bold">Jean Lefebvre</div>
                                                    <div class="small">Suivi post-opératoire</div>
                                                </div>
                                            @endif
                                            @if($day == 2 && $hour == '14:00')
                                                <div class="calendar-event calendar-event-primary">
                                                    <div class="small font-weight-bold">Émilie Moreau</div>
                                                    <div class="small">Révision traitement</div>
                                                </div>
                                            @endif
                                            @if($day == 2 && $hour == '16:00')
                                                <div class="calendar-event calendar-event-success">
                                                    <div class="small font-weight-bold">Michel Bernard</div>
                                                    <div class="small">Douleurs thoraciques</div>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modals -->

        <!-- Modal Chat -->
        <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <img src="https://randomuser.me/api/portraits/women/45.jpg" class="avatar mr-2"
                                alt="Marie Dupont">
                            Discussion avec Marie Dupont
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="chat-messages p-3" style="height: 350px; overflow-y: auto;">
                            <div class="chat-message incoming">
                                <div class="mb-1">
                                    <span class="small font-weight-bold">Marie Dupont</span>
                                    <span class="small text-muted ml-2">09:45</span>
                                </div>
                                Bonjour Dr. Martin, j'ai des maux de tête sévères depuis deux jours. Devrais-je m'inquiéter?
                            </div>

                            <div class="chat-message outgoing">
                                <div class="mb-1">
                                    <span class="small font-weight-bold">Vous</span>
                                    <span class="small text-muted ml-2">09:48</span>
                                </div>
                                Bonjour Marie, ressentez-vous d'autres symptômes comme des nausées ou une sensibilité à la
                                lumière?
                            </div>

                            <div class="chat-message incoming">
                                <div class="mb-1">
                                    <span class="small font-weight-bold">Marie Dupont</span>
                                    <span class="small text-muted ml-2">09:52</span>
                                </div>
                                Oui, je me sens un peu nauséeuse, surtout le matin.
                            </div>

                            <div class="chat-message outgoing">
                                <div class="mb-1">
                                    <span class="small font-weight-bold">Vous</span>
                                    <span class="small text-muted ml-2">09:55</span>
                                </div>
                                Ces symptômes pourraient indiquer une migraine. Avez-vous déjà souffert de migraines par le
                                passé?
                            </div>

                            <div class="chat-message incoming">
                                <div class="mb-1">
                                    <span class="small font-weight-bold">Marie Dupont</span>
                                    <span class="small text-muted ml-2">10:01</span>
                                </div>
                                Non, c'est la première fois que je ressens ces symptômes de manière aussi intense.
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex mt-3">
                            <div class="dropdown mr-2">
                                <button class="btn btn-light dropdown-toggle" type="button" id="responseTemplates"
                                    data-toggle="dropdown">
                                    <i class="fas fa-reply-all"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Réponse standard - Conseil</a>
                                    <a class="dropdown-item" href="#">Réponse standard - Urgence</a>
                                    <a class="dropdown-item" href="#">Réponse standard - Rendez-vous</a>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Tapez votre message...">
                            <button class="btn btn-primary ml-2">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary mr-auto">
                            <i class="fas fa-calendar-plus mr-1"></i> Créer Rendez-vous
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary">Marquer comme résolu</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Dossier Médical -->
        <div class="modal fade" id="medicalRecordModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dossier Médical - Marie Dupont</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="medicalRecordTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary"
                                    role="tab">Résumé</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history"
                                    role="tab">Antécédents</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="visits-tab" data-toggle="tab" href="#visits"
                                    role="tab">Consultations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="prescriptions-tab" data-toggle="tab" href="#prescriptions"
                                    role="tab">Ordonnances</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="results-tab" data-toggle="tab" href="#results"
                                    role="tab">Résultats</a>
                            </li>
                        </ul>
                        <div class="tab-content p-3" id="medicalRecordTabsContent">
                            <div class="tab-pane fade show active" id="summary" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 text-center mb-4">
                                        <img src="https://randomuser.me/api/portraits/women/45.jpg"
                                            class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                                        <h5>Marie Dupont</h5>
                                        <p class="text-muted">Née le 15/03/1985 (40 ans)</p>
                                        <span class="badge badge-primary">Groupe sanguin: A+</span>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="font-weight-bold">Informations personnelles</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-muted">N° Sécurité Sociale:</div>
                                            <div class="col-md-8">285037512345678</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-muted">Adresse:</div>
                                            <div class="col-md-8">12 Rue des Lilas, 75011 Paris</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-muted">Téléphone:</div>
                                            <div class="col-md-8">06 12 34 56 78</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-muted">Email:</div>
                                            <div class="col-md-8">marie.dupont@email.com</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-muted">Contact urgence:</div>
                                            <div class="col-md-8">Pierre Dupont (Époux) - 06 98 76 54 32</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h6 class="font-weight-bold">Allergies et contre-indications</h6>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Allergie à la pénicilline
                                </div>
                                <h6 class="font-weight-bold">Notes importantes</h6>
                                <p>Antécédents de diabète type 2 dans la famille. Suivi régulier de la glycémie recommandé.
                                </p>
                            </div>

                            <div class="tab-pane fade" id="history" role="tabpanel">
                                <!-- Contenu des antécédents médicaux -->
                            </div>

                            <div class="tab-pane fade" id="visits" role="tabpanel">
                                <!-- Historique des consultations -->
                            </div>

                            <div class="tab-pane fade" id="prescriptions" role="tabpanel">
                                <!-- Historique des ordonnances -->
                            </div>

                            <div class="tab-pane fade" id="results" role="tabpanel">
                                <!-- Résultats des analyses -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary mr-auto">
                            <i class="fas fa-print mr-1"></i> Imprimer
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-edit mr-1"></i> Modifier
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Nouvelle Ordonnance -->
        <div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nouvelle Ordonnance - Marie Dupont</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="prescription-form">
                            <div class="form-group">
                                <label>Date de prescription</label>
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="form-group">
                                <label>Diagnostic</label>
                                <input type="text" class="form-control" placeholder="Entrez le diagnostic">
                            </div>

                            <hr>
                            <h6 class="font-weight-bold mb-3">Médicaments</h6>

                            <div id="medicationsList">
                                <div class="medicine-item">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Médicament</label>
                                                <input type="text" class="form-control" placeholder="Nom du médicament">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Dose</label>
                                                <input type="text" class="form-control" placeholder="Dose">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Unité</label>
                                                <select class="form-control">
                                                    <option>mg</option>
                                                    <option>g</option>
                                                    <option>ml</option>
                                                    <option>comprimé(s)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Instructions</label>
                                                <input type="text" class="form-control" placeholder="Instruction de prise">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Durée</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" value="7">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">jours</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-outline-primary">
                                    <i class="fas fa-plus"></i> Ajouter un médicament
                                </button>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label>Notes additionnelles</label>
                                <textarea class="form-control" rows="3"
                                    placeholder="Notes ou recommandations supplémentaires"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-outline-primary mr-2">
                            <i class="fas fa-save mr-1"></i> Enregistrer brouillon
                        </button>
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-1"></i> Valider et envoyer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Configuration Disponibilités -->
        <div class="modal fade" id="availabilityModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Configurer mes disponibilités</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary">Lun</button>
                                <button type="button" class="btn btn-outline-primary">Mar</button>
                                <button type="button" class="btn btn-outline-primary">Mer</button>
                                <button type="button" class="btn btn-outline-primary">Jeu</button>
                                <button type="button" class="btn btn-outline-primary">Ven</button>
                                <button type="button" class="btn btn-outline-primary">Sam</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Heures de travail</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>De</label>
                                    <input type="time" class="form-control" value="09:00">
                                </div>
                                <div class="col-md-6">
                                    <label>À</label>
                                    <input type="time" class="form-control" value="18:00">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Pause déjeuner</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>De</label>
                                    <input type="time" class="form-control" value="12:00">
                                </div>
                                <div class="col-md-6">
                                    <label>À</label>
                                    <input type="time" class="form-control" value="14:00">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Durée des rendez-vous</label>
                            <select class="form-control">
                                <option>15 minutes</option>
                                <option selected>30 minutes</option>
                                <option>45 minutes</option>
                                <option>60 minutes</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Options avancées</label>
                            <div class="custom-control custom-switch mb-2">
                                <input type="checkbox" class="custom-control-input" id="allowOnlineBooking" checked>
                                <label class="custom-control-label" for="allowOnlineBooking">Autoriser les rendez-vous en
                                    ligne</label>
                            </div>
                            <div class="custom-control custom-switch mb-2">
                                <input type="checkbox" class="custom-control-input" id="allowEmergencySlots">
                                <label class="custom-control-label" for="allowEmergencySlots">Réserver des créneaux
                                    d'urgence</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="notifyNewAppointments" checked>
                                <label class="custom-control-label" for="notifyNewAppointments">Notification des nouveaux
                                    rendez-vous</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function () {
            // Initialisation des tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Configuration du graphique des tendances de rendez-vous
            const appointmentsTrendCtx = document.getElementById('appointmentsTrend').getContext('2d');
            const appointmentsTrendChart = new Chart(appointmentsTrendCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil'],
                    datasets: [{
                        label: 'Consultations',
                        data: [65, 72, 78, 84, 82, 95, 92],
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Évolution des consultations'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2],
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            // Configuration du graphique des types de consultation
            const consultationTypesCtx = document.getElementById('consultationTypes').getContext('2d');
            const consultationTypesChart = new Chart(consultationTypesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Check-up', 'Suivi', 'Urgence', 'Spécialité'],
                    datasets: [{
                        data: [35, 45, 10, 10],
                        backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b', '#f6c23e'],
                        hoverOffset: 4
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

            // Configuration du graphique de satisfaction des patients
            const patientSatisfactionCtx = document.getElementById('patientSatisfaction').getContext('2d');
            const patientSatisfactionChart = new Chart(patientSatisfactionCtx, {
                type: 'bar',
                data: {
                    labels: ['Très satisfait', 'Satisfait', 'Neutre', 'Insatisfait'],
                    datasets: [{
                        label: 'Niveau de satisfaction',
                        data: [75, 20, 4, 1],
                        backgroundColor: [
                            'rgba(28, 200, 138, 0.8)',
                            'rgba(54, 185, 204, 0.8)',
                            'rgba(246, 194, 62, 0.8)',
                            'rgba(231, 74, 59, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });


    </script>
@endsection