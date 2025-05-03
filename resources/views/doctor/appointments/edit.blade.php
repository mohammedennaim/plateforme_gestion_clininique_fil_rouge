<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Rendez-vous</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            100: '#e0f2fe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8'
                        }
                    },
                    boxShadow: {
                        'custom': '0 4px 20px rgba(0, 0, 0, 0.08)',
                        'input': '0 2px 4px rgba(0, 0, 0, 0.05)'
                    },
                    borderRadius: {
                        'xl': '0.75rem',
                        '2xl': '1rem'
                    },
                    transitionProperty: {
                        'height': 'height',
                        'spacing': 'margin, padding'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .form-input, .form-select, .form-textarea {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
            outline: none;
        }
        
        .section-card {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .section-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        .gradient-header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }
        
        .submit-btn {
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
    </style>
</head>

<body class="antialiased text-gray-800">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Modifier le Rendez-vous</h1>
            <div class="flex space-x-2">
                <a href="#" onclick="history.back()"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-300 flex items-center shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-custom overflow-hidden section-card">
            <div class="gradient-header text-white px-8 py-5">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-edit mr-3 text-2xl"></i>
                    Modifier le Rendez-vous
                </h2>
            </div>

            <div class="p-8">
                <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2 flex items-center">
                                <i class="fas fa-user-circle text-primary-600 mr-2"></i>
                                Informations du patient
                            </h3>
                            <div class="flex items-start mb-4 bg-white p-4 rounded-lg shadow-sm">
                                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 mr-4">
                                    <i class="fas fa-user text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-base font-medium">{{ $patient->user->name }}</h4>
                                    <div class="text-sm text-gray-600">{{ $patient->user->email }}</div>
                                    <div class="text-sm text-gray-600">{{ $patient->phone_number }}</div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                            <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                        </div>

                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2 flex items-center">
                                <i class="fas fa-calendar-alt text-primary-600 mr-2"></i>
                                Informations du rendez-vous
                            </h3>
                            
                            <div class="mb-4 space-y-1">
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" id="date" name="date" value="{{ $appointment->date->format('Y-m-d') }}" 
                                    class="w-full px-4 py-2 form-input">
                                @error('date')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 space-y-1">
                                <label for="time" class="block text-sm font-medium text-gray-700">Heure</label>
                                <input type="time" id="time" name="time" value="{{ $appointment->time->format('H:i') }}" 
                                    class="w-full px-4 py-2 form-input">
                                @error('time')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 space-y-1">
                                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                                <select id="status" name="status" class="w-full px-4 py-2 form-select">
                                    <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Terminé</option>
                                    <option value="canceled" {{ $appointment->status == 'canceled' ? 'selected' : '' }}>Annulé</option>
                                </select>
                                @error('status')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 space-y-1">
                                <label for="price" class="block text-sm font-medium text-gray-700">Prix (MAD)</label>
                                <div class="relative">
                                    <input type="number" id="price" name="price" value="{{ $appointment->price }}" 
                                        class="w-full px-4 py-2 form-input">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">MAD</span>
                                    </div>
                                </div>
                                @error('price')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2 flex items-center">
                            <i class="fas fa-clipboard text-primary-600 mr-2"></i>
                            Détails supplémentaires
                        </h3>
                        
                        <div class="mb-4 space-y-1">
                            <label for="reason" class="block text-sm font-medium text-gray-700">Notes (facultatif)</label>
                            <textarea id="reason" name="reason" rows="4" 
                                class="w-full px-4 py-2 form-textarea">{{ $appointment->reason }}</textarea>
                            @error('reason')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 submit-btn flex items-center shadow-lg">
                            <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>