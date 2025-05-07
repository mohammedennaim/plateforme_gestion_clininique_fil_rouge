<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un patient</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Styles personnalisés */
        .page-gradient {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #dbeafe 100%);
        }
        
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.15), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .form-section {
            border-left: 4px solid #4f46e5;
            padding-left: 16px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        
        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #4f46e5, #818cf8);
            opacity: 0.8;
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
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus, textarea:focus {
            transform: translateY(-1px);
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
            bottom: -2px;
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
        
        /* Floating labels */
        .float-label-input {
            position: relative;
        }
        
        .float-label-input input:focus + label,
        .float-label-input input:not(:placeholder-shown) + label,
        .float-label-input select:focus + label,
        .float-label-input select:not([value=""]):valid + label,
        .float-label-input textarea:focus + label,
        .float-label-input textarea:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem) scale(0.85);
            background-color: white;
            padding: 0 0.4rem;
            color: #4f46e5;
        }
        
        .float-label-input label {
            position: absolute;
            left: 1rem;
            top: 0.7rem;
            padding: 0;
            color: #6b7280;
            pointer-events: none;
            transform-origin: left top;
            transition: all 0.3s ease;
        }
        
        /* Card hover effect */
        .hover-card {
            transition: all 0.3s ease;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -5px rgba(59, 130, 246, 0.2), 0 10px 15px -6px rgba(59, 130, 246, 0.15);
        }
        
        /* Pulse animation for submit button */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(79, 70, 229, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
            }
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        /* Progress bar */
        .progress-container {
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }
        
        .progress-bar {
            height: 4px;
            background: linear-gradient(to right, #4f46e5, #818cf8);
            width: 0%;
            transition: width 0.3s ease;
        }
        
        /* Custom checkbox */
        .custom-checkbox {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            user-select: none;
        }
        
        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .custom-checkbox:hover input ~ .checkmark {
            background-color: #ccc;
        }
        
        .custom-checkbox input:checked ~ .checkmark {
            background-color: #4f46e5;
        }
        
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        
        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }
        
        .custom-checkbox .checkmark:after {
            left: 7px;
            top: 3px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="page-gradient min-h-screen">
    <!-- Progress bar -->
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <!-- Contenu principal -->
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('doctor.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 mr-2 transition-all duration-300 hover:scale-110">
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
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex h-8 w-8" onclick="this.parentElement.parentElement.classList.add('hidden')">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
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
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-200 inline-flex h-8 w-8" onclick="this.parentElement.parentElement.classList.add('hidden')">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Formulaire d'ajout de patient -->
        <div class="bg-white shadow-lg overflow-hidden sm:rounded-lg card-shadow hover-card">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('doctor.patients.store') }}" method="POST" id="patient-form">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations personnelles -->
                        <div class="col-span-1 md:col-span-2">
                            <div class="form-section">
                                <h3 class="text-lg font-semibold text-indigo-900 mb-4 flex items-center">
                                    <i class="fas fa-user-circle mr-2 text-indigo-600"></i>
                                    Informations personnelles
                                </h3>
                            </div>
                        </div>
                        
                        <div class="float-label-input">
                            <input type="text" name="name" id="name" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus" required>
                            <label for="name" class="text-sm font-medium text-gray-700">Nom complet</label>
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="float-label-input">
                            <input type="email" name="email" id="email" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus" required>
                            <label for="email" class="text-sm font-medium text-gray-700">Adresse e-mail</label>
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="float-label-input">
                            <input type="text" name="phone" id="phone" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus">
                            <label for="phone" class="text-sm font-medium text-gray-700">Téléphone</label>
                            @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="float-label-input">
                            <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus">
                            <label for="date_of_birth" class="text-sm font-medium text-gray-700 bg-white px-1 transform -translate-y-6 scale-85">Date de naissance</label>
                            @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="float-label-input">
                            <input type="text" name="adresse" id="adresse" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus">
                            <label for="adresse" class="text-sm font-medium text-gray-700">Adresse</label>
                            @error('adresse')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Informations médicales -->
                        <div class="col-span-1 md:col-span-2 mt-6">
                            <div class="form-section">
                                <h3 class="text-lg font-semibold text-indigo-900 mb-4 flex items-center">
                                    <i class="fas fa-heartbeat mr-2 text-indigo-600"></i>
                                    Informations médicales
                                </h3>
                            </div>
                        </div>
                        
                        <div class="float-label-input">
                            <select name="blood_type" id="blood_type" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus" required>
                                <option value="" disabled selected></option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                            <label for="blood_type" class="text-sm font-medium text-gray-700">Groupe sanguin</label>
                            @error('blood_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="float-label-input">
                            <input type="text" name="name_assurance" id="name_assurance" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus">
                            <label for="name_assurance" class="text-sm font-medium text-gray-700">Nom de l'assurance</label>
                            @error('name_assurance')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="float-label-input">
                            <input type="text" name="assurance_number" id="assurance_number" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus">
                            <label for="assurance_number" class="text-sm font-medium text-gray-700">Numéro d'assurance</label>
                            @error('assurance_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="float-label-input">
                            <input type="text" name="emergency_contact" id="emergency_contact" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus">
                            <label for="emergency_contact" class="text-sm font-medium text-gray-700">Contact d'urgence</label>
                            @error('emergency_contact')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- <div class="float-label-input">
                            <input type="number" name="height" id="height" step="0.01" min="0" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus">
                            <label for="height" class="text-sm font-medium text-gray-700">Taille (cm)</label>
                            @error('height')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div> -->
                        
                        <!-- <div class="float-label-input">
                            <input type="number" name="weight" id="weight" step="0.01" min="0" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus">
                            <label for="weight" class="text-sm font-medium text-gray-700">Poids (kg)</label>
                            @error('weight')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div> -->
                        
                        <div class="col-span-1 md:col-span-2 float-label-input">
                            <textarea name="medical_history" id="medical_history" rows="3" placeholder=" " class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none input-focus"></textarea>
                            <label for="medical_history" class="text-sm font-medium text-gray-700">Antécédents médicaux</label>
                            @error('medical_history')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2 mt-4">
                            <label class="custom-checkbox flex items-center">
                                <input type="checkbox" name="consent" id="consent">
                                <span class="checkmark"></span>
                                <span class="ml-2 text-sm text-gray-700">Je confirme que les informations fournies sont exactes et j'autorise leur utilisation dans le cadre médical</span>
                            </label>
                            @error('consent')
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
                        <button type="submit" id="submit-btn" class="inline-flex items-center px-5 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white btn-primary pulse-animation">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Progress bar
            window.onscroll = function() {
                let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                let scrolled = (winScroll / height) * 100;
                document.getElementById("progressBar").style.width = scrolled + "%";
            };
            
            // Date of birth max date (today)
            const dateInput = document.getElementById('date_of_birth');
            if (dateInput) {
                const today = new Date();
                const yyyy = today.getFullYear();
                let mm = today.getMonth() + 1;
                let dd = today.getDate();
                
                if (dd < 10) dd = '0' + dd;
                if (mm < 10) mm = '0' + mm;
                
                const formattedToday = yyyy + '-' + mm + '-' + dd;
                dateInput.setAttribute('max', formattedToday);
            }
            
            // Mobile menu toggle
            const mobileMenuButton = document.querySelector('.md\\:hidden button');
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    const mobileMenu = document.createElement('div');
                    mobileMenu.className = 'fixed inset-0 z-50 bg-indigo-800 bg-opacity-95 flex flex-col items-center justify-center';
                    mobileMenu.innerHTML = `
                        <button class="absolute top-4 right-4 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <div class="flex flex-col space-y-4">
                            <a href="{{ route('doctor.dashboard') }}" class="text-white text-lg font-medium py-2 px-4">Tableau de bord</a>
                            <a href="#" class="text-white text-lg font-medium py-2 px-4 border-l-4 border-white">Patients</a>
                            <a href="#" class="text-white text-lg font-medium py-2 px-4">Rendez-vous</a>
                            <a href="#" class="text-white text-lg font-medium py-2 px-4">Consultations</a>
                            <a href="#" class="text-white text-lg font-medium py-2 px-4">Prescriptions</a>
                        </div>
                    `;
                    
                    document.body.appendChild(mobileMenu);
                    document.body.style.overflow = 'hidden';
                    
                    const closeButton = mobileMenu.querySelector('button');
                    closeButton.addEventListener('click', function() {
                        document.body.removeChild(mobileMenu);
                        document.body.style.overflow = '';
                    });
                });
            }
        });
    </script>
</body>
</html>