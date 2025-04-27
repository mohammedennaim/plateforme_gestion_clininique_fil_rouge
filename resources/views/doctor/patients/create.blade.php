<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un patient</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Styles personnalisés */
        .page-gradient {
            background: linear-gradient(135deg, #f0f4ff 0%, #e6f0ff 100%);
        }
        
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.05);
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        
        .btn-primary {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
            transform: translateY(-1px);
        }
        
        .form-section {
            border-left: 4px solid #4f46e5;
            padding-left: 16px;
            margin-bottom: 24px;
        }
        
        .alert {
            animation: slideDown 0.5s ease-out forwards;
        }
        
        @keyframes slideDown {
            0% { 
                opacity: 0;
                transform: translateY(-20px);
            }
            100% { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Personnalisation des éléments de formulaire */
        select, input, textarea {
            transition: border 0.3s ease, box-shadow 0.3s ease;
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover:after {
            width: 60%;
        }
        
        .nav-link.active:after {
            width: 80%;
        }
    </style>
</head>
<body class="page-gradient">
    <div class="min-h-screen">
        <!-- Header/Navigation -->
        <nav class="bg-gradient-to-r from-indigo-700 to-purple-700 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                <span class="text-white font-bold text-xl ml-2">MedPortal</span>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-6">
                                <a href="#" class="nav-link text-gray-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Tableau de bord</a>
                                <a href="#" class="nav-link active text-white px-3 py-2 rounded-md text-sm font-medium">Patients</a>
                                <a href="#" class="nav-link text-gray-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Rendez-vous</a>
                                <a href="#" class="nav-link text-gray-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Consultations</a>
                                <a href="#" class="nav-link text-gray-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Prescriptions</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <button class="p-1 rounded-full text-gray-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white mr-3">
                                <span class="sr-only">Voir les notifications</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                            <div class="ml-3 relative">
                                <div class="flex items-center">
                                    <span class="text-white mr-2 font-medium">Dr. Dupont</span>
                                    <div class="p-1 bg-white bg-opacity-20 rounded-full">
                                        <img class="h-8 w-8 rounded-full object-cover border-2 border-white" src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="Avatar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-800 focus:ring-white">
                            <span class="sr-only">Ouvrir le menu principal</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenu principal -->
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center mb-6">
                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <h1 class="text-2xl font-semibold text-gray-900">Ajouter un nouveau patient</h1>
            </div>

            <!-- Messages d'alerte -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-6 alert" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium">Succès!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm mb-6 alert" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium">Erreur!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Formulaire d'ajout de patient -->
            <div class="bg-white shadow-lg overflow-hidden sm:rounded-lg card-shadow">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('doctor.patients.store')}}" method="POST" id="patient-form">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informations personnelles -->
                            <div class="col-span-1 md:col-span-2">
                                <div class="form-section">
                                    <h3 class="text-lg font-semibold text-indigo-900 mb-4">Informations personnelles</h3>
                                </div>
                            </div>
                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus" required>
                                @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus" required>
                                @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input type="text" name="phone" id="phone" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                @error('date_of_birth')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                                <input type="text" name="adresse" id="adresse" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                @error('adresse')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Informations médicales -->
                            <div class="col-span-1 md:col-span-2 mt-6">
                                <div class="form-section">
                                    <h3 class="text-lg font-semibold text-indigo-900 mb-4">Informations médicales</h3>
                                </div>
                            </div>
                            
                            <div>
                                <label for="blood_type" class="block text-sm font-medium text-gray-700">Groupe sanguin</label>
                                <select name="blood_type" id="blood_type" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                    <option value="">Sélectionner</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                                @error('blood_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="name_assurance" class="block text-sm font-medium text-gray-700">Nom de l'assurance</label>
                                <input type="text" name="name_assurance" id="name_assurance" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                @error('name_assurance')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="assurance_number" class="block text-sm font-medium text-gray-700">Numéro d'assurance</label>
                                <input type="text" name="assurance_number" id="assurance_number" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                @error('assurance_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Contact d'urgence</label>
                                <input type="text" name="emergency_contact" id="emergency_contact" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                @error('emergency_contact')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700">Taille (cm)</label>
                                <input type="number" name="height" id="height" step="0.01" min="0" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                @error('height')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700">Poids (kg)</label>
                                <input type="number" name="weight" id="weight" step="0.01" min="0" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus">
                                @error('weight')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="col-span-1 md:col-span-2">
                                <label for="medical_history" class="block text-sm font-medium text-gray-700">Antécédents médicaux</label>
                                <textarea name="medical_history" id="medical_history" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus"></textarea>
                                @error('medical_history')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="col-span-1 md:col-span-2">
                                <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies</label>
                                <textarea name="allergies" id="allergies" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md input-focus"></textarea>
                                <p class="text-xs text-gray-500 mt-1">Entrez les allergies séparées par des virgules</p>
                                @error('allergies')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('doctor.dashboard') }}" class="inline-flex items-center px-5 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4 transition-all duration-200 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex items-center px-5 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajouter le patient
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="bg-white mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500">
                    &copy; 2025 MedPortal. Tous droits réservés.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>