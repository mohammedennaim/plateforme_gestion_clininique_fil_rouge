<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Rendez-vous | Clinique Médicale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }

        input[type="date"],
        input[type="time"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .invalid-feedback {
            display: none;
        }

        input:invalid+.invalid-feedback,
        select:invalid+.invalid-feedback {
            display: block;
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #1e293b;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.75rem;
        }

        .tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #1e293b transparent transparent transparent;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-primary-50 to-secondary-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-hospital text-primary-600 text-2xl mr-2"></i>
                <span class="text-xl font-semibold text-primary-700">MediClinic</span>
            </div>
            <nav class="hidden md:flex space-x-6">
                <a href="{{ route('welcome') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Accueil</a>
                <a href="{{ route('services') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Services</a>
                <a href="{{ route('doctors') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Médecins</a>
                <a href="{{ route('patient.reserver.store') }}" class="text-primary-600 font-medium">Rendez-vous</a>
                <a href="{{ route('contact') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Contact</a>
            </nav>

            <!-- User Authentication Section -->
            <div class="flex items-center space-x-4">


                <!-- Profil utilisateur (caché par défaut) -->
                <div id="user-profile" class="items-center">
                    <div class="relative">
                        <button id="profile-dropdown-button" class="flex items-center space-x-2 focus:outline-none">
                            <div
                                class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <span class="text-sm font-medium text-secondary-700">{{ $user['name'] }}</span>
                            <i class="fas fa-chevron-down text-secondary-400 text-xs"></i>
                        </button>

                        <!-- Dropdown menu (caché par défaut) -->
                        <div id="profile-dropdown"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                <i class="fas fa-user mr-2 text-secondary-400"></i>Mon profil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                <i class="fas fa-calendar-check mr-2 text-secondary-400"></i>Mes rendez-vous
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                <i class="fas fa-cog mr-2 text-secondary-400"></i>Paramètres
                            </a>
                            <div class="border-t border-secondary-200 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" id="logout-button"
                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-secondary-50 w-full">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-secondary-800 mb-2">Réserver un rendez-vous</h1>
                <p class="text-secondary-500">Prenez rendez-vous avec l'un de nos spécialistes en quelques clics</p>
            </div>

            <!-- User Welcome Banner (pour utilisateurs connectés) -->
            <div id="user-welcome" class="mb-8 bg-primary-50 rounded-xl p-6 border border-primary-100 animate-fadeIn">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                            <i class="fas fa-user-circle text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-medium text-secondary-800">Bienvenue, {{ $user['name'] }}</h2>
                        <p class="text-secondary-600 mt-1">Nous sommes ravis de vous revoir. Vos informations
                            personnelles ont été pré-remplies pour faciliter votre réservation.</p>

                        <!-- Derniers rendez-vous -->
                         @if( $appointment != null)
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-secondary-700 mb-2">Vos derniers rendez-vous :</h3>
                            <div class="bg-white rounded-lg p-3 border border-secondary-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-secondary-800">Dr. {{ $medecinDernierVisit["name"] }}</p>
                                        <!-- <p class="text-xs text-secondary-500">Lundi 10 avril 2023, 10:30</p> -->
                                        <p class="text-xs text-secondary-500">{{ $appointment["date"]->format('d/m/Y') }} {{  $appointment["time"]->format('h:i') }}</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        @else 
                        <span></span>
                        @endif
                        
                    </div>
                </div>
            </div>



            <!-- Booking Form Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                <!-- Progress Steps -->
                <div class="flex justify-between mb-8 relative">
                    <div class="absolute top-1/3 left-0 right-0 h-0.5 bg-secondary-200 -translate-y-1/2 z-0"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div id="step-indicator-1"
                            class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center">
                            <i class="fas fa-user-edit text-sm"></i>
                        </div>
                        <span class="text-xs mt-2 font-medium text-primary-600">Informations</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div id="step-indicator-2"
                            class="w-8 h-8 rounded-full bg-secondary-200 text-secondary-500 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-sm"></i>
                        </div>
                        <span id="step-text-2" class="text-xs mt-2 font-medium text-secondary-500">Rendez-vous</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div id="step-indicator-3"
                            class="w-8 h-8 rounded-full bg-secondary-200 text-secondary-500 flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span id="step-text-3" class="text-xs mt-2 font-medium text-secondary-500">Confirmation</span>
                    </div>
                </div>

                @if (session('error'))
                <div id="error-message" class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 animate-fadeIn">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('patient.reserver.store') }}" id="appointment-form">
                    @csrf
                    <input type="hidden" name="doctor_id" id="doctor_id" value="1">
                    <!-- Step 1: Personal Information -->
                    <h2 class="text-xl font-semibold text-secondary-800 mb-4">Informations personnelles</h2>

                    <!-- Patient Type -->
                    <div class="bg-secondary-50 p-4 rounded-lg mb-6">
                        <label class="block text-sm font-medium text-secondary-700 mb-3">Type de patient</label>
                        <div class="flex space-x-4">
                            <div class="flex items-center">
                                <input type="radio" id="returning-patient" name="patient-type" value="returning"
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300"
                                    checked>
                                <label for="returning-patient" class="ml-2 text-sm text-secondary-700">Patient
                                    existant</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="new-patient" name="patient-type" value="new"
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300">
                                <label for="new-patient" class="ml-2 text-sm text-secondary-700">Nouveau
                                    patient</label>
                            </div>
                        </div>
                    </div>
                    <div id="step-1" class="space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="fullname" class="block text-sm font-medium text-secondary-700 mb-1">Nom
                                    complet <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-secondary-400"></i>
                                    </div>
                                    <input type="text" id="fullname" name="fullname"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" value="{{ $user['name'] }}"
                                        placeholder="Jean Dupont" required>
                                </div>
                                <div class="invalid-feedback text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Veuillez entrer votre nom complet
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="birth-date" class="block text-sm font-medium text-secondary-700 mb-1">Date
                                    de naissance <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-birthday-cake text-secondary-400"></i>
                                    </div>
                                    <input type="date" id="birth-date" name="birth-date"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" value="{{ $user['date_of_birth'] }}"
                                        required>
                                </div>
                                <div class="invalid-feedback text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Veuillez entrer votre date de naissance
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-secondary-700 mb-1">Adresse
                                    e-mail <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-secondary-400"></i>
                                    </div>
                                    <input type="email" id="email" name="email"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        value="{{ $user['email'] }}"
                                        placeholder="exemple@email.com" required>
                                </div>
                                <div class="invalid-feedback text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Veuillez entrer une adresse e-mail valide
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-secondary-700 mb-1">Numéro de
                                    téléphone <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-secondary-400"></i>
                                    </div>
                                    <input type="tel" id="phone" name="phone"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        value="{{ $user['phone'] }}"
                                        placeholder="06 12 34 56 78" 
                                        required>
                                </div>
                                <div class="invalid-feedback text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Veuillez entrer un numéro de téléphone valide
                                </div>
                            </div>
                        </div>

                        <!-- Insurance Information -->
                        <div class="border border-secondary-200 rounded-lg p-4">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" id="has-insurance" name="has-insurance"
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300">
                                <label for="has-insurance" class="ml-2 text-sm font-medium text-secondary-700">J'ai une
                                    assurance médicale</label>
                            </div>

                            <div id="insurance-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                                <div>
                                    <label for="name_assurance"
                                        class="block text-sm font-medium text-secondary-700 mb-1">Nom d'Assurance</label>
                                    <input type="text" id="name_assurance" name="name_assurance"
                                        class="block w-full px-3 py-2 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        value="{{ $patient['name_assurance'] }}"
                                        placeholder="Nom de l'assurance">
                                </div>
                                <div>
                                    <label for="assurance-number"
                                        class="block text-sm font-medium text-secondary-700 mb-1">Numéro
                                        d'Assurance</label>
                                    <input type="text" id="assurance_number" name="assurance_number"
                                        class="block w-full px-3 py-2 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        value="{{ $patient['assurance_number'] }}"
                                        placeholder="Numéro d'Assurance">
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="border border-secondary-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-secondary-700 mb-3">Contact d'urgence</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="emergency-name"
                                        class="block text-sm font-medium text-secondary-700 mb-1">Nom du contact</label>
                                    <input type="text" id="emergency-name" name="emergency-name"
                                        class="block w-full px-3 py-2 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="Nom complet">
                                </div>
                                <div>
                                    <label for="emergency-phone"
                                        class="block text-sm font-medium text-secondary-700 mb-1">Téléphone du
                                        contact</label>
                                    <input type="tel" id="emergency-phone" name="emergency-phone"
                                        class="block w-full px-3 py-2 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                         value="{{ $patient['emergency_contact'] }}"
                                        placeholder="Numéro de téléphone">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="emergency-relation"
                                        class="block text-sm font-medium text-secondary-700 mb-1">Relation</label>
                                    <select id="emergency-relation" name="emergency-relation"
                                        class="block w-full px-3 py-2 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        <option value="" selected disabled>Sélectionnez une relation</option>
                                        <option value="conjoint">Conjoint(e)</option>
                                        <option value="parent">Parent</option>
                                        <option value="enfant">Enfant</option>
                                        <option value="ami">Ami(e)</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Appointment Details (Hidden initially) -->
                    <div id="step-2" class="space-y-6 hidden">
                        <h2 class="text-xl font-semibold text-secondary-800 mb-4">Détails du rendez-vous</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Medical Specialty -->
                            <div>
                                <label for="speciality"
                                    class="block text-sm font-medium text-secondary-700 mb-1">Spécialité médicale <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-stethoscope text-secondary-400"></i>
                                    </div>
                                    <select id="speciality" name="speciality"
                                        class="block w-full pl-10 pr-10 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none"
                                        required>
                                        <option value="" selected disabled>Sélectionnez une spécialité</option>
                                        @foreach ($specialities as $speciality)
                                            <option value="{{$speciality->id}}">{{$speciality->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-secondary-400"></i>
                                    </div>
                                </div>
                                <div class="invalid-feedback text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Veuillez sélectionner une spécialité
                                </div>
                            </div>

                            <!-- Urgency Level -->
                            <div>
                                <label for="urgency" class="block text-sm font-medium text-secondary-700 mb-1">Niveau
                                    d'urgence</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-exclamation-circle text-secondary-400"></i>
                                    </div>
                                    <select id="urgency" name="urgency"
                                        class="block w-full pl-10 pr-10 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                                        <option value="normal" selected>Normal - Consultation de routine</option>
                                        <option value="soon">Dès que possible - Dans les prochains jours</option>
                                        <option value="urgent">Urgent - Besoin de consulter rapidement</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-secondary-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-secondary-700 mb-1">Date du
                                    rendez-vous <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-secondary-400"></i>
                                    </div>
                                    <input type="date" id="date" name="date"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        required min="">
                                </div>
                                <div class="invalid-feedback text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Veuillez sélectionner une date
                                </div>
                            </div>

                            <!-- Time -->
                            <div>
                                <label for="time" class="block text-sm font-medium text-secondary-700 mb-1">Heure du
                                    rendez-vous <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-secondary-400"></i>
                                    </div>
                                    <select id="time" name="time"
                                        class="block w-full pl-10 pr-10 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none"
                                        required>
                                        <option value="" selected disabled>Sélectionnez une heure</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-secondary-400"></i>
                                    </div>
                                </div>
                                <div class="invalid-feedback text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Veuillez sélectionner une heure
                                </div>
                            </div>
                        </div>

                        <!-- Reason for Visit -->
                        <div>
                            <label for="reason" class="block text-sm font-medium text-secondary-700 mb-1">Motif de la
                                consultation <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                    <i class="fas fa-comment-medical text-secondary-400"></i>
                                </div>
                                <textarea id="reason" name="reason" rows="3"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Décrivez brièvement la raison de votre visite..." required></textarea>
                            </div>
                            <div class="invalid-feedback text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Veuillez indiquer le motif de votre consultation
                            </div>
                        </div>

                        <!-- Information Notice -->
                        <div class="bg-primary-50 rounded-lg p-4 border border-primary-100">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-primary-500 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-primary-800">Attribution automatique du médecin
                                    </h3>
                                    <div class="mt-2 text-sm text-primary-700">
                                        <p>Un médecin disponible sera automatiquement assigné à votre rendez-vous en
                                            fonction de la spécialité, de la date et de l'heure choisies.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="step-3" class="space-y-6 hidden">
                        <h2 class="text-xl font-semibold text-secondary-800 mb-4">Vérification et confirmation</h2>

                        <div class="bg-secondary-50 rounded-lg p-6 border border-secondary-200">
                            <h3 class="text-lg font-medium text-secondary-800 mb-4">Récapitulatif de votre rendez-vous
                            </h3>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-secondary-500">Informations personnelles
                                        </h4>
                                        <ul class="mt-2 space-y-1">
                                            <li class="text-secondary-800" id="summary-name">Jean Dupont</li>
                                            <li class="text-secondary-800" id="summary-email">exemple@email.com</li>
                                            <li class="text-secondary-800" id="summary-phone">06 12 34 56 78</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-secondary-500">Détails du rendez-vous</h4>
                                        <ul class="mt-2 space-y-1">
                                            <li class="text-secondary-800" id="summary-specialty">Cardiologie</li>
                                            <li class="text-secondary-800" id="summary-date-time">Lundi 15 août 2023,
                                                10:30</li>
                                            <li class="text-secondary-800" id="summary-urgency">Normal - Consultation de
                                                routine</li>
                                        </ul>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-secondary-500">Motif de la consultation</h4>
                                    <p class="mt-2 text-secondary-800" id="summary-reason">Consultation de routine pour
                                        un suivi cardiaque.</p>
                                </div>

                                <div class="bg-primary-50 p-4 rounded-lg border border-primary-100">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-user-md text-primary-500 text-lg"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-primary-800">Attribution du médecin</h4>
                                            <p class="mt-1 text-sm text-primary-700">Un médecin disponible vous sera
                                                attribué automatiquement après confirmation de votre rendez-vous.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border border-secondary-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="terms-agree" name="terms-agree"
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300"
                                    required>
                                <label for="terms-agree" class="ml-2 text-sm text-secondary-700">
                                    J'accepte les <a href="#" class="text-primary-600 hover:text-primary-800">conditions
                                        d'utilisation</a> et la <a href="#"
                                        class="text-primary-600 hover:text-primary-800">politique de confidentialité</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="appointment-specialty" name="specialty">
                    <input type="hidden" id="appointment-date" name="date">
                    <input type="hidden" id="appointment-time" name="time">
                    <input type="hidden" id="appointment-reason" name="reason">

                    <div class="pt-4 border-t border-secondary-200">
                        <div class="flex justify-between">
                            <button type="button" id="prev-step"
                                class="inline-flex items-center px-4 py-2 border border-secondary-300 text-base font-medium rounded-lg shadow-sm text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors hidden">
                                <i class="fas fa-arrow-left mr-2"></i>
                                <span>Précédent</span>
                            </button>

                            <div class="ml-auto">
                                <button type="button" id="next-step"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                    <span>Continuer</span>
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                                    <button type="submit" id="submit-form" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors hidden">
                                        <span>Confirmer le rendez-vous</span>
                                        <i class="fas fa-check ml-2"></i>
                                    </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Success Message (Hidden by default) -->
            <div id="success-message"
                class="mt-8 bg-green-50 border border-green-200 rounded-xl p-6 hidden animate-fadeIn">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-green-800">Rendez-vous confirmé !</h3>
                        <div class="mt-2 text-green-700">
                            <p>Votre rendez-vous a été réservé avec succès. Vous recevrez bientôt un email de
                                confirmation avec tous les détails.</p>
                        </div>
                        <div class="mt-4">
                            <div class="bg-white rounded-lg p-4 border border-green-200">
                                <h4 class="font-medium text-secondary-800 mb-2">Récapitulatif du rendez-vous :</h4>
                                <ul class="space-y-2 text-sm text-secondary-600">
                                    <li class="flex">
                                        <i class="fas fa-user-md w-5 text-primary-500"></i>
                                        <span id="summary-doctor">Dr. Martin (Cardiologie)</span>
                                    </li>
                                    <li class="flex">
                                        <i class="fas fa-calendar-day w-5 text-primary-500"></i>
                                        <span id="summary-date">Lundi 15 août 2023</span>
                                    </li>
                                    <li class="flex">
                                        <i class="fas fa-clock w-5 text-primary-500"></i>
                                        <span id="summary-time">10:30</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                onclick="window.location.reload()">
                                Réserver un autre rendez-vous
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-secondary-200 py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-hospital text-primary-600 text-2xl mr-2"></i>
                        <span class="text-xl font-semibold text-primary-700">MediClinic</span>
                    </div>
                    <p class="text-secondary-500 text-sm">Votre santé est notre priorité. Notre équipe de professionnels
                        est là pour vous offrir les meilleurs soins médicaux.</p>
                </div>
                <div>
                    <h3 class="text-secondary-800 font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-secondary-500 hover:text-primary-600 transition-colors">Accueil</a>
                        </li>
                        <li><a href="#" class="text-secondary-500 hover:text-primary-600 transition-colors">Services</a>
                        </li>
                        <li><a href="#" class="text-secondary-500 hover:text-primary-600 transition-colors">Médecins</a>
                        </li>
                        <li><a href="#"
                                class="text-secondary-500 hover:text-primary-600 transition-colors">Rendez-vous</a></li>
                        <li><a href="#" class="text-secondary-500 hover:text-primary-600 transition-colors">Contact</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-secondary-800 font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-primary-500 mt-1 mr-2 w-4 text-center"></i>
                            <span class="text-secondary-500">123 Avenue de la Santé, 75001 Paris</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone text-primary-500 mt-1 mr-2 w-4 text-center"></i>
                            <span class="text-secondary-500">+33 1 23 45 67 89</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope text-primary-500 mt-1 mr-2 w-4 text-center"></i>
                            <span class="text-secondary-500">contact@mediclinic.fr</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-secondary-200 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-secondary-500 text-sm">© 2023 MediClinic. Tous droits réservés.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-secondary-400 hover:text-primary-600 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-secondary-400 hover:text-primary-600 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-secondary-400 hover:text-primary-600 transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-secondary-400 hover:text-primary-600 transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const doctors = {
            cardiologie: [
                { id: 1, name: "Dr. Martin", availability: ["09:00", "10:30", "14:00", "16:30"], gender: "male" },
                { id: 2, name: "Dr. Dubois", availability: ["09:30", "11:00", "14:30", "15:30"], gender: "male" },
                { id: 3, name: "Dr. Leroy", availability: ["10:00", "11:30", "15:00", "16:00"], gender: "female" }
            ],
            dermatologie: [
                { id: 4, name: "Dr. Bernard", availability: ["09:00", "11:00", "14:00", "16:00"], gender: "male" },
                { id: 5, name: "Dr. Thomas", availability: ["09:30", "10:30", "14:30", "15:30"], gender: "female" }
            ],
            pediatrie: [
                { id: 6, name: "Dr. Petit", availability: ["09:00", "10:00", "14:00", "15:00"], gender: "female" },
                { id: 7, name: "Dr. Robert", availability: ["10:30", "11:30", "15:30", "16:30"], gender: "male" }
            ],
            ophtalmologie: [
                { id: 8, name: "Dr. Richard", availability: ["09:00", "10:00", "14:00", "15:00"], gender: "male" },
                { id: 9, name: "Dr. Moreau", availability: ["10:30", "11:30", "15:30", "16:30"], gender: "female" }
            ],
            neurologie: [
                { id: 10, name: "Dr. Simon", availability: ["09:30", "11:00", "14:30", "16:00"], gender: "male" },
                { id: 11, name: "Dr. Laurent", availability: ["10:00", "11:30", "15:00", "16:30"], gender: "female" }
            ]
        };

        const userData = {
            fullname: "Marie Dupont",
            email: "marie.dupont@example.com",
            phone: "0612345678",
            birthDate: "1985-06-15",
            contactMethod: "email",
            hasInsurance: true,
            insuranceProvider: "Assurance Santé Plus",
            insuranceNumber: "ASP123456789",
            emergencyContact: {
                name: "Pierre Dupont",
                phone: "0687654321",
                relation: "conjoint"
            },
            preferredSpecialty: "cardiologie",
            preferredGender: "female",
            accessibility: ["wheelchair"]
        };

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('appointment-form');
            const specialtySelect = document.getElementById('speciality');
            const timeSelect = document.getElementById('time');
            const dateInput = document.getElementById('date');
            const successMessage = document.getElementById('success-message');
            const hasInsuranceCheckbox = document.getElementById('has-insurance');
            const insuranceFields = document.getElementById('insurance-fields');
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const step3 = document.getElementById('step-3');
            const nextStepBtn = document.getElementById('next-step');
            const prevStepBtn = document.getElementById('prev-step');
            const submitFormBtn = document.getElementById('submit-form');
            const userStatusLabel = document.getElementById('user-status-label');
            const authButtons = document.getElementById('auth-buttons');
            const userProfile = document.getElementById('user-profile');
            const userWelcome = document.getElementById('user-welcome');
            const guestBanner = document.getElementById('guest-banner');
            const saveInfoSection = document.getElementById('save-info-section');
            const profileDropdownButton = document.getElementById('profile-dropdown-button');
            const profileDropdown = document.getElementById('profile-dropdown');
            const logoutButton = document.getElementById('logout-button');
            const stepIndicator1 = document.getElementById('step-indicator-1');
            const stepIndicator2 = document.getElementById('step-indicator-2');
            const stepIndicator3 = document.getElementById('step-indicator-3');
            const stepText2 = document.getElementById('step-text-2');
            const stepText3 = document.getElementById('step-text-3');
            let currentStep = 1;
            let isLoggedIn = true;
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            dateInput.min = formattedDate;

            hasInsuranceCheckbox.addEventListener('change', function () {
                insuranceFields.classList.toggle('hidden', !this.checked);
            });

            specialtySelect.addEventListener('change', function () {
                const specialty = this.value;
                updateAvailableTimes(specialty);
            });

            nextStepBtn.addEventListener('click', function () {
                if (currentStep === 1) {
                    if (validateStep1()) {
                        showStep(2);
                    }
                } else if (currentStep === 2) {
                    if (validateStep2()) {
                        updateSummary();
                        showStep(3);
                    }
                }
            });

            prevStepBtn.addEventListener('click', function () {
                if (currentStep === 2) {
                    showStep(1);
                } else if (currentStep === 3) {
                    showStep(2);
                }
            });

            form.addEventListener('submit', function (e) {
                if (validateForm()) {
                    document.getElementById('appointment-specialty').value = specialtySelect.value;
                    document.getElementById('appointment-date').value = dateInput.value;
                    document.getElementById('appointment-time').value = timeSelect.value;
                    document.getElementById('appointment-reason').value = document.getElementById('reason').value;
                    
                    return true;
                } else {
                    e.preventDefault();
                    return false;
                }
            });

            profileDropdownButton.addEventListener('click', function () {
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!profileDropdownButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            function prefillFormWithUserData() {
                document.getElementById('fullname').value = userData.fullname;
                document.getElementById('email').value = userData.email;
                document.getElementById('phone').value = userData.phone;
                document.getElementById('birth-date').value = userData.birthDate;
                document.querySelector(`input[name="contact-method"][value="${userData.contactMethod}"]`).checked = true;


                hasInsuranceCheckbox.checked = userData.hasInsurance;
                if (userData.hasInsurance) {
                    insuranceFields.classList.remove('hidden');
                    document.getElementById('name_assurance').value = userData.insuranceProvider;
                    document.getElementById('assurance_number').value = userData.insuranceNumber;
                }
                document.getElementById('emergency-name').value = userData.emergencyContact.name;
                document.getElementById('emergency-phone').value = userData.emergencyContact.phone;
                document.getElementById('emergency-relation').value = userData.emergencyContact.relation;

                if (userData.preferredSpecialty) {
                    document.getElementById('speciality').value = userData.preferredSpecialty;
                    updateAvailableTimes(userData.preferredSpecialty);
                }

                if (userData.preferredGender) {
                    document.querySelector(`input[name="doctor-gender"][value="${userData.preferredGender}"]`).checked = true;
                }

                if (userData.accessibility) {
                    userData.accessibility.forEach(need => {
                        document.getElementById(need).checked = true;
                    });
                }
            }

            function resetForm() {
                form.reset();
                insuranceFields.classList.add('hidden');
            }

            function showStep(step) {
                step1.classList.add('hidden');
                step2.classList.add('hidden');
                step3.classList.add('hidden');

                if (step === 1) {
                    step1.classList.remove('hidden');
                    prevStepBtn.classList.add('hidden');
                    nextStepBtn.classList.remove('hidden');
                    submitFormBtn.classList.add('hidden');

                    updateStepIndicators(1);
                } else if (step === 2) {
                    step2.classList.remove('hidden');
                    prevStepBtn.classList.remove('hidden');
                    nextStepBtn.classList.remove('hidden');
                    submitFormBtn.classList.add('hidden');

                    updateStepIndicators(2);
                } else if (step === 3) {
                    step3.classList.remove('hidden');
                    prevStepBtn.classList.remove('hidden');
                    nextStepBtn.classList.add('hidden');
                    submitFormBtn.classList.remove('hidden');

                    updateStepIndicators(3);
                }

                currentStep = step;
            }

            function updateStepIndicators(step) {
                stepIndicator1.className = "w-8 h-8 rounded-full bg-secondary-200 text-secondary-500 flex items-center justify-center";
                stepIndicator2.className = "w-8 h-8 rounded-full bg-secondary-200 text-secondary-500 flex items-center justify-center";
                stepIndicator3.className = "w-8 h-8 rounded-full bg-secondary-200 text-secondary-500 flex items-center justify-center";

                stepText2.className = "text-xs mt-2 font-medium text-secondary-500";
                stepText3.className = "text-xs mt-2 font-medium text-secondary-500";

                if (step >= 1) {
                    stepIndicator1.className = "w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center";
                }

                if (step >= 2) {
                    stepIndicator2.className = "w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center";
                    stepText2.className = "text-xs mt-2 font-medium text-primary-600";
                }

                if (step >= 3) {
                    stepIndicator3.className = "w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center";
                    stepText3.className = "text-xs mt-2 font-medium text-primary-600";
                }
            }

            function validateStep1() {
                const requiredFields = step1.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                return isValid;
            }

            function validateStep2() {
                const requiredFields = step2.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                return isValid;
            }

            function updateAvailableTimes(specialty) {
                resetTimeOptions();

                if (doctors[specialty]) {
                    const availableTimesSet = new Set();
                    const availableTimes = Array.from(availableTimesSet);

                    doctors[specialty].forEach(doctor => {
                        doctor.availability.forEach(time => {
                            availableTimesSet.add(time);
                        });
                    });


                    Array.from(timeSelect.options).forEach(option => {
                        if (option.value && !availableTimes.includes(option.value)) {
                            option.disabled = true;
                            option.textContent = option.value + ' (indisponible)';
                        }
                    });
                }
            }

            function resetTimeOptions() {
                Array.from(timeSelect.options).forEach(option => {
                    if (option.value) {
                        option.disabled = false;
                        option.textContent = option.value;
                    }
                });
            }

            function validateForm() {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                return isValid;
            }

            function updateSummary() {
                const fullName = document.getElementById('fullname').value;
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;
                const specialty = specialtySelect.options[specialtySelect.selectedIndex].text;
                const selectedDate = new Date(dateInput.value);
                const selectedTime = timeSelect.value;
                const urgency = document.getElementById('urgency').options[document.getElementById('urgency').selectedIndex].text;
                const reason = document.getElementById('reason').value;

                const formattedDate = selectedDate.toLocaleDateString('fr-FR', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                document.getElementById('summary-name').textContent = fullName;
                document.getElementById('summary-email').textContent = email;
                document.getElementById('summary-phone').textContent = phone;
                document.getElementById('summary-specialty').textContent = specialty;
                document.getElementById('summary-date-time').textContent = `${formattedDate}, ${selectedTime}`;
                document.getElementById('summary-urgency').textContent = urgency;
                document.getElementById('summary-reason').textContent = reason || "Aucun motif spécifié";
            }

            function findAvailableDoctor(specialty, selectedTime, genderPreference) {
                if (!doctors[specialty]) {
                    return null;
                }

                let availableDoctors = doctors[specialty].filter(doctor =>
                    doctor.availability.includes(selectedTime)
                );

                if (genderPreference !== 'no-preference') {
                    const doctorsWithPreferredGender = availableDoctors.filter(doctor =>
                        doctor.gender === genderPreference
                    );

                    if (doctorsWithPreferredGender.length > 0) {
                        availableDoctors = doctorsWithPreferredGender;
                    }
                }

                if (availableDoctors.length === 0) {
                    return null;
                }

                const randomIndex = Math.floor(Math.random() * availableDoctors.length);
                return availableDoctors[randomIndex];
            }

            function simulateFormSubmission() {
                const specialty = specialtySelect.value;
                const selectedTime = timeSelect.value;
                const genderPreference = document.querySelector('input[name="doctor-gender"]:checked').value;
                const assignedDoctor = findAvailableDoctor(specialty, selectedTime, genderPreference);

                if (!assignedDoctor) {
                    alert("Désolé, aucun médecin n'est disponible à cette heure. Veuillez choisir un autre horaire.");
                    return;
                }

                const submitButton = submitFormBtn;
                const originalButtonText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement en cours...';
                submitButton.disabled = true;

                setTimeout(() => {
                    form.parentElement.classList.add('hidden');
                    updateFinalSummary(assignedDoctor, specialty);
                    successMessage.classList.remove('hidden');
                    successMessage.scrollIntoView({ behavior: 'smooth' });
                    submitButton.innerHTML = originalButtonText;
                    submitButton.disabled = false;
                }, 1500);
            }

            function updateFinalSummary(doctor, specialty) {
                const specialtyName = specialtySelect.options[specialtySelect.selectedIndex].text;
                const selectedDate = new Date(dateInput.value);
                const selectedTime = timeSelect.value;
                const formattedDate = selectedDate.toLocaleDateString('fr-FR', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                document.getElementById('summary-doctor').textContent = `${doctor.name} (${specialtyName})`;
                document.getElementById('summary-date').textContent = formattedDate;
                document.getElementById('summary-time').textContent = selectedTime;
            }
            updateUserInterface();
        });
    </script>
</body>

</html>