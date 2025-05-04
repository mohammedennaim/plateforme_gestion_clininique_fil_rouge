<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paiement Sécurisé</title>
    
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
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
    
    <style>
        /* Styles pour les éléments Stripe */
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            background-color: white;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 0 0 2px #0ea5e9;
            border-color: #0ea5e9;
        }

        .StripeElement--invalid {
            border-color: #ef4444;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
        
        /* Animation pour les modales */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        .modal-backdrop {
            transition: opacity 0.3s ease;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 to-secondary-50 min-h-screen flex flex-col">
    @if (auth()->check())
        <header class="bg-white shadow-sm py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-hospital text-primary-600 text-2xl mr-2"></i>
                    <span class="text-xl font-semibold text-primary-700">MediClinic</span>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('welcome') }}" class="text-primary-600 font-medium">Accueil</a>
                    <a href="{{ route('services') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Services</a>
                    <a href="{{ route('doctors') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Médecins</a>
                    <a href="{{ route('patient.reservation') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Rendez-vous</a>
                    <a href="{{ route('contact') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Contact</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <div id="user-profile" class="items-center">
                        <div class="relative">
                            <button id="profile-dropdown-button" class="flex items-center space-x-2 focus:outline-none">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <span class="text-sm font-medium text-secondary-700">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-secondary-400 text-xs"></i>
                            </button>

                            <div id="profile-dropdown"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                    <i class="fas fa-user mr-2 text-secondary-400"></i>Mon profil
                                </a>
                                <a href="{{ route('appointments') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                    <i class="fas fa-calendar-check mr-2 text-secondary-400"></i>Mes rendez-vous
                                </a>
                                <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                    <i class="fas fa-cog mr-2 text-secondary-400"></i>Paramètres
                                </a>
                                <div class="border-t border-secondary-200 my-1"></div>

                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" id="logout-button"
                                        class="block px-4 py-2 text-sm text-red-600 hover:bg-secondary-50 w-full text-left">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @else
        <header class="bg-white shadow-sm py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-hospital text-primary-600 text-2xl mr-2"></i>
                    <span class="text-xl font-semibold text-primary-700">MediClinic</span>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('welcome') }}" class="text-primary-600 font-medium">Accueil</a>
                    <a href="{{ route('services') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Services</a>
                    <a href="{{ route('doctors') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Médecins</a>
                    <a href="{{ route('patient.reserver.store') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Rendez-vous</a>
                    <a href="{{ route('contact') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Contact</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <div id="auth-buttons" class="flex items-center">
                        <a href="{{ route('login') }}" id="login-button"
                            class="text-sm font-medium text-primary-600 hover:text-primary-800">Se connecter</a>
                        <span class="mx-2 text-secondary-300">|</span>
                        <a href="{{ route('register') }}"
                            class="text-sm font-medium text-primary-600 hover:text-primary-800">S'inscrire</a>
                    </div>
                </div>
            </div>
        </header>
    @endif


    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-secondary-800 mb-2">Paiement Sécurisé</h1>
                <p class="text-secondary-500">Finalisez votre réservation en effectuant le paiement</p>
            </div>

            <div class="flex justify-between mb-8 relative">
                <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-secondary-200 -translate-y-1/2 z-0"></div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-xs mt-2 font-medium text-primary-600">Informations</span>
                </div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-xs mt-2 font-medium text-primary-600">Rendez-vous</span>
                </div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-xs mt-2 font-medium text-primary-600">Confirmation</span>
                </div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center">
                        <i class="fas fa-credit-card text-sm"></i>
                    </div>
                    <span class="text-xs mt-2 font-medium text-primary-600">Paiement</span>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-primary-600 py-4 px-6">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-lock mr-2"></i>
                        Paiement Sécurisé
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="mb-6 bg-secondary-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-secondary-700 mb-3">Récapitulatif</h3>
                        <div class="flex justify-between mb-2">
                            <span class="text-secondary-600">Consultation</span>
                            <span class="text-secondary-800 font-medium">220,00 MAD</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-secondary-600">Frais de dossier</span>
                            <span class="text-secondary-800 font-medium">30,00 MAD</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-secondary-200">
                            <span class="text-secondary-800 font-medium">Total</span>
                            <span class="text-secondary-800 font-medium">250,00 MAD</span>
                        </div>
                    </div>
                    
                    <!-- Formulaire de paiement -->
                    <form id="payment-form" action="{{ route('payment.process') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="cardholder-name" class="block text-sm font-medium text-secondary-700 mb-1">Nom du titulaire <span class="text-red-500">*</span></label>
                            <input type="text" id="cardholder-name" name="cardholder_name" class="block w-full px-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Nom complet" required>
                        </div>
                     
                        <div>
                            <label for="billing-address" class="block text-sm font-medium text-secondary-700 mb-1">Adresse <span class="text-red-500">*</span></label>
                            <input type="text" id="billing-address" name="billing_address" class="block w-full px-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Numéro et rue" required>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="billing-city" class="block text-sm font-medium text-secondary-700 mb-1">Ville <span class="text-red-500">*</span></label>
                                <input type="text" id="billing-city" name="billing_city" class="block w-full px-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ville" required>
                            </div>
                            <div>
                                <label for="billing-postal" class="block text-sm font-medium text-secondary-700 mb-1">Code postal <span class="text-red-500">*</span></label>
                                <input type="text" id="billing-postal" name="billing_postal" class="block w-full px-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Code postal" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="billing-country" class="block text-sm font-medium text-secondary-700 mb-1">Pays <span class="text-red-500">*</span></label>
                            <select id="billing-country" name="billing_country" class="block w-full px-3 py-2.5 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                <option value="MA" selected>Maroc</option>
                                <option value="FR">France</option>
                                <option value="BE">Belgique</option>
                                <option value="CH">Suisse</option>
                                <option value="CA">Canada</option>
                                <option value="TN">Tunisie</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="card-element" class="block text-sm font-medium text-secondary-700 mb-1">Carte de crédit <span class="text-red-500">*</span></label>
                            <div id="card-element" class="p-3 border border-secondary-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <!-- Stripe Card Element will be inserted here -->
                            </div>
                            <div id="card-errors" class="text-red-500 text-sm mt-1" role="alert"></div>
                        </div>
                        
                        <!-- Options supplémentaires -->
                        <div class="flex items-center">
                            <input type="checkbox" id="save-payment" name="save_payment" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded">
                            <label for="save-payment" class="ml-2 text-sm text-secondary-700">Sauvegarder ces informations pour mes prochains paiements</label>
                        </div>
                        
                        <!-- Bouton de paiement -->
                        <div class="pt-4 border-t border-secondary-200">
                            <button type="submit" id="submit-payment" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                <span>Payer 250,00 MAD</span>
                                <i class="fas fa-lock ml-2"></i>
                            </button>
                            <p class="text-xs text-center text-secondary-500 mt-2">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Paiement sécurisé via Stripe. Vos données sont chiffrées.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Retour à la réservation -->
            <div class="mt-6 text-center">
                <a href="{{ route('patient.reserver.store') }}" class="text-sm text-primary-600 hover:text-primary-800 inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la réservation
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-secondary-200 py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <i class="fas fa-hospital text-primary-600 text-xl mr-2"></i>
                    <span class="text-lg font-semibold text-primary-700">MediClinic</span>
                </div>
                <p class="text-secondary-500 text-sm">© 2025 MediClinic. Tous droits réservés.</p>
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

    <!-- Modal de traitement du paiement (Hidden by default) -->
    <div id="payment-processing-modal" class="fixed inset-0 bg-secondary-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-8 max-w-md w-full text-center animate-fadeIn">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-600 mx-auto mb-4"></div>
            <h3 class="text-lg font-medium text-secondary-800 mb-2">Traitement en cours...</h3>
            <p class="text-secondary-600">Veuillez patienter pendant que nous traitons votre paiement.</p>
        </div>
    </div>
    
    <!-- Modal de paiement réussi (Hidden by default) -->
    <div id="payment-success-modal" class="fixed inset-0 bg-secondary-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-8 max-w-md w-full animate-fadeIn">
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-4">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-secondary-800 mb-2">Paiement réussi !</h3>
                <p class="text-secondary-600">Votre paiement a été traité avec succès.</p>
            </div>
            
            <div class="bg-secondary-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-secondary-600">Numéro de transaction :</span>
                    <span class="text-secondary-800 font-medium" id="transaction-id">TRX-12345678</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-secondary-600">Montant payé :</span>
                    <span class="text-secondary-800 font-medium">250,00 MAD</span>
                </div>
            </div>
            
            <div class="text-center space-y-3">
                <a href="{{ route('appointment.details', $appointmentId) }}" id="view-appointment" class="block w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Voir mon rendez-vous
                </a>
                <a href="{{ route('welcome') }}" class="block w-full px-4 py-2 border border-secondary-300 text-sm font-medium rounded-md text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
    
    <div id="payment-error-modal" class="fixed inset-0 bg-secondary-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-8 max-w-md w-full animate-fadeIn">
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 text-red-500 mb-4">
                    <i class="fas fa-exclamation-circle text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-secondary-800 mb-2">Erreur de paiement</h3>
                <p class="text-secondary-600" id="error-message">Une erreur est survenue lors du traitement de votre paiement.</p>
            </div>
            
            <div class="text-center space-y-3">
                <button id="retry-payment" class="block w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Réessayer
                </button>
                <a href="{{ route('patient.reserver.store') }}" class="block w-full px-4 py-2 border border-secondary-300 text-sm font-medium rounded-md text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Annuler
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Gestion du dropdown de profil
        const profileDropdownButton = document.getElementById('profile-dropdown-button');
        const profileDropdown = document.getElementById('profile-dropdown');
        
        if (profileDropdownButton && profileDropdown) {
            profileDropdownButton.addEventListener('click', function () {
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!profileDropdownButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser Stripe avec votre clé publique
            const stripe = Stripe('{{ config("services.stripe.key") }}');
            const elements = stripe.elements();
            let paymentCheckInterval; 
            
            // Créer les éléments Stripe
            const style = {
                base: {
                    color: '#1e293b',
                    fontFamily: '"Inter", sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#94a3b8'
                    }
                },
                invalid: {
                    color: '#ef4444',
                    iconColor: '#ef4444'
                }
            };
            
            // Créer l'élément de carte
            const card = elements.create('card', { style: style });
            card.mount('#card-element');
            
            // Gérer les erreurs de validation de la carte
            card.addEventListener('change', function(event) {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            
            // Gérer la soumission du formulaire
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                
                // Désactiver le bouton de paiement pour éviter les soumissions multiples
                const submitButton = document.getElementById('submit-payment');
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement en cours...';
                
                // Afficher le modal de traitement du paiement
                const processingModal = document.getElementById('payment-processing-modal');
                processingModal.classList.remove('hidden');
                
                // Récupérer les informations du titulaire de la carte
                const cardholderName = document.getElementById('cardholder-name').value;
                
                try {
                    // Créer un payment method
                    const { paymentMethod, error } = await stripe.createPaymentMethod({
                        type: 'card',
                        card: card,
                        billing_details: {
                            name: cardholderName,
                            address: {
                                line1: document.getElementById('billing-address').value,
                                city: document.getElementById('billing-city').value,
                                postal_code: document.getElementById('billing-postal').value,
                                country: document.getElementById('billing-country').value
                            }
                        }
                    });
                    
                    if (error) {
                        handlePaymentError(error.message);
                    } else {
                        const response = await fetch('{{ route("payment.process") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: JSON.stringify({
                                payment_method_id: paymentMethod.id,
                                amount: 250, 
                                currency: 'MAD',
                                description: 'Paiement consultation médicale',
                                appointment_id: '{{ request()->query("appointment_id") ?? "" }}' 
                            })
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            // Paiement réussi immédiatement
                            processingModal.classList.add('hidden');
                            
                            // Afficher l'ID de transaction dans le modal de succès
                            document.getElementById('transaction-id').textContent = result.transaction_id;
                            
                            // Afficher le modal de succès
                            const successModal = document.getElementById('payment-success-modal');
                            successModal.classList.remove('hidden');
                        } else if (result.requires_action) {
                            // Une authentification supplémentaire est requise
                            const { error, paymentIntent } = await stripe.handleCardAction(
                                result.payment_intent_client_secret
                            );
                            
                            if (error) {
                                handlePaymentError(error.message);
                            } else {
                                // L'authentification est réussie, confirmer le paiement
                                const confirmResponse = await fetch('{{ route("payment.confirm") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    },
                                    body: JSON.stringify({
                                        payment_intent_id: paymentIntent.id
                                    })
                                });
                                
                                const confirmResult = await confirmResponse.json();
                                
                                if (confirmResult.success) {
                                    // Paiement confirmé avec succès
                                    processingModal.classList.add('hidden');
                                    document.getElementById('transaction-id').textContent = confirmResult.transaction_id;
                                    const successModal = document.getElementById('payment-success-modal');
                                    successModal.classList.remove('hidden');
                                    
                                    // Arrêter l'intervalle de vérification s'il est en cours
                                    if (paymentCheckInterval) {
                                        clearInterval(paymentCheckInterval);
                                    }
                                } else {
                                    // Si le paiement n'est pas immédiatement confirmé, commencer à vérifier périodiquement
                                    startPaymentStatusCheck(paymentIntent.id);
                                    handlePaymentProcessing("Traitement du paiement en cours...");
                                }
                            }
                        } else if (result.payment_intent_id) {
                            // Le paiement est en cours de traitement (asynchrone), commencer les vérifications
                            startPaymentStatusCheck(result.payment_intent_id);
                            handlePaymentProcessing("Traitement du paiement en cours...");
                        } else {
                            // Erreur de paiement
                            handlePaymentError(result.message || 'Erreur lors du traitement du paiement');
                        }
                    }
                } catch (error) {
                    handlePaymentError("Une erreur inattendue s'est produite. Veuillez réessayer.");
                    console.error(error);
                }
                
                // Réinitialiser le bouton de paiement
                submitButton.disabled = false;
                submitButton.innerHTML = '<span>Payer 250,00 MAD</span><i class="fas fa-lock ml-2"></i>';
            });
            
            // Fonction pour démarrer la vérification périodique du statut de paiement
            function startPaymentStatusCheck(paymentIntentId) {
                // Vérifier toutes les 2 secondes pendant 60 secondes maximum (30 tentatives)
                let attempts = 0;
                
                // Arrêter l'intervalle existant s'il y en a un
                if (paymentCheckInterval) {
                    clearInterval(paymentCheckInterval);
                }
                
                paymentCheckInterval = setInterval(async function() {
                    attempts++;
                    
                    try {
                        const response = await fetch('{{ route("payment.check-status") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: JSON.stringify({
                                payment_intent_id: paymentIntentId
                            })
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            if (result.status === 'succeeded') {
                                // Paiement réussi
                                clearInterval(paymentCheckInterval);
                                
                                // Masquer le modal de traitement
                                document.getElementById('payment-processing-modal').classList.add('hidden');
                                
                                // Afficher le modal de succès
                                document.getElementById('transaction-id').textContent = paymentIntentId;
                                document.getElementById('payment-success-modal').classList.remove('hidden');
                            } else if (result.status === 'canceled' || result.status === 'failed') {
                                // Paiement échoué
                                clearInterval(paymentCheckInterval);
                                handlePaymentError('Le paiement a été annulé ou a échoué.');
                            }
                        }
                    } catch (error) {
                        console.error("Erreur lors de la vérification du statut du paiement:", error);
                    }
                    
                    // Arrêter après 30 tentatives (environ 60 secondes)
                    if (attempts >= 30) {
                        clearInterval(paymentCheckInterval);
                        handlePaymentError("Le délai d'attente pour la vérification du paiement a été dépassé. Veuillez vérifier votre compte pour confirmer l'état du paiement.");
                    }
                }, 2000); // Vérifier toutes les 2 secondes
            }
            
            // Fonction pour afficher le modal de traitement (en attente de confirmation)
            function handlePaymentProcessing(message) {
                // Masquer le modal de traitement standard
                document.getElementById('payment-processing-modal').classList.add('hidden');
                
                // Afficher un message de traitement en cours
                const processingModal = document.getElementById('payment-processing-modal');
                const processingMsg = processingModal.querySelector('p');
                processingMsg.textContent = message;
                processingModal.classList.remove('hidden');
            }
            
            // Fonction pour gérer les erreurs de paiement
            function handlePaymentError(errorMessage) {
                // Masquer le modal de traitement
                document.getElementById('payment-processing-modal').classList.add('hidden');
                
                // Afficher le message d'erreur
                const errorElement = document.getElementById('error-message');
                errorElement.textContent = errorMessage;
                
                // Arrêter l'intervalle de vérification s'il est en cours
                if (paymentCheckInterval) {
                    clearInterval(paymentCheckInterval);
                }
                
                // Afficher le modal d'erreur
                const errorModal = document.getElementById('payment-error-modal');
                errorModal.classList.remove('hidden');
            }
            
            // Gérer le bouton "Réessayer" dans le modal d'erreur
            document.getElementById('retry-payment').addEventListener('click', function() {
                document.getElementById('payment-error-modal').classList.add('hidden');
            });
            
            // Gérer le bouton dans le modal de succès
            document.getElementById('view-appointment').addEventListener('click', function(e) {
                // La redirection se fait automatiquement via l'attribut href
            });
        });
    </script>
</body>
</html>