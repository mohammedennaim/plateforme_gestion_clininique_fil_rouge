<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Rendez-vous</title>
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
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Détails du Rendez-vous</h1>
            <div class="flex space-x-2">
                <a href="{{ route('doctor.appointments.edit',$appointment->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <a href="#" onclick="history.back()"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Rendez-vous n°12345
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Informations du patient -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">Informations du patient</h3>
                        <div class="flex items-start mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 mr-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-medium">Jean Dupont</h4>
                                <div class="text-sm text-gray-600">jean.dupont@email.com</div>
                                <div class="text-sm text-gray-600">+33 6 12 34 56 78</div>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Name de Assurance</span>
                                <span class="text-sm font-medium">{{ $patient->name_assurance }}</span>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Nombre de Assurance</span>
                                <span class="text-sm font-medium">{{ $patient->assurance_number }}</span>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Blood Type</span>
                                <span class="text-sm font-medium">{{ $patient->blood_type }}</span>
                            </div>

                            @if ($patient->emergency_contact)
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-xs text-gray-500 block">Contact d'urgence</span>
                                    <span class="text-sm font-medium">{{ $patient->emergency_contact }}</span>
                                </div>
                            @else
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-xs text-gray-500 block">Contact d'urgence</span>
                                    <span class="text-sm font-medium">Non renseigné</span>
                                </div>
                            @endif
                            
                           
                        </div>
                    </div>

                    <!-- Informations du rendez-vous -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">Informations du rendez-vous
                        </h3>

                        <div class="flex items-start mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 mr-3">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-medium">Dr. {{ $doctor->name }}</h4>
                                <div class="text-sm text-gray-600">{{ $speciality->name}}</div>
                            </div>
                        </div>

                        <div class="mt-9 grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Date</span>
                                <span class="text-sm font-medium">{{ $appointment->date->format('d/m/y') }}</span>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Heure</span>
                                <span class="text-sm font-medium">{{ $appointment->time->format('h:i') }}</span>
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="text-xs text-gray-500 block">Statut</span>
                                <span class="text-sm font-medium">
                                    @if($appointment->status == 'pending')
                                        <span
                                            class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                    @elseif($appointment->status == 'canceled')
                                        <span
                                            class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                    @elseif($appointment->status == 'completed')
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                    @elseif($appointment->status == 'confirmed')
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                    @else
                                        <span
                                            class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">Détails supplémentaires</h3>

                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <h4 class="text-base font-medium mb-2">Motif de la consultation</h4>
                        <p class="text-gray-700">{{ $appointment->reason }}</p>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-between items-center">
                    <div>
                        <form action="{{ route('doctor.appointments.destroy', $appointment->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous?')">
                                <i class="fas fa-trash mr-2"></i>Supprimer
                            </button>
                        </form>
                    </div>

                    <div class="flex space-x-2">
                        <form action="{{ route('doctor.appointments.change-status', $appointment->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="confirmed">

                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i>Confirmer
                            </button>
                        </form>
                        <form action="{{ route('doctor.appointments.change-status', $appointment->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="canceled">
                            <button type="submit"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                                <i class="fas fa-times mr-2"></i>Annuler
                            </button>
                        </form>

                        <form action="{{ route('doctor.appointments.change-status', $appointment->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-check-double mr-2"></i>Marquer comme terminé
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>