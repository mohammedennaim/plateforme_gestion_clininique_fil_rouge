<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Médecins - MediClinic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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

        .doctor-card:hover .doctor-overlay {
            opacity: 1;
        }

        .doctor-card:hover {
            transform: translateY(-10px);
        }

        .doctor-card {
            transition: all 0.3s ease;
        }

        .doctor-overlay {
            opacity: 0;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="font-sans text-secondary-800 bg-gray-50" x-data="doctorsPage()">

@if (auth()->check())
        <header class="bg-white shadow-sm py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-hospital text-primary-600 text-2xl mr-2"></i>
                    <span class="text-xl font-semibold text-primary-700">MediClinic</span>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('welcome') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Accueil</a>
                    <a href="{{ route('services') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Services</a>
                    <a href="{{ route('doctors') }}" class="text-primary-600 font-medium">Médecins</a>
                    <a href="{{ route('patient.reserver.store') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Rendez-vous</a>
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
                                <span class="text-sm font-medium text-secondary-700">{{ $user['name'] }}</span>
                                <i class="fas fa-chevron-down text-secondary-400 text-xs"></i>
                            </button>
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
                    <a href="{{ route('doctors') }}" class="text-primary-600 font-medium">Médecins</a>
                    <a href="{{ route('patient.reserver.store') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Rendez-vous</a>
                    <a href="{{ route('contact') }}" class="text-secondary-600 hover:text-primary-600 transition-colors">Contact</a>
                </nav>

                <div class="flex items-center space-x-4">
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

    <section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Nos Médecins Spécialistes</h1>
            <p class="text-xl max-w-3xl mx-auto">Une équipe de professionnels dévoués à votre santé et votre bien-être</p>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-gray-50 rounded-xl p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-6">Trouver un médecin</h2>
                    
                    <div class="mb-6">
                        <label for="search" class="block text-secondary-700 mb-2 font-medium">Rechercher par nom</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="search" 
                                x-model="searchTerm" 
                                @input="filterDoctors()"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent pl-10" 
                                placeholder="Entrez le nom d'un médecin..."
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-secondary-700 mb-2 font-medium">Filtrer par spécialité</label>
                        <div class="flex flex-wrap gap-3">
                            <button 
                                @click="selectedSpecialty = ''; filterDoctors()" 
                                :class="selectedSpecialty === '' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-secondary-700 hover:bg-gray-300'"
                                class="px-4 py-2 rounded-full text-sm font-medium transition-colors"
                            >
                                Toutes
                            </button>
                            <template x-for="specialty in specialties" :key="specialty">
                                <button 
                                    @click="selectedSpecialty = specialty; filterDoctors()" 
                                    :class="selectedSpecialty === specialty ? 'bg-primary-600 text-white' : 'bg-gray-200 text-secondary-700 hover:bg-gray-300'"
                                    class="px-4 py-2 rounded-full text-sm font-medium transition-colors"
                                    x-text="specialty"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-2">Résultats</h2>
                <p class="text-secondary-600">
                    <span x-text="filteredDoctors.length"></span> médecins trouvés
                    <span x-show="selectedSpecialty !== ''">dans la spécialité <span class="font-semibold" x-text="selectedSpecialty"></span></span>
                    <span x-show="searchTerm !== ''">correspondant à "<span class="font-semibold" x-text="searchTerm"></span>"</span>
                </p>
            </div>
            <div x-show="filteredDoctors.length === 0" class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                    <i class="fas fa-user-md text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Aucun médecin trouvé</h3>
                <p class="text-secondary-600 mb-6">Veuillez modifier vos critères de recherche</p>
                <button 
                    @click="resetFilters()" 
                    class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium"
                >
                    Réinitialiser les filtres
                </button>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" x-show="filteredDoctors.length > 0">
                <template x-for="doctor in filteredDoctors" :key="doctor.id">
                    <div class="bg-white rounded-xl overflow-hidden shadow-md doctor-card h-full relative">
                        <div class="relative">
                            <img :src="doctor.image" :alt="doctor.name" class="h-64 w-full object-cover object-top">
                            <div class="absolute top-4 right-4 bg-white/90 px-3 py-1 rounded-full text-green-600 text-xs font-semibold flex items-center" x-show="doctor.available">
                                <span class="w-2 h-2 bg-green-600 rounded-full mr-1"></span> Disponible
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-primary-800/80 to-transparent flex items-end justify-center pb-4 doctor-overlay">
                                <a href="{{ route('patient.reserver.store') }}" class="px-4 py-2 bg-white text-primary-700 rounded-full text-sm font-semibold hover:bg-gray-100 transition-colors">
                                    Prendre Rendez-vous
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <span class="inline-block px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-xs font-semibold mb-2" x-text="doctor.specialty"></span>
                            <h3 class="text-xl font-bold mb-1" x-text="doctor.name"></h3>
                            <p class="text-secondary-500 text-sm mb-3" x-text="`${doctor.experience} années d'expérience`"></p>
                            <p class="text-secondary-600 text-sm mb-4" x-text="doctor.description"></p>
                            <div class="bg-gray-50 p-3 rounded-lg mb-4">
                                <div class="flex items-center text-sm mb-1">
                                    <i class="fas fa-graduation-cap text-primary-600 w-5"></i>
                                    <span x-text="doctor.education"></span>
                                </div>
                                <div class="flex items-center text-sm mb-1">
                                    <i class="fas fa-certificate text-primary-600 w-5"></i>
                                    <span x-text="doctor.certification"></span>
                                </div>
                                <div class="flex items-center text-sm text-amber-500">
                                    <i class="fas fa-star w-5"></i>
                                    <span x-text="`${doctor.rating} (${doctor.reviews}+ avis)`"></span>
                                </div>
                            </div>
                            <div class="flex justify-center gap-2">
                                <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-12 flex justify-center" x-show="filteredDoctors.length > 0">
                <nav class="flex items-center space-x-2">
                    <button class="w-10 h-10 rounded-full bg-white border border-gray-300 flex items-center justify-center text-secondary-600 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center">1</button>
                    <button class="w-10 h-10 rounded-full bg-white border border-gray-300 flex items-center justify-center text-secondary-600 hover:bg-gray-50 transition-colors">2</button>
                    <button class="w-10 h-10 rounded-full bg-white border border-gray-300 flex items-center justify-center text-secondary-600 hover:bg-gray-50 transition-colors">3</button>
                    <button class="w-10 h-10 rounded-full bg-white border border-gray-300 flex items-center justify-center text-secondary-600 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </nav>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Notre équipe</span>
                <h2 class="text-3xl font-bold mb-4">Pourquoi choisir nos médecins ?</h2>
                <p class="text-secondary-600 max-w-3xl mx-auto">
                    Notre équipe médicale est composée de professionnels hautement qualifiés et dévoués à fournir les meilleurs soins possibles.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mx-auto mb-6">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Expertise</h3>
                    <p class="text-secondary-600">
                        Nos médecins sont des experts dans leurs domaines respectifs, avec des années d'expérience et une formation continue.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mx-auto mb-6">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Certifications</h3>
                    <p class="text-secondary-600">
                        Tous nos médecins sont certifiés par les organismes professionnels reconnus et suivent une formation continue.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mx-auto mb-6">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Compassion</h3>
                    <p class="text-secondary-600">
                        Nos médecins traitent chaque patient avec respect, empathie et une attention personnalisée à leurs besoins.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-2xl mx-auto mb-6">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Innovation</h3>
                    <p class="text-secondary-600">
                        Nos médecins restent à la pointe des avancées médicales et utilisent les techniques les plus modernes.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-16 bg-gradient-to-r from-primary-600 to-primary-800 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à rencontrer nos spécialistes ?</h2>
            <p class="text-xl max-w-3xl mx-auto mb-8">
                Prenez rendez-vous dès aujourd'hui et laissez nos experts prendre soin de votre santé.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#appointment" class="px-8 py-4 bg-white text-primary-700 rounded-lg hover:bg-gray-100 transition-colors font-medium text-center">
                    Prendre rendez-vous
                </a>
                <a href="#contact" class="px-8 py-4 border border-white text-white rounded-lg hover:bg-white/10 transition-colors font-medium text-center">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

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
                        <a href="#contact" class="text-secondary-400 hover:text-white transition-colors hover:translate-x-2 transform duration-300">Contact</a>
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


    <a href="#" id="back-to-top" class="fixed bottom-6 right-6 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-primary-700">
        <i class="fas fa-arrow-up"></i>
    </a>

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

        function doctorsPage() {
            return {
                searchTerm: '',
                selectedSpecialty: '',
                doctors: [
                    {
                        id: 1,
                        name: 'Dr. Sarah Johnson',
                        specialty: 'Cardiologie',
                        experience: 15,
                        description: 'Spécialisée dans le traitement des maladies cardiaques complexes',
                        education: 'Harvard Medical School',
                        certification: 'Certifiée',
                        rating: 4.9,
                        reviews: 120,
                        available: true,
                        image: 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3'
                    },
                    {
                        id: 2,
                        name: 'Dr. Michael Chen',
                        specialty: 'Neurologie',
                        experience: 15,
                        description: 'Spécialisé dans les troubles du cerveau et du système nerveux',
                        education: 'Johns Hopkins',
                        certification: 'Certifié',
                        rating: 4.8,
                        reviews: 95,
                        available: true,
                        image: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?ixlib=rb-4.0.3'
                    },
                    {
                        id: 3,
                        name: 'Dr. Amanda Park',
                        specialty: 'Dermatologie',
                        experience: 12,
                        description: 'Spécialisée en dermatologie cosmétique et traitements du cancer de la peau',
                        education: 'Columbia University',
                        certification: 'Certifiée',
                        rating: 4.9,
                        reviews: 135,
                        available: true,
                        image: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3'
                    },
                    {
                        id: 4,
                        name: 'Dr. Robert Williams',
                        specialty: 'Oncologie',
                        experience: 18,
                        description: 'Expert en traitements innovants du cancer et soins personnalisés',
                        education: 'Duke University',
                        certification: 'Double Certification',
                        rating: 5.0,
                        reviews: 178,
                        available: false,
                        image: 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3'
                    },
                    {
                        id: 5,
                        name: 'Dr. Emily Rodriguez',
                        specialty: 'Pédiatrie',
                        experience: 10,
                        description: 'Spécialisée dans les soins pédiatriques et le développement de l\'enfant',
                        education: 'Stanford University',
                        certification: 'Certifiée',
                        rating: 4.7,
                        reviews: 89,
                        available: true,
                        image: 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?ixlib=rb-4.0.3'
                    },
                    {
                        id: 6,
                        name: 'Dr. David Kim',
                        specialty: 'Orthopédie',
                        experience: 14,
                        description: 'Spécialisé dans les chirurgies orthopédiques et la médecine sportive',
                        education: 'Yale University',
                        certification: 'Certifié',
                        rating: 4.8,
                        reviews: 112,
                        available: false,
                        image: 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?ixlib=rb-4.0.3'
                    },
                    {
                        id: 7,
                        name: 'Dr. Sophie Martin',
                        specialty: 'Gynécologie',
                        experience: 16,
                        description: 'Spécialisée en santé reproductive et soins prénatals',
                        education: 'University of Paris',
                        certification: 'Certifiée',
                        rating: 4.9,
                        reviews: 145,
                        available: true,
                        image: 'https://images.unsplash.com/photo-1651008376811-b90baee60c1f?ixlib=rb-4.0.3'
                    },
                    {
                        id: 8,
                        name: 'Dr. Thomas Brown',
                        specialty: 'Psychiatrie',
                        experience: 20,
                        description: 'Expert en santé mentale et thérapies innovantes',
                        education: 'University of Chicago',
                        certification: 'Certifié',
                        rating: 4.7,
                        reviews: 98,
                        available: true,
                        image: 'https://images.unsplash.com/photo-1612531386530-97286d97c2d2?ixlib=rb-4.0.3'
                    },
                    {
                        id: 9,
                        name: 'Dr. Laura Garcia',
                        specialty: 'Endocrinologie',
                        experience: 13,
                        description: 'Spécialisée dans les troubles hormonaux et le diabète',
                        education: 'UCLA Medical School',
                        certification: 'Certifiée',
                        rating: 4.8,
                        reviews: 87,
                        available: false,
                        image: 'https://images.unsplash.com/photo-1614608682850-e0d6ed316d47?ixlib=rb-4.0.3'
                    },
                    {
                        id: 10,
                        name: 'Dr. James Wilson',
                        specialty: 'Cardiologie',
                        experience: 22,
                        description: 'Pionnier dans les procédures cardiaques mini-invasives',
                        education: 'Mayo Clinic',
                        certification: 'Triple Certification',
                        rating: 5.0,
                        reviews: 210,
                        available: true,
                        image: 'https://images.unsplash.com/photo-1622902046580-2b47f47f5471?ixlib=rb-4.0.3'
                    },
                    {
                        id: 11,
                        name: 'Dr. Olivia Taylor',
                        specialty: 'Neurologie',
                        experience: 11,
                        description: 'Spécialisée dans les troubles neurologiques pédiatriques',
                        education: 'Johns Hopkins',
                        certification: 'Certifiée',
                        rating: 4.6,
                        reviews: 76,
                        available: true,
                        image: 'https://images.unsplash.com/photo-1623854767648-e7bb8009f0db?ixlib=rb-4.0.3'
                    },
                    {
                        id: 12,
                        name: 'Dr. Alexandre Dupont',
                        specialty: 'Pneumologie',
                        experience: 17,
                        description: 'Expert en maladies respiratoires et soins pulmonaires',
                        education: 'McGill University',
                        certification: 'Certifié',
                        rating: 4.8,
                        reviews: 104,
                        available: false,
                        image: 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?ixlib=rb-4.0.3'
                    }
                ],
                filteredDoctors: [],
                specialties: [],

                init() {
                    this.specialties = [...new Set(this.doctors.map(doctor => doctor.specialty))];
                    this.filteredDoctors = [...this.doctors];
                },

                filterDoctors() {
                    this.filteredDoctors = this.doctors.filter(doctor => {
                        const matchesSearch = this.searchTerm === '' || doctor.name.toLowerCase().includes(this.searchTerm.toLowerCase());
                        const matchesSpecialty = this.selectedSpecialty === '' || doctor.specialty === this.selectedSpecialty;
                                                
                        return matchesSearch && matchesSpecialty;
                    });
                },

                resetFilters() {
                    this.searchTerm = '';
                    this.selectedSpecialty = '';
                    this.filteredDoctors = [...this.doctors];
                }
            }
        }
    </script>
</body>
</html>