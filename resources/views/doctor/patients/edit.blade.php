<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Modifier un patient | MediClinic</title>
    
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
                        input: '0 2px 5px 0 rgba(0, 0, 0, 0.05)'
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
        
        .form-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 25px 0 rgba(0, 0, 0, 0.1);
        }
        
        .form-input {
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.6rem 1rem;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.05);
            width: 100%;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        
        .form-select {
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.6rem 1rem;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.05);
            width: 100%;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        
        .form-textarea {
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.6rem 1rem;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.05);
            width: 100%;
            resize: vertical;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
            font-size: 0.875rem;
        }
        
        .form-error {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .section-header {
            padding: 1.25rem;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            color: white;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: #4f46e5;
            color: white;
            border: 1px solid transparent;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }
        
        .btn-secondary {
            background-color: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        
        .btn-secondary:hover {
            background-color: #f9fafb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .header-gradient {
            background: linear-gradient(120deg, #4f46e5, #9333ea);
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- En-tête avec bouton retour -->
        <div class="flex items-center mb-8">
            <a href="{{ route('doctor.patients') }}" class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-primary-600 hover:bg-primary-50 transition duration-300 mr-4 shadow-sm">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Modifier le patient: {{ $patient->user->name }}</h1>
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

        <!-- Formulaire de modification du patient -->
        <div class="form-card bg-white rounded-2xl overflow-hidden">
            <div class="section-header">
                <div class="flex items-center">
                    <i class="fas fa-user-edit text-white text-2xl mr-3"></i>
                    <h2 class="text-xl font-semibold">Informations du patient</h2>
                </div>
                <p class="text-primary-100 text-sm mt-1">Modifiez les informations du patient ci-dessous</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('doctor.patients.update', $patient->user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-8">
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <i class="fas fa-user-circle text-primary-500 text-xl mr-3"></i>
                            <h3 class="text-lg font-medium text-gray-800">Informations personnelles</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user text-primary-400 mr-2"></i>
                                    Nom complet <span class="text-danger-500">*</span>
                                </label>
                                
                                <input type="text" name="name" id="name" value="{{ old('name', $patient->user->name) }}" class="form-input" required>
                                @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope text-primary-400 mr-2"></i>
                                    Adresse e-mail <span class="text-danger-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $patient->user->email) }}" class="form-input" required>
                                @error('email')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone text-primary-400 mr-2"></i>
                                    Téléphone <span class="text-danger-500">*</span>
                                </label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->user->phone) }}" class="form-input" required>
                                @error('phone')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="gender" class="form-label">
                                    <i class="fas fa-venus-mars text-primary-400 mr-2"></i>
                                    Genre <span class="text-danger-500">*</span>
                                </label>
                                <select name="gender" id="gender" class="form-select">
                                    <option value="">Sélectionner</option>
                                    <option value="Homme" {{ old('gender', $patient->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                                    <option value="Femme" {{ old('gender', $patient->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                                    <option value="Autre" {{ old('gender', $patient->gender) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('gender')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="birthdate" class="form-label">
                                    <i class="fas fa-birthday-cake text-primary-400 mr-2"></i>
                                    Date de naissance <span class="text-danger-500">*</span>
                                </label>
                                <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate', $patient->user->date_of_birth ? (\Carbon\Carbon::parse($patient->user->date_of_birth)->format('Y-m-d')) : '') }}" class="form-input" required>
                                @error('birthdate')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-marker-alt text-primary-400 mr-2"></i>
                                    Adresse
                                </label>
                                <input type="text" name="address" id="address" value="{{ old('address', $patient->user->address) }}" class="form-input">
                                @error('address')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <i class="fas fa-heartbeat text-primary-500 text-xl mr-3"></i>
                            <h3 class="text-lg font-medium text-gray-800">Informations médicales</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="blood_type" class="form-label">
                                    <i class="fas fa-tint text-danger-500 mr-2"></i>
                                    Groupe sanguin
                                </label>
                                <select name="blood_type" id="blood_type" class="form-select">
                                    <option value="">Sélectionner</option>
                                    <option value="A+" {{ old('blood_type', $patient->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_type', $patient->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_type', $patient->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_type', $patient->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_type', $patient->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_type', $patient->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_type', $patient->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_type', $patient->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_type')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="emergency_contact" class="form-label">
                                    <i class="fas fa-phone-alt text-primary-400 mr-2"></i>
                                    Contact d'urgence
                                </label>
                                <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact) }}" class="form-input">
                                @error('emergency_contact')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="height" class="form-label">
                                    <i class="fas fa-ruler-vertical text-primary-400 mr-2"></i>
                                    Taille (cm)
                                </label>
                                <input type="number" step="0.01" name="height" id="height" value="{{ old('height', $patient->height) }}" class="form-input">
                                @error('height')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="weight" class="form-label">
                                    <i class="fas fa-weight text-primary-400 mr-2"></i>
                                    Poids (kg)
                                </label>
                                <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight', $patient->weight) }}" class="form-input">
                                @error('weight')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group md:col-span-2">
                                <label for="allergies" class="form-label">
                                    <i class="fas fa-allergies text-danger-500 mr-2"></i>
                                    Allergies
                                </label>
                                <textarea name="allergies" id="allergies" rows="3" class="form-textarea">{{ old('allergies', is_array($patient->allergies) ? implode(', ', $patient->allergies) : $patient->allergies) }}</textarea>
                                <p class="text-gray-500 text-xs mt-1">Séparez les allergies par des virgules (ex: Pénicilline, Arachides, Lactose)</p>
                                @error('allergies')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group md:col-span-2">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-sticky-note text-warning-500 mr-2"></i>
                                    Notes
                                </label>
                                <textarea name="notes" id="notes" rows="4" class="form-textarea">{{ old('notes', $patient->notes) }}</textarea>
                                @error('notes')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('doctor.patients') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Mettre à jour le patient
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Effet de focus sur les champs
            $('.form-input, .form-select, .form-textarea').focus(function() {
                $(this).parent().find('.form-label').addClass('text-primary-600');
            }).blur(function() {
                $(this).parent().find('.form-label').removeClass('text-primary-600');
            });
            
            // Animation pour les boutons
            $('.btn').hover(
                function() {
                    $(this).addClass('shadow-md');
                },
                function() {
                    $(this).removeClass('shadow-md');
                }
            );
        });
    </script>
</body>
</html>