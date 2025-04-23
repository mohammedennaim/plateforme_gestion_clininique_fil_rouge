<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - MediClinic</title>
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

        .service-card:hover .service-icon {
            transform: scale(1.1);
            background-color: #0284c7;
            color: white;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .service-icon {
            transition: all 0.3s ease;
        }

        .service-card {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="font-sans text-secondary-800 bg-gray-50">
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
                    <a href="{{ route('services') }}" class="text-primary-600 font-medium">Services</a>
                    <a href="{{ route('doctors') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Médecins</a>
                    <a href="{{ route('patient.reserver.store') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Rendez-vous</a>
                    <a href="{{ route('contact') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Contact</a>
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
            </div>
        </header>
    @endif

    <!-- Bannière de la page -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Nos Services Médicaux</h1>
            <p class="text-xl max-w-3xl mx-auto">Des soins de santé complets et personnalisés pour vous et votre famille
            </p>
        </div>
    </section>

    <!-- Introduction aux services -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <img src="https://images.unsplash.com/photo-1504439468489-c8920d796a29?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80"
                        alt="Services médicaux" class="rounded-2xl shadow-lg w-full">
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-3xl font-bold mb-6">Des soins médicaux d'excellence</h2>
                    <p class="text-lg text-secondary-600 mb-6">
                        Chez MediClinic, nous offrons une gamme complète de services médicaux utilisant les technologies
                        les plus avancées et dispensés par des professionnels hautement qualifiés.
                    </p>
                    <p class="text-lg text-secondary-600 mb-6">
                        Notre approche centrée sur le patient garantit que chaque personne reçoit des soins
                        personnalisés adaptés à ses besoins spécifiques, dans un environnement accueillant et rassurant.
                    </p>
                    <div class="flex flex-col md:flex-row gap-4 mt-8">
                        <a href="#specialites"
                            class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium text-center">
                            Découvrir nos spécialités
                        </a>
                        <a href="#appointment"
                            class="px-6 py-3 border border-primary-600 text-primary-600 rounded-lg hover:bg-primary-50 transition-colors font-medium text-center">
                            Prendre rendez-vous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos spécialités médicales -->
    <section id="specialites" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Nos
                    spécialités</span>
                <h2 class="text-3xl font-bold mb-4">Spécialités médicales</h2>
                <p class="text-secondary-600 max-w-3xl mx-auto">
                    Notre clinique offre une large gamme de spécialités médicales pour répondre à tous vos besoins de
                    santé sous un même toit.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Cardiologie -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Cardiologie</h3>
                        <p class="text-secondary-600 mb-4">
                            Notre département de cardiologie offre des soins complets pour le diagnostic et le
                            traitement des maladies cardiovasculaires.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Électrocardiogrammes (ECG)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Échocardiographie</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Tests d'effort</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Surveillance Holter</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-600 font-medium hover:text-primary-800 transition-colors flex items-center">
                            En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Neurologie -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Neurologie</h3>
                        <p class="text-secondary-600 mb-4">
                            Notre équipe de neurologues traite les troubles du cerveau, de la moelle épinière et du
                            système nerveux.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Électroencéphalogrammes (EEG)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Électromyographie (EMG)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Traitement des migraines</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Gestion des troubles neurologiques</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-600 font-medium hover:text-primary-800 transition-colors flex items-center">
                            En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Pédiatrie -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                            <i class="fas fa-child"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Pédiatrie</h3>
                        <p class="text-secondary-600 mb-4">
                            Nos pédiatres fournissent des soins complets pour les nourrissons, les enfants et les
                            adolescents.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Examens de bien-être</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Vaccinations</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Traitement des maladies infantiles</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Conseils en développement</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-600 font-medium hover:text-primary-800 transition-colors flex items-center">
                            En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Orthopédie -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                            <i class="fas fa-bone"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Orthopédie</h3>
                        <p class="text-secondary-600 mb-4">
                            Notre service d'orthopédie traite les troubles musculo-squelettiques et les blessures.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Chirurgie orthopédique</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Traitement des fractures</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Médecine sportive</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Remplacement articulaire</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-600 font-medium hover:text-primary-800 transition-colors flex items-center">
                            En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Dermatologie -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                            <i class="fas fa-allergies"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Dermatologie</h3>
                        <p class="text-secondary-600 mb-4">
                            Nos dermatologues diagnostiquent et traitent les affections de la peau, des cheveux et des
                            ongles.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Dépistage du cancer de la peau</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Traitement de l'acné</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Dermatologie esthétique</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Traitement des maladies de peau</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-600 font-medium hover:text-primary-800 transition-colors flex items-center">
                            En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Gynécologie -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden service-card">
                    <div class="p-8">
                        <div
                            class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                            <i class="fas fa-venus"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Gynécologie</h3>
                        <p class="text-secondary-600 mb-4">
                            Notre service de gynécologie offre des soins complets pour la santé des femmes.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Examens gynécologiques</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Planification familiale</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Soins prénatals</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary-600 mt-1 mr-2"></i>
                                <span>Traitement des troubles gynécologiques</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary-600 font-medium hover:text-primary-800 transition-colors flex items-center">
                            En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services de diagnostic -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Diagnostic</span>
                <h2 class="text-3xl font-bold mb-4">Services de diagnostic avancés</h2>
                <p class="text-secondary-600 max-w-3xl mx-auto">
                    Notre clinique est équipée des technologies de diagnostic les plus récentes pour fournir des
                    résultats précis et rapides.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80"
                        alt="Équipement de diagnostic" class="rounded-2xl shadow-lg w-full">
                </div>
                <div>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-xl mr-4 shrink-0">
                                <i class="fas fa-x-ray"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Imagerie médicale</h3>
                                <p class="text-secondary-600">
                                    Notre service d'imagerie médicale comprend des équipements de pointe pour les
                                    radiographies, échographies, IRM et scanners CT.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-xl mr-4 shrink-0">
                                <i class="fas fa-vial"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Laboratoire d'analyses</h3>
                                <p class="text-secondary-600">
                                    Notre laboratoire moderne effectue une gamme complète d'analyses sanguines et
                                    d'autres tests avec des résultats rapides et précis.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-xl mr-4 shrink-0">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Tests cardiaques</h3>
                                <p class="text-secondary-600">
                                    Nous proposons des tests cardiaques complets, y compris des électrocardiogrammes,
                                    des échocardiogrammes et des tests d'effort.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-xl mr-4 shrink-0">
                                <i class="fas fa-lungs"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Tests pulmonaires</h3>
                                <p class="text-secondary-600">
                                    Notre clinique offre des tests de fonction pulmonaire pour évaluer la santé
                                    respiratoire et diagnostiquer les troubles pulmonaires.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services préventifs -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Prévention</span>
                <h2 class="text-3xl font-bold mb-4">Médecine préventive</h2>
                <p class="text-secondary-600 max-w-3xl mx-auto">
                    Nous croyons que la prévention est la clé d'une bonne santé. Nos services préventifs vous aident à
                    maintenir votre bien-être.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-md p-8 service-card">
                    <div
                        class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Examens de santé annuels</h3>
                    <p class="text-secondary-600">
                        Des examens complets pour évaluer votre état de santé général et détecter les problèmes
                        potentiels avant qu'ils ne deviennent graves.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 service-card">
                    <div
                        class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                        <i class="fas fa-syringe"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Vaccinations</h3>
                    <p class="text-secondary-600">
                        Programme complet de vaccinations pour tous les âges, y compris les vaccins contre la grippe
                        saisonnière et les vaccins recommandés pour les voyages.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 service-card">
                    <div
                        class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Dépistage des maladies cardiovasculaires</h3>
                    <p class="text-secondary-600">
                        Évaluation des facteurs de risque cardiovasculaires et tests de dépistage pour prévenir les
                        maladies cardiaques.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 service-card">
                    <div
                        class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                        <i class="fas fa-weight"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gestion du poids</h3>
                    <p class="text-secondary-600">
                        Programmes personnalisés de gestion du poids comprenant des conseils nutritionnels et des plans
                        d'exercice adaptés à vos besoins.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 service-card">
                    <div
                        class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                        <i class="fas fa-smoking-ban"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Programmes d'arrêt du tabac</h3>
                    <p class="text-secondary-600">
                        Soutien et ressources pour vous aider à arrêter de fumer, y compris des thérapies de
                        remplacement de la nicotine et des conseils comportementaux.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 service-card">
                    <div
                        class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mb-6 service-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Santé mentale préventive</h3>
                    <p class="text-secondary-600">
                        Services de soutien en santé mentale pour gérer le stress, l'anxiété et prévenir les problèmes
                        de santé mentale plus graves.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Témoignages -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Témoignages</span>
                <h2 class="text-3xl font-bold mb-4">Ce que disent nos patients</h2>
                <p class="text-secondary-600 max-w-3xl mx-auto">
                    Découvrez les expériences de nos patients avec nos services médicaux.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-50 rounded-xl p-8 relative">
                    <div class="absolute -top-5 left-8">
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white">
                            <i class="fas fa-quote-left"></i>
                        </div>
                    </div>
                    <p class="text-secondary-600 mb-6 mt-4">
                        "Le service de cardiologie de MediClinic a littéralement sauvé ma vie. L'équipe médicale a
                        détecté un problème cardiaque que je ne soupçonnais pas lors d'un examen de routine. Leur
                        professionnalisme et leur attention aux détails sont remarquables."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Patient"
                            class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold">Thomas Martin</h4>
                            <div class="text-amber-500 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-8 relative">
                    <div class="absolute -top-5 left-8">
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white">
                            <i class="fas fa-quote-left"></i>
                        </div>
                    </div>
                    <p class="text-secondary-600 mb-6 mt-4">
                        "J'ai amené mon fils au service de pédiatrie et j'ai été impressionnée par la façon dont les
                        médecins interagissent avec les enfants. Ils ont su mettre mon fils à l'aise et lui ont fourni
                        des soins exceptionnels. Je recommande vivement MediClinic pour les soins pédiatriques."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Patiente"
                            class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold">Sophie Dubois</h4>
                            <div class="text-amber-500 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-8 relative">
                    <div class="absolute -top-5 left-8">
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white">
                            <i class="fas fa-quote-left"></i>
                        </div>
                    </div>
                    <p class="text-secondary-600 mb-6 mt-4">
                        "Le service de dermatologie a transformé ma peau. Après des années à lutter contre l'acné, j'ai
                        enfin trouvé un traitement qui fonctionne. Les dermatologues sont non seulement compétents, mais
                        aussi très attentionnés. Je suis reconnaissant pour les soins que j'ai reçus."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Patient"
                            class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold">Alexandre Petit</h4>
                            <div class="text-amber-500 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary-600 to-primary-800 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à prendre soin de votre santé?</h2>
            <p class="text-xl max-w-3xl mx-auto mb-8">
                Prenez rendez-vous dès aujourd'hui et laissez nos experts prendre soin de votre santé.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#appointment"
                    class="px-8 py-4 bg-white text-primary-700 rounded-lg hover:bg-gray-100 transition-colors font-medium text-center">
                    Prendre rendez-vous
                </a>
                <a href="#contact"
                    class="px-8 py-4 border border-white text-white rounded-lg hover:bg-white/10 transition-colors font-medium text-center">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-secondary-900 text-secondary-400 py-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-white text-lg font-bold mb-6">À Propos de MediClinic</h4>
                    <p class="mb-6">MediClinic est un prestataire de soins de santé de premier plan engagé à fournir des
                        services médicaux exceptionnels avec compassion et expertise.</p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-secondary-800 hover:bg-primary-600 flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-secondary-800 hover:bg-primary-600 flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-secondary-800 hover:bg-primary-600 flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-secondary-800 hover:bg-primary-600 flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-lg font-bold mb-6">Liens Rapides</h4>
                    <div class="flex flex-col space-y-3">
                        <a href="index.html"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Accueil</a>
                        <a href="services.html"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Services</a>
                        <a href="medecins.html"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Médecins</a>
                        <a href="#appointment"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Rendez-vous</a>
                        <a href="#contact"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Contact</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-lg font-bold mb-6">Nos Services</h4>
                    <div class="flex flex-col space-y-3">
                        <a href="#"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Cardiologie</a>
                        <a href="#"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Neurologie</a>
                        <a href="#"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Pédiatrie</a>
                        <a href="#"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Orthopédie</a>
                        <a href="#"
                            class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Dermatologie</a>
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
                    <a href="#" class="text-secondary-400 hover:text-white transition-colors mr-4">Politique de
                        Confidentialité</a>
                    <a href="#" class="text-secondary-400 hover:text-white transition-colors">Conditions
                        d'Utilisation</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bouton Retour en Haut -->
    <a href="#" id="back-to-top"
        class="fixed bottom-6 right-6 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-primary-700">
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
    </script>
</body>

</html>