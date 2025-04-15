<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du rendez-vous | MediClinic</title>
    
    <!-- TailwindCSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Configuration Tailwind personnalisée -->
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
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'bounce-slow': 'bounce 2s infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(-10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                color: black;
                background: white;
                font-size: 12pt;
            }
            .print-container {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 to-secondary-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm py-4 no-print">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-hospital text-primary-600 text-2xl mr-2"></i>
                <span class="text-xl font-semibold text-primary-700">MediClinic</span>
            </div>
            <nav class="hidden md:flex space-x-6">
                <a href="#" class="text-secondary-600 hover:text-primary-600 transition-colors">Accueil</a>
                <a href="#" class="text-secondary-600 hover:text-primary-600 transition-colors">Services</a>
                <a href="#" class="text-secondary-600 hover:text-primary-600 transition-colors">Médecins</a>
                <a href="#" class="text-primary-600 font-medium">Rendez-vous</a>
                <a href="#" class="text-secondary-600 hover:text-primary-600 transition-colors">Contact</a>
            </nav>
            
            <button class="md:hidden text-secondary-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            @if(request()->has('success') && request()->success === 'true')
            <!-- Success Banner -->
            <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-6 rounded-lg animate-fade-in no-print">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700 font-medium">Votre rendez-vous a été réservé et payé avec succès !</p>
                        <p class="text-green-600 text-sm mt-1">Vous recevrez une confirmation par email sous peu.</p>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Page Title -->
            <div class="text-center mb-8 no-print">
                <h1 class="text-3xl font-bold text-secondary-800 mb-2">Détails de votre rendez-vous</h1>
                <p class="text-secondary-500">Retrouvez toutes les informations concernant votre consultation médicale</p>
            </div>
            
            <!-- Appointment Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden print-container">
                <!-- Card Header -->
                <div class="bg-primary-600 py-4 px-6 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Rendez-vous médical
                    </h2>
                    <div class="flex space-x-2 no-print">
                        <button onclick="window.print()" class="text-white bg-primary-700 hover:bg-primary-800 rounded-lg p-2 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-1 focus:ring-offset-primary-600" title="Imprimer">
                            <i class="fas fa-print"></i>
                        </button>
                        <button id="shareButton" class="text-white bg-primary-700 hover:bg-primary-800 rounded-lg p-2 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-1 focus:ring-offset-primary-600" title="Partager">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Card Body -->
                <div class="p-6 md:p-8">
                    <!-- Appointment Status -->
                    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                            @if($appointment->status === 'confirmed') bg-green-100 text-green-700 
                            @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($appointment->status === 'canceled') bg-red-100 text-red-700 
                            @else bg-blue-100 text-blue-700 @endif">
                                @if($appointment->status === 'confirmed') Confirmé
                                @elseif($appointment->status === 'pending') En attente
                                @elseif($appointment->status === 'canceled') Annulé
                                @else Terminé @endif
                            </span>
                            <span class="ml-2 text-secondary-500">ID: #{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="text-secondary-500 text-sm">
                            <span>Réservé le {{ \Carbon\Carbon::parse($appointment->created_at)->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                    
                    <!-- Appointment Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-b border-secondary-200 pb-8">
                        <!-- Doctor Info -->
                        <div>
                            <h3 class="text-lg font-semibold text-secondary-800 mb-4">Médecin</h3>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                        <i class="fas fa-user-md text-2xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium text-secondary-800">Dr. {{ $appointment->doctor->user->name ?? 'Non assigné' }}</h4>
                                    <p class="text-secondary-600">{{ $appointment->doctor->speciality->name ?? 'Spécialité non spécifiée' }}</p>
                                    <div class="mt-2 text-sm text-secondary-500">
                                        @if(isset($appointment->doctor->address))
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-map-marker-alt w-4"></i>
                                            <span class="ml-2">{{ $appointment->doctor->address }}</span>
                                        </div>
                                        @endif
                                        @if(isset($appointment->doctor->phone))
                                        <div class="flex items-center">
                                            <i class="fas fa-phone w-4"></i>
                                            <span class="ml-2">{{ $appointment->doctor->phone }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Patient Info -->
                        <div>
                            <h3 class="text-lg font-semibold text-secondary-800 mb-4">Patient</h3>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-600">
                                        <i class="fas fa-user text-2xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium text-secondary-800">{{ $appointment->patient->user->name ?? 'Non spécifié' }}</h4>
                                    <p class="text-secondary-600">{{ $appointment->patient->user->email ?? 'Email non spécifié' }}</p>
                                    <div class="mt-2 text-sm text-secondary-500">
                                        @if(isset($appointment->patient->birthdate))
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-birthday-cake w-4"></i>
                                            <span class="ml-2">{{ \Carbon\Carbon::parse($appointment->patient->birthdate)->format('d/m/Y') }}</span>
                                        </div>
                                        @endif
                                        @if(isset($appointment->patient->phone))
                                        <div class="flex items-center">
                                            <i class="fas fa-phone w-4"></i>
                                            <span class="ml-2">{{ $appointment->patient->phone }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Appointment Details -->
                    <div class="mb-8 border-b border-secondary-200 pb-8">
                        <h3 class="text-lg font-semibold text-secondary-800 mb-4">Informations du rendez-vous</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-secondary-50 rounded-lg p-4">
                                <div class="flex items-center text-secondary-800">
                                    <i class="fas fa-calendar-day text-primary-600 w-5"></i>
                                    <span class="ml-2 font-medium">Date</span>
                                </div>
                                <p class="mt-2 pl-7 text-secondary-600">
                                    {{ \Carbon\Carbon::parse($appointment->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                                </p>
                            </div>
                            
                            <div class="bg-secondary-50 rounded-lg p-4">
                                <div class="flex items-center text-secondary-800">
                                    <i class="fas fa-clock text-primary-600 w-5"></i>
                                    <span class="ml-2 font-medium">Heure</span>
                                </div>
                                <p class="mt-2 pl-7 text-secondary-600">
                                    {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                </p>
                            </div>
                            
                            @if(isset($appointment->reason))
                            <div class="bg-secondary-50 rounded-lg p-4 md:col-span-2">
                                <div class="flex items-center text-secondary-800">
                                    <i class="fas fa-comment-medical text-primary-600 w-5"></i>
                                    <span class="ml-2 font-medium">Motif de la consultation</span>
                                </div>
                                <p class="mt-2 pl-7 text-secondary-600">
                                    {{ $appointment->reason }}
                                </p>
                            </div>
                            @endif
                            
                            @if(isset($appointment->urgency))
                            <div class="bg-secondary-50 rounded-lg p-4">
                                <div class="flex items-center text-secondary-800">
                                    <i class="fas fa-exclamation-circle text-primary-600 w-5"></i>
                                    <span class="ml-2 font-medium">Niveau d'urgence</span>
                                </div>
                                <p class="mt-2 pl-7 text-secondary-600">
                                    @if($appointment->urgency === 'normal') Normal - Consultation de routine
                                    @elseif($appointment->urgency === 'soon') Dès que possible - Dans les prochains jours
                                    @elseif($appointment->urgency === 'urgent') Urgent - Besoin de consulter rapidement
                                    @else {{ $appointment->urgency }} @endif
                                </p>
                            </div>
                            @endif
                            
                            @if(isset($payment))
                            <div class="bg-secondary-50 rounded-lg p-4">
                                <div class="flex items-center text-secondary-800">
                                    <i class="fas fa-credit-card text-primary-600 w-5"></i>
                                    <span class="ml-2 font-medium">Paiement</span>
                                </div>
                                <p class="mt-2 pl-7 text-secondary-600">
                                    <span class="font-medium">{{ number_format($payment->amount, 2, ',', ' ') }} €</span> 
                                    - Payé le {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y à H:i') }}
                                </p>
                                <p class="mt-1 pl-7 text-xs text-secondary-500">
                                    Transaction: {{ $payment->transaction_id }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Important Information -->
                    <div class="mb-8 border-b border-secondary-200 pb-8">
                        <h3 class="text-lg font-semibold text-secondary-800 mb-4">Informations importantes</h3>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">Préparation pour votre consultation</h4>
                                    <ul class="mt-2 text-sm text-blue-700 space-y-1 list-disc list-inside">
                                        <li>Veuillez apporter votre carte d'identité et votre carte vitale</li>
                                        <li>Apportez vos documents médicaux pertinents (ordonnances, résultats d'analyses, etc.)</li>
                                        <li>Arrivez 15 minutes avant l'heure de votre rendez-vous</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="no-print">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                            <button id="cancelAppointment" class="flex items-center justify-center px-4 py-2 border border-red-300 text-red-600 bg-white hover:bg-red-50 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-times-circle mr-2"></i>
                                Annuler le rendez-vous
                            </button>
                            <div class="flex space-x-3">
                                <a href="{{ route('patient.reserver') }}" class="flex items-center justify-center px-4 py-2 border border-secondary-300 text-secondary-700 bg-white hover:bg-secondary-50 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500">
                                    <i class="fas fa-calendar-plus mr-2"></i>
                                    Nouveau rendez-vous
                                </a>
                                <a href="{{ route('home') }}" class="flex items-center justify-center px-4 py-2 border border-primary-600 bg-primary-600 text-white hover:bg-primary-700 hover:border-primary-700 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <i class="fas fa-home mr-2"></i>
                                    Accueil
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- QR Code -->
                    <div class="mt-8 text-center no-print">
                        <p class="text-secondary-500 text-sm mb-3">Scanner ce QR code pour accéder rapidement à votre rendez-vous</p>
                        <div class="inline-block bg-white p-2 rounded-lg shadow-sm">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('appointment.details', ['appointment_id' => $appointment->id])) }}" alt="QR Code" class="w-32 h-32 mx-auto">
                        </div>
                    </div>
                </div>
                
                <!-- Card Footer -->
                <div class="bg-secondary-50 py-4 px-6 text-center text-sm text-secondary-500">
                    <p>Pour toute question ou modification, veuillez nous contacter au <span class="font-medium">01 23 45 67 89</span></p>
                </div>
            </div>
            
            <!-- Reminder -->
            <div class="mt-6 bg-primary-50 rounded-lg p-6 border border-primary-100 animate-fade-in no-print">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-bell text-primary-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-primary-800">Rappel automatique</h3>
                        <p class="mt-1 text-primary-600">Nous vous enverrons un rappel 24 heures avant votre rendez-vous par email et SMS.</p>
                        <div class="mt-3">
                            <button class="inline-flex items-center px-3 py-1.5 text-sm border border-primary-300 text-primary-700 bg-primary-50 hover:bg-primary-100 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <i class="fas fa-cog mr-2"></i>
                                Gérer mes notifications
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-secondary-200 py-6 mt-8 no-print">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <i class="fas fa-hospital text-primary-600 text-xl mr-2"></i>
                    <span class="text-lg font-semibold text-primary-700">MediClinic</span>
                </div>
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
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Cancel Appointment Modal (hidden by default) -->
    <div id="cancelModal" class="fixed inset-0 bg-secondary-900 bg-opacity-50 flex items-center justify-center z-50 hidden no-print">
        <div class="bg-white rounded-xl p-8 max-w-md w-full animate-fade-in">
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 text-red-500 mb-4">
                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-secondary-800 mb-2">Annuler ce rendez-vous ?</h3>
                <p class="text-secondary-600">Êtes-vous sûr de vouloir annuler ce rendez-vous ? Cette action est irréversible.</p>
            </div>
            
            <div class="bg-secondary-50 rounded-lg p-4 mb-6">
                <div class="flex items-center text-secondary-800 mb-2">
                    <i class="fas fa-calendar-day text-primary-600 w-5"></i>
                    <span class="ml-2">{{ \Carbon\Carbon::parse($appointment->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</span>
                </div>
                <div class="flex items-center text-secondary-800">
                    <i class="fas fa-clock text-primary-600 w-5"></i>
                    <span class="ml-2">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</span>
                </div>
            </div>
            
            <form action="{{ route('appointment.cancel', ['appointment_id' => $appointment->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="text-center space-y-3">
                    <button type="submit" class="w-full px-4 py-2 border border-red-600 text-white bg-red-600 hover:bg-red-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Confirmer l'annulation
                    </button>
                    <button type="button" id="cancelModalClose" class="w-full px-4 py-2 border border-secondary-300 text-secondary-700 bg-white hover:bg-secondary-50 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Retour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal d'annulation du rendez-vous
            const cancelButton = document.getElementById('cancelAppointment');
            const cancelModal = document.getElementById('cancelModal');
            const cancelModalClose = document.getElementById('cancelModalClose');
            
            if(cancelButton && cancelModal && cancelModalClose) {
                cancelButton.addEventListener('click', function() {
                    cancelModal.classList.remove('hidden');
                });
                
                cancelModalClose.addEventListener('click', function() {
                    cancelModal.classList.add('hidden');
                });
                
                // Fermer le modal si on clique en dehors
                cancelModal.addEventListener('click', function(e) {
                    if (e.target === cancelModal) {
                        cancelModal.classList.add('hidden');
                    }
                });
            }
            
            // Partage du rendez-vous (si l'API Web Share est disponible)
            const shareButton = document.getElementById('shareButton');
            
            if(shareButton && navigator.share) {
                shareButton.addEventListener('click', async function() {
                    try {
                        await navigator.share({
                            title: 'Mon rendez-vous médical',
                            text: 'Voici les détails de mon rendez-vous médical chez MediClinic',
                            url: window.location.href
                        });
                    } catch (error) {
                        console.error('Erreur de partage:', error);
                    }
                });
            } else if(shareButton) {
                // Fallback si l'API Web Share n'est pas supportée
                shareButton.addEventListener('click', function() {
                    const tempInput = document.createElement('input');
                    tempInput.value = window.location.href;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    
                    alert('Lien copié dans le presse-papier !');
                });
            }
        });
    </script>
</body>
</html>