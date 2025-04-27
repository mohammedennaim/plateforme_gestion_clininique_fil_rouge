<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Détails du patient | MediClinic</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81'
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            500: '#64748b',
                            700: '#334155',
                            900: '#0f172a'
                        },
                        success: {
                            50: '#ecfdf5',
                            500: '#10b981',
                            600: '#059669'
                        },
                        danger: {
                            50: '#fef2f2',
                            500: '#ef4444',
                            600: '#dc2626'
                        },
                        warning: {
                            50: '#fffbeb',
                            500: '#f59e0b',
                            600: '#d97706'
                        },
                        info: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb'
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif']
                    },
                    boxShadow: {
                        card: '0 4px 25px 0 rgba(0, 0, 0, 0.1)',
                        nav: '0 2px 10px 0 rgba(0, 0, 0, 0.05)'
                    },
                    borderRadius: {
                        'xl': '1rem',
                        '2xl': '1.5rem'
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
        
        .badge {
            padding: 0.3em 0.8em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 9999px;
            letter-spacing: 0.025em;
            text-transform: uppercase;
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.1);
        }
        
        .info-item {
            transition: all 0.2s ease;
        }
        
        .info-item:hover {
            background-color: #f1f5f9;
        }
        
        .action-button {
            transition: all 0.2s ease;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
        }
        
        .header-gradient {
            background: linear-gradient(120deg, #4f46e5, #9333ea);
        }
        
        .grid-masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-gap: 1.5rem;
        }
        
        .appointment-card {
            border-left: 4px solid transparent;
        }
        
        .appointment-card.completed {
            border-left-color: #10b981;
        }
        
        .appointment-card.pending {
            border-left-color: #f59e0b;
        }
        
        .appointment-card.cancelled {
            border-left-color: #ef4444;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- En-tête avec bouton retour -->
        <div class="flex items-center mb-8">
            <a href="{{ route('doctor.dashboard') }}" class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-primary-600 hover:bg-primary-50 transition duration-300 mr-4 shadow-sm">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Détails du patient</h1>
        </div>

        <!-- Messages d'alerte -->
        @if(session('success'))
        <div class="bg-success-50 border-l-4 border-success-500 text-success-600 p-4 rounded-lg shadow-sm mb-6" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-success-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-danger-50 border-l-4 border-danger-500 text-danger-600 p-4 rounded-lg shadow-sm mb-6" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-danger-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne gauche: Informations principales -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Carte d'informations du patient -->
                <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                    <div class="px-8 py-6 header-gradient">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-1">{{ $patient->user->name ?? 'Nom du patient' }}</h2>
                                <p class="text-primary-100 text-sm flex items-center">
                                    <i class="fas fa-id-card mr-2"></i>
                                    Patient ID: {{ $patient->id }} | Inscrit depuis le {{ $patient->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('doctor.patients.update', $patient->user->id) }}" class="inline-flex items-center px-4 py-2 border border-white text-white rounded-lg shadow-sm text-sm font-medium bg-opacity-10 bg-white hover:bg-opacity-20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition duration-300">
                                    <i class="fas fa-edit mr-2"></i>
                                    Modifier
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                            <div>
                                <dl>
                                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-user text-primary-400 mr-2"></i>
                                            Nom complet
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-medium">
                                            {{ $patient->user->name ?? 'N/A' }}
                                        </dd>
                                    </div>
                                    <div class="px-6 py-4 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-envelope text-primary-400 mr-2"></i>
                                            E-mail
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $patient->user->email ?? 'N/A' }}
                                        </dd>
                                    </div>
                                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-phone text-primary-400 mr-2"></i>
                                            Téléphone
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $patient->user->phone ?? 'N/A' }}
                                        </dd>
                                    </div>
                                    <div class="px-6 py-4 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-birthday-cake text-primary-400 mr-2"></i>
                                            Naissance
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            @if($patient->user->date_of_birth)
                                                <span class="font-medium">{{ \Carbon\Carbon::parse($patient->user->date_of_birth)->age }} ans</span> 
                                                <span class="text-gray-500">({{ \Carbon\Carbon::parse($patient->user->date_of_birth)->format('d/m/Y') }})</span>
                                            @else
                                                Non spécifié
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-map-marker-alt text-primary-400 mr-2"></i>
                                            Adresse
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $patient->user->address ?? 'Non spécifiée' }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div>
                                <dl>
                                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-tint text-danger-500 mr-2"></i>
                                            Groupe sanguin
                                        </dt>
                                        <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                            @if($patient->blood_type)
                                                <span class="badge bg-danger-50 text-danger-600">
                                                    {{ $patient->blood_type }}
                                                </span>
                                            @else
                                                Non spécifié
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="px-6 py-4 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-weight text-primary-400 mr-2"></i>
                                            Taille / Poids
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            @if($patient->height || $patient->weight)
                                                <div class="flex flex-col space-y-1">
                                                    @if($patient->height)
                                                        <span><i class="fas fa-ruler-vertical text-primary-400 mr-2"></i> {{ $patient->height }} cm</span>
                                                    @endif
                                                    @if($patient->weight)
                                                        <span><i class="fas fa-weight-scale text-primary-400 mr-2"></i> {{ $patient->weight }} kg</span>
                                                    @endif
                                                </div>
                                            @else
                                                Non spécifié
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-phone-alt text-primary-400 mr-2"></i>
                                            Contact d'urgence
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $patient->emergency_contact ?? 'Non spécifié' }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Allergies et Antécédents -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Allergies -->
                    <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                        <div class="px-6 py-4 bg-danger-50 border-b border-danger-100 flex items-center">
                            <i class="fas fa-allergies text-danger-500 text-lg mr-3"></i>
                            <h3 class="text-lg font-semibold text-danger-600">Allergies</h3>
                        </div>
                        <div class="p-6">
                            @if(is_array($patient->allergies) && count($patient->allergies) > 0)
                                <ul class="space-y-2">
                                    @foreach($patient->allergies as $allergie)
                                        <li class="flex items-start bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-all">
                                            <i class="fas fa-exclamation-circle text-danger-500 mr-3 mt-0.5"></i>
                                            <span class="text-gray-700">{{ $allergie }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif(is_string($patient->allergies) && !empty($patient->allergies))
                                <p class="bg-white p-3 rounded-lg shadow-sm">{{ $patient->allergies }}</p>
                            @else
                                <div class="flex flex-col items-center justify-center py-6 text-center">
                                    <i class="fas fa-check-circle text-success-500 text-3xl mb-2"></i>
                                    <p class="text-gray-500">Aucune allergie connue</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Antécédents médicaux -->
                    <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                        <div class="px-6 py-4 bg-info-50 border-b border-info-100 flex items-center">
                            <i class="fas fa-notes-medical text-info-500 text-lg mr-3"></i>
                            <h3 class="text-lg font-semibold text-info-600">Antécédents médicaux</h3>
                        </div>
                        <div class="p-6">
                            @if(is_array($patient->medical_history) && count($patient->medical_history) > 0)
                                <ul class="space-y-2">
                                    @foreach($patient->medical_history as $history)
                                        <li class="flex items-start bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-all">
                                            <i class="fas fa-file-medical text-info-500 mr-3 mt-0.5"></i>
                                            <span class="text-gray-700">{{ $history }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif(is_string($patient->medical_history) && !empty($patient->medical_history))
                                <p class="bg-white p-3 rounded-lg shadow-sm">{{ $patient->medical_history }}</p>
                            @else
                                <div class="flex flex-col items-center justify-center py-6 text-center">
                                    <i class="fas fa-clipboard-check text-success-500 text-3xl mb-2"></i>
                                    <p class="text-gray-500">Aucun antécédent médical connu</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Notes -->
                <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                    <div class="px-6 py-4 bg-warning-50 border-b border-warning-100 flex items-center">
                        <i class="fas fa-sticky-note text-warning-500 text-lg mr-3"></i>
                        <h3 class="text-lg font-semibold text-warning-600">Notes</h3>
                    </div>
                    <div class="p-6">
                        @if($patient->notes)
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-warning-500">
                                <p class="whitespace-pre-line text-gray-700">{{ $patient->notes }}</p>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <i class="fas fa-clipboard text-gray-300 text-3xl mb-2"></i>
                                <p class="text-gray-500">Aucune note disponible</p>
                                <button class="mt-3 px-4 py-2 bg-warning-50 text-warning-600 rounded-lg hover:bg-warning-100 transition-all">
                                    <i class="fas fa-plus mr-2"></i>Ajouter une note
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Colonne droite: Actions et historique -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Carte d'actions rapides -->
                <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                    <div class="px-6 py-4 bg-primary-50 border-b border-primary-100 flex items-center">
                        <i class="fas fa-bolt text-primary-500 text-lg mr-3"></i>
                        <h3 class="text-lg font-semibold text-primary-700">Actions rapides</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <a href="{{ route('doctor.appointments.create', $patient->id) }}" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-primary-200 text-primary-600 rounded-lg hover:bg-primary-50 transition-all action-button shadow-sm">
                            <span class="flex items-center">
                                <i class="fas fa-calendar-plus text-lg mr-3"></i>
                                Nouveau rendez-vous
                            </span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-primary-200 text-primary-600 rounded-lg hover:bg-primary-50 transition-all action-button shadow-sm">
                            <span class="flex items-center">
                                <i class="fas fa-folder-plus text-lg mr-3"></i>
                                Dossiers Médicaux
                            </span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-primary-200 text-primary-600 rounded-lg hover:bg-primary-50 transition-all action-button shadow-sm">
                            <span class="flex items-center">
                                <i class="fas fa-pills text-lg mr-3"></i>
                                Nouvelle prescription
                            </span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-primary-200 text-primary-600 rounded-lg hover:bg-primary-50 transition-all action-button shadow-sm">
                            <span class="flex items-center">
                                <i class="fas fa-comments text-lg mr-3"></i>
                                Envoyer un message
                            </span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Derniers rendez-vous -->
                <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                    <div class="px-6 py-4 bg-primary-50 border-b border-primary-100 flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-check text-primary-500 text-lg mr-3"></i>
                            <h3 class="text-lg font-semibold text-primary-700">Derniers rendez-vous</h3>
                        </div>
                        <span class="badge bg-primary-100 text-primary-700">
                            Récents
                        </span>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @php
                            $appointments = \App\Models\Appointment::where('patient_id', $patient->id)
                                ->where('doctor_id', auth()->user()->doctor->id)
                                ->orderBy('date', 'desc')
                                ->take(5)
                                ->get();
                        @endphp
                        
                        @forelse($appointments as $appointment)
                        <div class="p-4 hover:bg-gray-50 transition-all appointment-card {{ $appointment->status }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-calendar-day text-primary-400 mr-2"></i>
                                        <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</span>
                                        <span class="mx-2 text-gray-300">|</span>
                                        <i class="fas fa-clock text-primary-400 mr-2"></i>
                                        <span class="text-sm text-gray-600">{{ $appointment->time }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 mb-2">{{ $appointment->reason ?? 'Consultation générale' }}</p>
                                </div>
                                <div>
                                    @if($appointment->status == 'completed')
                                        <span class="badge bg-success-50 text-success-600">
                                            Terminé
                                        </span>
                                    @elseif($appointment->status == 'canceled')
                                        <span class="badge bg-danger-50 text-danger-600">
                                            Annulé
                                        </span>
                                    @elseif($appointment->status == 'pending')
                                        <span class="badge bg-warning-50 text-warning-600">
                                            En attente
                                        </span>
                                    @else
                                        <span class="badge bg-gray-100 text-gray-700">
                                            {{ $appointment->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 flex justify-end">
                                <a href="{{ route('doctor.appointments.show', $appointment->id) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-primary-600 hover:text-primary-800 transition-all">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <i class="fas fa-calendar-xmark text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500 mb-4">Aucun rendez-vous trouvé</p>
                            <a href="{{ route('doctor.appointments.create', $patient->id) }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all inline-flex items-center shadow-sm">
                                <i class="fas fa-plus mr-2"></i>
                                Planifier une consultation
                            </a>
                        </div>
                        @endforelse
                    </div>
                    
                    @if(count($appointments) > 0)
                    <div class="px-6 py-4 bg-gray-50 text-right">
                        <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-800 flex items-center justify-end transition-all">
                            Voir tous les rendez-vous
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    @endif
                </div>
                
                <!-- Statistiques du patient -->
                <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                    <div class="px-6 py-4 bg-primary-50 border-b border-primary-100 flex items-center">
                        <i class="fas fa-chart-line text-primary-500 text-lg mr-3"></i>
                        <h3 class="text-lg font-semibold text-primary-700">Statistiques</h3>
                    </div>
                    <div class="p-6 grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fas fa-calendar-check text-primary-400 text-xl mb-2"></i>
                            <h4 class="text-sm text-gray-500">Total RDV</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ count($appointments) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fas fa-file-medical text-info-500 text-xl mb-2"></i>
                            <h4 class="text-sm text-gray-500">Dossiers</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ rand(1, 5) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fas fa-pills text-success-500 text-xl mb-2"></i>
                            <h4 class="text-sm text-gray-500">Prescriptions</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ rand(1, 8) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fas fa-flask text-warning-500 text-xl mb-2"></i>
                            <h4 class="text-sm text-gray-500">Analyses</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ rand(0, 3) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts optionnels pour les interactions avancées -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animation pour les cartes
            $('.card').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );
            
            // Highlight des éléments d'information au survol
            $('.info-item').hover(
                function() {
                    $(this).addClass('bg-primary-50');
                    $(this).removeClass('bg-gray-50');
                },
                function() {
                    $(this).removeClass('bg-primary-50');
                    if($(this).index() % 2 !== 0) {
                        $(this).addClass('bg-gray-50');
                    }
                }
            );
        });
    </script>
</body>
</html>