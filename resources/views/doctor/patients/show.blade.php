<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Détails du patient | MediClinic</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
                            50: '#f0f5ff',
                            100: '#e0eaff',
                            200: '#c7d9ff',
                            300: '#a5bfff',
                            400: '#819afc',
                            500: '#6373f7',
                            600: '#4f56e5',
                            700: '#4146c8',
                            800: '#3639a2',
                            900: '#2f3281'
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
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669'
                        },
                        danger: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            500: '#ef4444',
                            600: '#dc2626'
                        },
                        warning: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            500: '#f59e0b',
                            600: '#d97706'
                        },
                        info: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    boxShadow: {
                        card: '0 4px 25px 0 rgba(0, 0, 0, 0.1)',
                        nav: '0 2px 10px 0 rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 10px 40px -5px rgba(0, 0, 0, 0.15)'
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
            font-family: 'Inter', sans-serif;
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
            box-shadow: var(--tw-shadow-card-hover);
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
            background: linear-gradient(120deg, #4f56e5, #6373f7);
        }
        
        .grid-masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-gap: 1.5rem;
        }
        
        .appointment-card {
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }
        
        .appointment-card:hover {
            background-color: #f8fafc;
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
        
        /* Animations */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
        
        .animate-pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #6373f7;
        }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                background-color: white;
            }
            
            .card {
                box-shadow: none !important;
                border: 1px solid #e5e7eb;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- En-tête avec bouton retour et actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
            <div class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="flex items-center justify-center h-10 w-10 rounded-full bg-white text-primary-600 hover:bg-primary-50 transition duration-300 mr-4 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Détails du patient</h1>
            </div>
        </div>

        <!-- Messages d'alerte -->
        @if(session('success'))
        <div class="bg-success-50 border-l-4 border-success-500 text-success-600 p-4 rounded-lg shadow-sm mb-6 animate-fade-in" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-success-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex rounded-md p-1.5 text-success-500 hover:bg-success-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Dismiss</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-danger-50 border-l-4 border-danger-500 text-danger-600 p-4 rounded-lg shadow-sm mb-6 animate-fade-in" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-danger-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex rounded-md p-1.5 text-danger-500 hover:bg-danger-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Dismiss</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne gauche: Informations principales -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Carte d'informations du patient -->
                <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                    <div class="px-8 py-6 header-gradient relative overflow-hidden">
                        <!-- Cercles décoratifs -->
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                        <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                        
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
                            <div class="flex items-center">
                                <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center mr-4 backdrop-blur-sm">
                                    <i class="fas fa-user-circle text-white text-3xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white mb-1">{{ $patient->user->name ?? 'Nom du patient' }}</h2>
                                    <p class="text-primary-100 text-sm flex items-center">
                                        <i class="fas fa-id-card mr-2"></i>
                                        Patient ID: {{ $patient->id }} | Inscrit depuis le {{ $patient->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('doctor.patients.update', $patient->user->id) }}" class="inline-flex items-center px-4 py-2 border border-white text-white rounded-lg shadow-sm text-sm font-medium bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition duration-300 backdrop-blur-sm">
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
                                            <a href="tel:{{ $patient->user->phone ?? 'N/A' }}" class="hover:text-primary-600 transition-colors">
                                                {{ $patient->user->phone ?? 'N/A' }}
                                            </a>
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
                                            @if($patient->user->address)
                                                <div class="flex items-start">
                                                    <span>{{ $patient->user->address }}</span>
                                                    <a href="https://maps.google.com/?q={{ urlencode($patient->user->address) }}" target="_blank" class="ml-2 text-primary-500 hover:text-primary-700" title="Voir sur Google Maps">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </div>
                                            @else
                                                Non spécifiée
                                            @endif
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
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-50 text-danger-700 border border-danger-200">
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
                                                        <div class="flex items-center">
                                                            <i class="fas fa-ruler-vertical text-primary-400 mr-2"></i>
                                                            <span>{{ $patient->height }} cm</span>
                                                        </div>
                                                    @endif
                                                    @if($patient->weight)
                                                        <div class="flex items-center">
                                                            <i class="fas fa-weight-scale text-primary-400 mr-2"></i>
                                                            <span>{{ $patient->weight }} kg</span>
                                                        </div>
                                                    @endif
                                                    @if($patient->height && $patient->weight)
                                                        @php
                                                            $heightInMeters = $patient->height / 100;
                                                            $bmi = $patient->weight / ($heightInMeters * $heightInMeters);
                                                            $bmi = round($bmi, 1);
                                                            
                                                            if ($bmi < 18.5) {
                                                                $bmiCategory = 'Insuffisance pondérale';
                                                                $bmiColor = 'text-blue-600 bg-blue-50';
                                                            } elseif ($bmi < 25) {
                                                                $bmiCategory = 'Poids normal';
                                                                $bmiColor = 'text-green-600 bg-green-50';
                                                            } elseif ($bmi < 30) {
                                                                $bmiCategory = 'Surpoids';
                                                                $bmiColor = 'text-yellow-600 bg-yellow-50';
                                                            } else {
                                                                $bmiCategory = 'Obésité';
                                                                $bmiColor = 'text-orange-600 bg-orange-50';
                                                            }
                                                        @endphp
                                                        <div class="flex items-center mt-1">
                                                            <i class="fas fa-calculator text-primary-400 mr-2"></i>
                                                            <span>IMC: <strong>{{ $bmi }}</strong></span>
                                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $bmiColor }}">
                                                                {{ $bmiCategory }}
                                                            </span>
                                                        </div>
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
                                            @if($patient->emergency_contact)
                                                <div class="flex items-center">
                                                    <span>{{ $patient->emergency_contact }}</span>
                                                    <a href="tel:{{ $patient->emergency_contact }}" class="ml-2 text-primary-500 hover:text-primary-700">
                                                        <i class="fas fa-phone"></i>
                                                    </a>
                                                </div>
                                            @else
                                                Non spécifié
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="px-6 py-4 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 info-item">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-shield-alt text-primary-400 mr-2"></i>
                                            Assurance
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $patient->insurance ?? 'Non spécifiée' }}
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
                        <div class="px-6 py-4 bg-danger-50 border-b border-danger-100 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-allergies text-danger-500 text-lg mr-3"></i>
                                <h3 class="text-lg font-semibold text-danger-600">Allergies</h3>
                            </div>
                            <button class="text-danger-500 hover:text-danger-700 transition-colors" title="Ajouter une allergie">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                        <div class="p-6">
                            @if(is_array($patient->allergies) && count($patient->allergies) > 0)
                                <ul class="space-y-2">
                                    @foreach($patient->allergies as $allergie)
                                        <li class="flex items-start bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-all border border-gray-100">
                                            <i class="fas fa-exclamation-circle text-danger-500 mr-3 mt-0.5"></i>
                                            <span class="text-gray-700 flex-grow">{{ $allergie }}</span>
                                            <button class="text-gray-400 hover:text-danger-500 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif(is_string($patient->allergies) && !empty($patient->allergies))
                                <p class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">{{ $patient->allergies }}</p>
                            @else
                                <div class="flex flex-col items-center justify-center py-6 text-center">
                                    <div class="w-16 h-16 bg-success-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-check-circle text-success-500 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 mb-3">Aucune allergie connue</p>
                                    <button class="px-4 py-2 bg-danger-50 text-danger-600 rounded-lg hover:bg-danger-100 transition-all flex items-center">
                                        <i class="fas fa-plus mr-2"></i>Ajouter une allergie
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Antécédents médicaux -->
                    <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                        <div class="px-6 py-4 bg-info-50 border-b border-info-100 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-notes-medical text-info-500 text-lg mr-3"></i>
                                <h3 class="text-lg font-semibold text-info-600">Antécédents médicaux</h3>
                            </div>
                            <button class="text-info-500 hover:text-info-700 transition-colors" title="Ajouter un antécédent">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                        <div class="p-6">
                            @if(is_array($patient->medical_history) && count($patient->medical_history) > 0)
                                <ul class="space-y-2">
                                    @foreach($patient->medical_history as $history)
                                        <li class="flex items-start bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-all border border-gray-100">
                                            <i class="fas fa-file-medical text-info-500 mr-3 mt-0.5"></i>
                                            <span class="text-gray-700 flex-grow">{{ $history }}</span>
                                            <button class="text-gray-400 hover:text-info-500 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif(is_string($patient->medical_history) && !empty($patient->medical_history))
                                <p class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">{{ $patient->medical_history }}</p>
                            @else
                                <div class="flex flex-col items-center justify-center py-6 text-center">
                                    <div class="w-16 h-16 bg-success-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-clipboard-check text-success-500 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 mb-3">Aucun antécédent médical connu</p>
                                    <button class="px-4 py-2 bg-info-50 text-info-600 rounded-lg hover:bg-info-100 transition-all flex items-center">
                                        <i class="fas fa-plus mr-2"></i>Ajouter un antécédent
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Notes -->
                <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                    <div class="px-6 py-4 bg-warning-50 border-b border-warning-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-sticky-note text-warning-500 text-lg mr-3"></i>
                            <h3 class="text-lg font-semibold text-warning-600">Notes</h3>
                        </div>
                        <button class="text-warning-500 hover:text-warning-700 transition-colors" title="Modifier les notes">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        @if($patient->notes)
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-warning-500">
                                <p class="whitespace-pre-line text-gray-700">{{ $patient->notes }}</p>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-clipboard text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 mb-3">Aucune note disponible</p>
                                <button class="px-4 py-2 bg-warning-50 text-warning-600 rounded-lg hover:bg-warning-100 transition-all flex items-center">
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
                        <a href="#" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-primary-200 text-primary-600 rounded-lg hover:bg-primary-50 transition-all action-button shadow-sm">
                            <span class="flex items-center">
                                <i class="fas fa-file-medical-alt text-lg mr-3"></i>
                                Résultats d'analyses
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
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700 border border-primary-200">
                            Récents
                        </span>
                    </div>
                    
                    <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">                        
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 border border-success-200">
                                            <span class="w-1.5 h-1.5 bg-success-500 rounded-full mr-1.5"></span>
                                            Terminé
                                        </span>
                                    @elseif($appointment->status == 'canceled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-50 text-danger-700 border border-danger-200">
                                            <span class="w-1.5 h-1.5 bg-danger-500 rounded-full mr-1.5"></span>
                                            Annulé
                                        </span>
                                    @elseif($appointment->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-50 text-warning-700 border border-warning-200">
                                            <span class="w-1.5 h-1.5 bg-warning-500 rounded-full mr-1.5 animate-pulse-slow"></span>
                                            En attente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
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
                            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-calendar-xmark text-gray-400 text-2xl"></i>
                            </div>
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
                        <div class="bg-gray-50 rounded-xl p-4 text-center hover:bg-primary-50 transition-colors">
                            <i class="fas fa-calendar-check text-primary-400 text-xl mb-2"></i>
                            <h4 class="text-sm text-gray-500">Total RDV</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ count($appointments) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center hover:bg-info-50 transition-colors">
                            <i class="fas fa-file-medical text-info-500 text-xl mb-2"></i>
                            <h4 class="text-sm text-gray-500">Dossiers</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ rand(1, 5) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center hover:bg-success-50 transition-colors">
                            <i class="fas fa-pills text-success-500 text-xl mb-2"></i>
                            <h4 class="text-sm text-gray-500">Prescriptions</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ rand(1, 8) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center hover:bg-warning-50 transition-colors">
                            <i class="fas fa-flask text-warning-500 text-xl mb-2"></i>
                            <h4 class="text-sm text-gray-500">Analyses</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ rand(0, 3) }}</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Dernière mise à jour</span>
                            <span class="text-sm font-medium">{{ now()->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Documents du patient -->
                <div class="bg-white rounded-2xl shadow-card overflow-hidden card">
                    <div class="px-6 py-4 bg-primary-50 border-b border-primary-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt text-primary-500 text-lg mr-3"></i>
                            <h3 class="text-lg font-semibold text-primary-700">Documents</h3>
                        </div>
                        <button class="text-primary-500 hover:text-primary-700 transition-colors" title="Ajouter un document">
                            <i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <ul class="divide-y divide-gray-100">
                            <li class="py-3 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-file-pdf text-red-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Résultats d'analyse</p>
                                        <p class="text-xs text-gray-500">PDF • 2.4 MB • 12/04/2023</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="p-1.5 text-gray-500 hover:text-primary-600 transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="p-1.5 text-gray-500 hover:text-primary-600 transition-colors">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="py-3 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-file-image text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Radiographie</p>
                                        <p class="text-xs text-gray-500">JPEG • 3.8 MB • 05/03/2023</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="p-1.5 text-gray-500 hover:text-primary-600 transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="p-1.5 text-gray-500 hover:text-primary-600 transition-colors">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation pour les cartes
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('shadow-card-hover');
                });
                
                card.addEventListener('mouseleave', function() {
                    this.classList.remove('shadow-card-hover');
                });
            });
            
            // Highlight des éléments d'information au survol
            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.classList.add('bg-primary-50');
                    this.classList.remove('bg-gray-50');
                });
                
                item.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-primary-50');
                    if(Array.from(this.parentNode.children).indexOf(this) % 2 !== 0) {
                        this.classList.add('bg-gray-50');
                    }
                });
            });
            
            // Fermeture des alertes
            const alertCloseButtons = document.querySelectorAll('[role="alert"] button');
            alertCloseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('[role="alert"]').remove();
                });
            });
            
            // Animation pour les boutons d'action
            const actionButtons = document.querySelectorAll('.action-button');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    const icon = this.querySelector('i.fas.fa-chevron-right');
                    if (icon) {
                        icon.classList.add('transform', 'translate-x-1');
                    }
                });
                
                button.addEventListener('mouseleave', function() {
                    const icon = this.querySelector('i.fas.fa-chevron-right');
                    if (icon) {
                        icon.classList.remove('transform', 'translate-x-1');
                    }
                });
            });
        });
    </script>
</body>
</html>