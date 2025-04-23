<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - MediClinic</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        html {
            scroll-behavior: smooth;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .contact-card {
            transition: all 0.3s ease;
        }

        .contact-icon {
            transition: all 0.3s ease;
        }

        .contact-card:hover .contact-icon {
            background-color: #0284c7;
            color: white;
        }

        .form-input:focus {
            border-color: transparent;
            outline: none;
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.3);
        }
    </style>
</head>

<body class="font-sans text-secondary-800 bg-gray-50" x-data="contactPage()">
@if (auth()->check())


        <header class="bg-white shadow-sm py-4">
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
    @else
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
                    <a href="{{ route('patient.reserver.store') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Rendez-vous</a>
                    <a href="{{ route('contact') }}" class="text-primary-600 font-medium">Contact</a>
                </nav>

                <!-- User Authentication Section -->
                <div class="flex items-center space-x-4">
                    <!-- Bouton de connexion/profil -->
                    <div id="auth-buttons" class="flex items-center">
                        <a href="{{ Route('login') }}" id="login-button"
                            class="text-sm font-medium text-primary-600 hover:text-primary-800">Se connecter</a>
                        <span class="mx-2 text-secondary-300">|</span>
                        <a href="{{ Route('logout') }}"
                            class="text-sm font-medium text-primary-600 hover:text-primary-800">S'inscrire</a>
                    </div>
                </div>

                <button class="md:hidden text-secondary-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </header>
    @endif

    <!-- Bannière de la page -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Contactez-Nous</h1>
            <p class="text-xl max-w-3xl mx-auto">Nous sommes là pour répondre à vos questions et vous aider à prendre soin de votre santé</p>
        </div>
    </section>

    <!-- Informations de contact -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Nos coordonnées</span>
                <h2 class="text-3xl font-bold mb-4">Comment nous joindre</h2>
                <p class="text-secondary-600 max-w-3xl mx-auto">
                    Plusieurs façons de nous contacter pour vos questions, rendez-vous ou urgences
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-gray-50 p-8 rounded-xl shadow-md text-center contact-card">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mx-auto mb-6 contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Notre adresse</h3>
                    <p class="text-secondary-600">
                        123 Boulevard du Centre Médical<br>
                        Suite 500<br>
                        Ville Santé, CA 90210
                    </p>
                    <a href="https://maps.google.com" target="_blank" class="inline-block mt-4 text-primary-600 hover:text-primary-800 font-medium">
                        Voir sur la carte <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow-md text-center contact-card">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mx-auto mb-6 contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Téléphone</h3>
                    <p class="text-secondary-600">
                        Standard: <a href="tel:+33123456789" class="hover:text-primary-600">(123) 456-7890</a><br>
                        Urgence: <a href="tel:+33123456777" class="hover:text-primary-600">(123) 456-7777</a><br>
                        Fax: (123) 456-7891
                    </p>
                    <a href="tel:+33123456789" class="inline-block mt-4 text-primary-600 hover:text-primary-800 font-medium">
                        Appelez-nous <i class="fas fa-phone ml-1"></i>
                    </a>
                </div>

                <!-- Email -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-md text-center contact-card">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mx-auto mb-6 contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Email</h3>
                    <p class="text-secondary-600">
                        Info: <a href="mailto:info@mediclinic.com" class="hover:text-primary-600">info@mediclinic.com</a><br>
                        Rendez-vous: <a href="mailto:rdv@mediclinic.com" class="hover:text-primary-600">rdv@mediclinic.com</a><br>
                        Support: <a href="mailto:support@mediclinic.com" class="hover:text-primary-600">support@mediclinic.com</a>
                    </p>
                    <a href="mailto:info@mediclinic.com" class="inline-block mt-4 text-primary-600 hover:text-primary-800 font-medium">
                        Envoyez-nous un email <i class="fas fa-paper-plane ml-1"></i>
                    </a>
                </div>

                <!-- Heures d'ouverture -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-md text-center contact-card">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mx-auto mb-6 contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Heures d'ouverture</h3>
                    <ul class="text-secondary-600 space-y-1">
                        <li class="flex justify-between">
                            <span>Lundi - Vendredi:</span>
                            <span>8h00 - 21h00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Samedi:</span>
                            <span>9h00 - 17h00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Dimanche:</span>
                            <span>10h00 - 14h00</span>
                        </li>
                        <li class="flex justify-between text-red-600 font-medium">
                            <span>Urgences:</span>
                            <span>24h/24, 7j/7</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulaire de contact et carte -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Écrivez-nous</span>
                <h2 class="text-3xl font-bold mb-4">Envoyez-nous un message</h2>
                <p class="text-secondary-600 max-w-3xl mx-auto">
                    Vous avez des questions ou besoin d'informations ? Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Formulaire de contact -->
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-10">
                    <form x-data="contactForm()" @submit.prevent="submitForm">
                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="firstName" class="block text-secondary-700 mb-2 font-medium">Prénom <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    id="firstName" 
                                    x-model="formData.firstName"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 form-input" 
                                    placeholder="Votre prénom"
                                    required
                                >
                            </div>
                            <div>
                                <label for="lastName" class="block text-secondary-700 mb-2 font-medium">Nom <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    id="lastName" 
                                    x-model="formData.lastName"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 form-input" 
                                    placeholder="Votre nom"
                                    required
                                >
                            </div>
                            <div>
                                <label for="email" class="block text-secondary-700 mb-2 font-medium">Email <span class="text-red-500">*</span></label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    x-model="formData.email"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 form-input" 
                                    placeholder="Votre adresse email"
                                    required
                                >
                            </div>
                            <div>
                                <label for="phone" class="block text-secondary-700 mb-2 font-medium">Téléphone</label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    x-model="formData.phone"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 form-input" 
                                    placeholder="Votre numéro de téléphone"
                                >
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="subject" class="block text-secondary-700 mb-2 font-medium">Sujet <span class="text-red-500">*</span></label>
                            <select 
                                id="subject" 
                                x-model="formData.subject"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 form-input" 
                                required
                            >
                                <option value="" disabled selected>Sélectionnez un sujet</option>
                                <option value="appointment">Demande de rendez-vous</option>
                                <option value="information">Demande d'information</option>
                                <option value="billing">Facturation</option>
                                <option value="feedback">Commentaires</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="message" class="block text-secondary-700 mb-2 font-medium">Message <span class="text-red-500">*</span></label>
                            <textarea 
                                id="message" 
                                x-model="formData.message"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 form-input" 
                                rows="5" 
                                placeholder="Votre message"
                                required
                            ></textarea>
                        </div>

                        <!-- Message de succès -->
                        <div 
                            x-show="formSubmitted" 
                            x-transition
                            class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg"
                        >
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.</span>
                            </div>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium flex items-center justify-center"
                            :disabled="formSubmitted"
                            :class="{'opacity-50 cursor-not-allowed': formSubmitted}"
                        >
                            <span x-show="!formSubmitting">Envoyer le message</span>
                            <span x-show="formSubmitting" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Envoi en cours...
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Carte et informations supplémentaires -->
                <div>
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold mb-6">Informations supplémentaires</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <h4 class="font-bold text-lg mb-2">Transport</h4>
                                <p class="text-secondary-600 mb-2">Notre clinique est facilement accessible par les transports en commun et dispose d'un parking gratuit pour les patients.</p>
                                <ul class="space-y-1">
                                    <li class="flex items-center">
                                        <i class="fas fa-subway text-primary-600 w-6"></i>
                                        <span>Métro: Ligne 3, Station Santé</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-bus text-primary-600 w-6"></i>
                                        <span>Bus: Lignes 42, 67, 89</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-car text-primary-600 w-6"></i>
                                        <span>Parking: 100 places gratuites</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h4 class="font-bold text-lg mb-2">Accessibilité</h4>
                                <p class="text-secondary-600 mb-2">Notre clinique est entièrement accessible aux personnes à mobilité réduite.</p>
                                <ul class="space-y-1">
                                    <li class="flex items-center">
                                        <i class="fas fa-wheelchair text-primary-600 w-6"></i>
                                        <span>Rampes d'accès</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-elevator text-primary-600 w-6"></i>
                                        <span>Ascenseurs adaptés</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-restroom text-primary-600 w-6"></i>
                                        <span>Toilettes accessibles</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h4 class="font-bold text-lg mb-2">Suivez-nous</h4>
                                <p class="text-secondary-600 mb-4">Restez informé de nos actualités et conseils santé en nous suivant sur les réseaux sociaux.</p>
                                <div class="flex space-x-4 my-4">
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-primary-600 hover:text-white flex items-center justify-center text-primary-600 transition-colors">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-primary-600 hover:text-white flex items-center justify-center text-primary-600 transition-colors">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-primary-600 hover:text-white flex items-center justify-center text-primary-600 transition-colors">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-primary-600 hover:text-white flex items-center justify-center text-primary-600 transition-colors">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-primary-600 hover:text-white flex items-center justify-center text-primary-600 transition-colors">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">FAQ</span>
                <h2 class="text-3xl font-bold mb-4">Questions fréquemment posées</h2>
                <p class="text-secondary-600 max-w-3xl mx-auto">
                    Trouvez rapidement des réponses aux questions les plus courantes concernant nos services et notre clinique.
                </p>
            </div>

            <div class="max-w-4xl mx-auto" x-data="{activeTab: 0}">
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 0 ? null : 0" 
                            class="flex justify-between items-center w-full p-5 text-left bg-white hover:bg-gray-50 transition-colors"
                            :class="{'bg-gray-50': activeTab === 0}"
                        >
                            <span class="font-medium text-lg">Comment puis-je prendre rendez-vous ?</span>
                            <i class="fas" :class="activeTab === 0 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        <div x-show="activeTab === 0" x-transition class="p-5 bg-gray-50 border-t border-gray-200">
                            <p class="text-secondary-600">
                                Vous pouvez prendre rendez-vous de plusieurs façons :
                            </p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-secondary-600">
                                <li>En ligne via notre portail patient</li>
                                <li>Par téléphone au (123) 456-7890</li>
                                <li>En personne à notre réception</li>
                                <li>Par email à rdv@mediclinic.com</li>
                            </ul>
                            <p class="mt-2 text-secondary-600">
                                Pour les nouveaux patients, nous vous recommandons d'arriver 15 minutes avant votre rendez-vous pour remplir les formulaires nécessaires.
                            </p>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 1 ? null : 1" 
                            class="flex justify-between items-center w-full p-5 text-left bg-white hover:bg-gray-50 transition-colors"
                            :class="{'bg-gray-50': activeTab === 1}"
                        >
                            <span class="font-medium text-lg">Quelles assurances acceptez-vous ?</span>
                            <i class="fas" :class="activeTab === 1 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        <div x-show="activeTab === 1" x-transition class="p-5 bg-gray-50 border-t border-gray-200">
                            <p class="text-secondary-600">
                                Nous acceptons la plupart des assurances santé principales, y compris :
                            </p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-secondary-600">
                                <li>Assurance Maladie</li>
                                <li>Mutuelles complémentaires</li>
                                <li>Assurances privées</li>
                                <li>Assurances internationales</li>
                            </ul>
                            <p class="mt-2 text-secondary-600">
                                Veuillez contacter notre service administratif pour vérifier si votre assurance spécifique est acceptée.
                            </p>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 2 ? null : 2" 
                            class="flex justify-between items-center w-full p-5 text-left bg-white hover:bg-gray-50 transition-colors"
                            :class="{'bg-gray-50': activeTab === 2}"
                        >
                            <span class="font-medium text-lg">Comment puis-je accéder à mes dossiers médicaux ?</span>
                            <i class="fas" :class="activeTab === 2 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        <div x-show="activeTab === 2" x-transition class="p-5 bg-gray-50 border-t border-gray-200">
                            <p class="text-secondary-600">
                                Vous pouvez accéder à vos dossiers médicaux de plusieurs façons :
                            </p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-secondary-600">
                                <li>Via notre portail patient en ligne (méthode recommandée)</li>
                                <li>En faisant une demande écrite à notre service des dossiers médicaux</li>
                                <li>En personne avec une pièce d'identité valide</li>
                            </ul>
                            <p class="mt-2 text-secondary-600">
                                Conformément à la réglementation sur la protection des données, nous garantissons la confidentialité de vos informations médicales.
                            </p>
                        </div>
                    </div>

                    <!-- Question 4 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 3 ? null : 3" 
                            class="flex justify-between items-center w-full p-5 text-left bg-white hover:bg-gray-50 transition-colors"
                            :class="{'bg-gray-50': activeTab === 3}"
                        >
                            <span class="font-medium text-lg">Que faire en cas d'urgence médicale ?</span>
                            <i class="fas" :class="activeTab === 3 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        <div x-show="activeTab === 3" x-transition class="p-5 bg-gray-50 border-t border-gray-200">
                            <p class="text-secondary-600">
                                En cas d'urgence médicale grave, appelez immédiatement le 15 (SAMU) ou le 112 (numéro d'urgence européen).
                            </p>
                            <p class="mt-2 text-secondary-600">
                                Notre service d'urgence est ouvert 24h/24 et 7j/7. Pour les urgences non vitales, vous pouvez vous présenter directement à notre service d'urgence ou appeler notre ligne d'urgence au (123) 456-7777.
                            </p>
                            <p class="mt-2 text-secondary-600 font-medium">
                                Veuillez noter que les cas sont traités par ordre de gravité et non par ordre d'arrivée.
                            </p>
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button 
                            @click="activeTab = activeTab === 4 ? null : 4" 
                            class="flex justify-between items-center w-full p-5 text-left bg-white hover:bg-gray-50 transition-colors"
                            :class="{'bg-gray-50': activeTab === 4}"
                        >
                            <span class="font-medium text-lg">Proposez-vous des consultations à distance ?</span>
                            <i class="fas" :class="activeTab === 4 ? 'fa-chevron-up text-primary-600' : 'fa-chevron-down text-gray-400'"></i>
                        </button>
                        <div x-show="activeTab === 4" x-transition class="p-5 bg-gray-50 border-t border-gray-200">
                            <p class="text-secondary-600">
                                Oui, nous proposons des consultations par télémédecine pour de nombreuses spécialités. Ces consultations peuvent être réalisées par vidéo ou par téléphone selon vos préférences et les recommandations de votre médecin.
                            </p>
                            <p class="mt-2 text-secondary-600">
                                Pour prendre rendez-vous pour une consultation à distance, utilisez notre portail patient en ligne ou appelez notre standard au (123) 456-7890.
                            </p>
                            <p class="mt-2 text-secondary-600">
                                Veuillez noter que certaines conditions nécessitent un examen physique et ne peuvent pas être traitées par télémédecine.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <a href="#" class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium">
                        Voir toutes les questions fréquentes
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-gradient-to-r from-primary-600 to-primary-800 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-4">Restez informé</h2>
                <p class="text-lg mb-8">
                    Abonnez-vous à notre newsletter pour recevoir des conseils de santé, des informations sur nos services et les dernières actualités de notre clinique.
                </p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                    <input 
                        type="email" 
                        class="flex-grow px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white" 
                        placeholder="Votre adresse email"
                        required
                    >
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-white text-primary-700 rounded-lg hover:bg-gray-100 transition-colors font-medium whitespace-nowrap"
                    >
                        S'abonner
                    </button>
                </form>
                <p class="text-sm mt-4 opacity-80">
                    En vous abonnant, vous acceptez notre politique de confidentialité. Vous pouvez vous désabonner à tout moment.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-secondary-900 text-secondary-400 py-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-white text-lg font-bold mb-6">À Propos de MediClinic</h4>
                    <p class="mb-6">MediClinic est un prestataire de soins de santé de premier plan engagé à fournir des services médicaux exceptionnels avec compassion et expertise.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-secondary-800 hover:bg-primary-600 flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-secondary-800 hover:bg-primary-600 flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-secondary-800 hover:bg-primary-600 flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-secondary-800 hover:bg-primary-600 flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-lg font-bold mb-6">Liens Rapides</h4>
                    <div class="flex flex-col space-y-3">
                        <a href="index.html" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Accueil</a>
                        <a href="services.html" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Services</a>
                        <a href="medecins.html" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Médecins</a>
                        <a href="#appointment" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Rendez-vous</a>
                        <a href="contact.html" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Contact</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-lg font-bold mb-6">Nos Services</h4>
                    <div class="flex flex-col space-y-3">
                        <a href="#" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Cardiologie</a>
                        <a href="#" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Neurologie</a>
                        <a href="#" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Pédiatrie</a>
                        <a href="#" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Orthopédie</a>
                        <a href="#" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Dermatologie</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-lg font-bold mb-6">Contact</h4>
                    <div class="space-y-4">
                        <p class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-500"></i>
                            <span>123 Boulevard du Centre Médical, Ville Santé, CA 90210</span>
                        </p>
                        <p class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-primary-500"></i>
                            <span>(123) 456-7890</span>
                        </p>
                        <p class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-primary-500"></i>
                            <span>contact@mediclinic.com</span>
                        </p>
                        <p class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-3 text-primary-500"></i>
                            <span>Lun-Ven: 8h-21h, Sam: 9h-17h, Dim: 10h-14h</span>
                        </p>
                    </div>
                </div>
            </div>
            <hr class="my-8 border-secondary-800">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p>&copy; 2025 MediClinic. Tous droits réservés.</p>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="text-secondary-400 hover:text-white transition-colors mr-4">Politique de Confidentialité</a>
                    <a href="#" class="text-secondary-400 hover:text-white transition-colors">Conditions d'Utilisation</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bouton Retour en Haut -->
    <a href="#" id="back-to-top" class="fixed bottom-6 right-6 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-primary-700">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Script JavaScript -->
    <script>
            const profileDropdownButton = document.getElementById('profile-dropdown-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            profileDropdownButton.addEventListener('click', function () {
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!profileDropdownButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        // Gestion du menu mobile
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Gestion du bouton retour en haut
        const backToTopButton = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.add('opacity-0', 'invisible');
                backToTopButton.classList.remove('opacity-100', 'visible');
            }
        });

        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Alpine.js - Logique du formulaire de contact
        function contactForm() {
            return {
                formData: {
                    firstName: '',
                    lastName: '',
                    email: '',
                    phone: '',
                    subject: '',
                    message: '',
                    consent: false
                },
                formSubmitting: false,
                formSubmitted: false,
                submitForm() {
                    this.formSubmitting = true;
                    
                    // Simuler un envoi de formulaire (remplacer par un vrai envoi en production)
                    setTimeout(() => {
                        this.formSubmitting = false;
                        this.formSubmitted = true;
                        
                        // Réinitialiser le formulaire
                        this.formData = {
                            firstName: '',
                            lastName: '',
                            email: '',
                            phone: '',
                            subject: '',
                            message: '',
                            consent: false
                        };
                        
                        // Faire défiler jusqu'au message de succès
                        setTimeout(() => {
                            window.scrollBy({
                                top: 100,
                                behavior: 'smooth'
                            });
                        }, 100);
                    }, 1500);
                }
            };
        }

        // Alpine.js - Logique de la page de contact
        function contactPage() {
            return {
                // Vous pouvez ajouter d'autres fonctionnalités ici si nécessaire
            };
        }
    </script>
</body>
</html>