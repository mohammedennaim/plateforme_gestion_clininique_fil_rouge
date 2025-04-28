@extends('layouts.admin')

@section('title', 'Détails du Patient')

@section('page-title', 'Détails du Patient')

@section('content')
<div class="container-fluid fade-in">
    <!-- En-tête de page avec boutons d'action -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="md:flex justify-between items-center p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-full overflow-hidden border-4 border-primary-100 mr-4 flex-shrink-0">
                    <img class="w-full h-full object-cover" 
                         src="{{ $patient->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($patient->user->name) . '&color=ffffff&background=4E73DF&size=256' }}" 
                         alt="{{ $patient->user->name }}">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $patient->user->name }}</h1>
                    <div class="flex items-center mt-1">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $patient->user->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <span class="status-dot {{ $patient->user->active ? 'status-active' : 'status-inactive' }}"></span>
                            {{ $patient->user->active ? 'Actif' : 'Inactif' }}
                        </span>
                        
                        @if($patient->blood_type)
                            <span class="ml-2 px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                <i class="fas fa-tint mr-1 text-red-600"></i>
                                {{ $patient->blood_type }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow-sm hover:bg-gray-600 transition-colors flex items-center text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
                <a href="{{ route('admin.patients.edit', $patient->id) }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow-sm hover:bg-primary-700 transition-colors flex items-center text-sm">
                    <i class="fas fa-edit mr-2"></i> Modifier
                </a>
                <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-sm hover:bg-red-700 transition-colors flex items-center text-sm" data-bs-toggle="modal" data-bs-target="#deletePatientModal">
                    <i class="fas fa-trash mr-2"></i> Supprimer
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Carte d'informations personnelles -->
        <div class="xl:col-span-1">
            <!-- Informations personnelles -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 hover-card">
                <div class="px-6 py-4 bg-gradient-to-r from-primary-600 to-primary-800 text-white">
                    <h2 class="text-lg font-bold flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        Informations personnelles
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-birthday-cake text-primary-500 mr-2"></i>
                                Date de naissance
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $patient->birth_date ? $patient->birth_date->format('d/m/Y') : 'Non renseigné' }}</div>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-hourglass-half text-primary-500 mr-2"></i>
                                Âge
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $patient->birth_date ? $patient->birth_date->age . ' ans' : 'Non renseigné' }}</div>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-venus-mars text-primary-500 mr-2"></i>
                                Sexe
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $patient->gender ?? 'Non renseigné' }}</div>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-envelope text-primary-500 mr-2"></i>
                                Email
                            </div>
                            <div class="text-gray-800 font-semibold truncate max-w-[60%]">{{ $patient->user->email }}</div>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-phone text-primary-500 mr-2"></i>
                                Téléphone
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $patient->user->phone ?? 'Non renseigné' }}</div>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                                Adresse
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $patient->address ?? 'Non renseigné' }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-calendar-check text-primary-500 mr-2"></i>
                                Dernière visite
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $patient->derniere_visite ? $patient->derniere_visite->format('d/m/Y') : 'Jamais' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations d'assurance -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 hover-card">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-700 text-white">
                    <h2 class="text-lg font-bold flex items-center">
                        <i class="fas fa-file-medical-alt mr-2"></i>
                        Informations d'assurance
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-building text-blue-500 mr-2"></i>
                                Compagnie
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $patient->name_assurance ?? 'Non renseigné' }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div class="text-gray-500 font-medium">
                                <i class="fas fa-id-card text-blue-500 mr-2"></i>
                                Numéro
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $patient->assurance_number ?? 'Non renseigné' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact d'urgence -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-card">
                <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-red-700 text-white">
                    <h2 class="text-lg font-bold flex items-center">
                        <i class="fas fa-ambulance mr-2"></i>
                        Contact d'urgence
                    </h2>
                </div>
                <div class="p-6">
                    @if($patient->emergency_contact)
                        <div class="space-y-3">
                            <div class="text-gray-800">{{ $patient->emergency_contact }}</div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-4 text-gray-400">
                            <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                            <p>Aucun contact d'urgence enregistré</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="xl:col-span-2">
            <!-- Historique des rendez-vous -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 hover-card">
                <div class="px-6 py-4 bg-gradient-to-r from-primary-600 to-primary-800 flex justify-between items-center text-white">
                    <h2 class="text-lg font-bold flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Historique des rendez-vous
                    </h2>
                    <button class="px-3 py-1.5 bg-white text-primary-600 rounded-lg shadow-sm hover:bg-gray-100 transition-colors text-sm font-medium" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                        <i class="fas fa-plus mr-1"></i> Nouveau rendez-vous
                    </button>
                </div>
                <div class="p-6">
                    @if($patient->appointments && $patient->appointments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 rounded-tl-lg">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Médecin</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Motif</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Statut</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($patient->appointments->sortByDesc('date') as $appointment)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $appointment->date->format('d/m/Y') }}</div>
                                                <div class="text-sm text-primary-600">{{ $appointment->time }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 rounded-full overflow-hidden">
                                                        <img class="h-full w-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($appointment->doctor->user->name) }}&color=ffffff&background=4E73DF&size=256" alt="{{ $appointment->doctor->user->name }}">
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-medium text-gray-900">Dr. {{ $appointment->doctor->user->name }}</div>
                                                        <div class="text-xs text-gray-500">{{ $appointment->doctor->speciality->name ?? 'Médecin généraliste' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs">{{ $appointment->reason }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($appointment->status == 'confirmed')
                                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        <span class="status-dot status-active"></span>
                                                        Confirmé
                                                    </span>
                                                @elseif($appointment->status == 'pending')
                                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        <span class="status-dot status-pending"></span>
                                                        En attente
                                                    </span>
                                                @elseif($appointment->status == 'canceled')
                                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        <span class="status-dot status-inactive"></span>
                                                        Annulé
                                                    </span>
                                                @elseif($appointment->status == 'completed')
                                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        <span class="status-dot status-active"></span>
                                                        Terminé
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="p-1.5 rounded-full text-primary-600 hover:bg-primary-50 transition-colors" data-tooltip="Voir les détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="p-1.5 rounded-full text-indigo-600 hover:bg-indigo-50 transition-colors" data-tooltip="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors" data-tooltip="Annuler">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                            <i class="fas fa-calendar-times text-5xl mb-4"></i>
                            <p class="text-lg">Aucun rendez-vous enregistré</p>
                            <button class="mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg shadow-sm hover:bg-primary-700 transition-colors text-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                                <i class="fas fa-plus mr-2"></i> Ajouter un rendez-vous
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Historique médical -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 hover-card">
                <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-green-800 text-white">
                    <h2 class="text-lg font-bold flex items-center">
                        <i class="fas fa-notes-medical mr-2"></i>
                        Historique médical
                    </h2>
                </div>
                <div class="p-6">
                    @if($patient->medical_history)
                        <div class="prose prose-sm max-w-none">
                            {!! nl2br(e($patient->medical_history)) !!}
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                            <i class="fas fa-file-medical-alt text-5xl mb-4"></i>
                            <p class="text-lg">Aucun historique médical enregistré</p>
                            <a href="{{ route('admin.patients.edit', $patient->id) }}#medical-history" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg shadow-sm hover:bg-green-700 transition-colors text-sm">
                                <i class="fas fa-plus mr-2"></i> Ajouter un historique médical
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression du patient -->
<div class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50" id="deletePatientModal">
    <div class="relative w-full max-w-lg mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="px-6 py-4 bg-red-600 text-white flex justify-between items-center">
                <h3 class="text-lg font-bold">Confirmer la suppression</h3>
                <button type="button" class="text-white hover:text-gray-200 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-1">Êtes-vous sûr ?</h4>
                    <p class="text-gray-600 mb-5">Vous êtes sur le point de supprimer le patient <strong>{{ $patient->user->name }}</strong>. Cette action est irréversible.</p>
                    
                    <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash-alt mr-2"></i> Supprimer définitivement
                        </button>
                    </form>
                    <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-colors ml-2 cancel-modal">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout de rendez-vous -->
<div class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50" id="addAppointmentModal">
    <div class="relative w-full max-w-2xl mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="px-6 py-4 bg-primary-600 text-white flex justify-between items-center">
                <h3 class="text-lg font-bold">Nouveau rendez-vous</h3>
                <button type="button" class="text-white hover:text-gray-200 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="" method="POST" id="appointment-form">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-1">Médecin</label>
                            <select id="doctor_id" name="doctor_id" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Sélectionner un médecin</option>
                                @foreach(\App\Models\Doctor::with('user', 'speciality')->get() as $doctor)
                                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} - {{ $doctor->speciality->name ?? 'Médecin généraliste' }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="speciality_id" class="block text-sm font-medium text-gray-700 mb-1">Service/Spécialité</label>
                            <select id="speciality_id" name="speciality_id" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Sélectionner une spécialité</option>
                                @foreach(\App\Models\Speciality::all() as $speciality)
                                    <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" id="date" name="date" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                        
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Heure</label>
                            <input type="time" id="time" name="time" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Motif de la consultation</label>
                        <textarea id="reason" name="reason" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-colors cancel-modal">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            <i class="fas fa-calendar-check mr-2"></i> Planifier le rendez-vous
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des modals
        const modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
        const closeModalButtons = document.querySelectorAll('.close-modal, .cancel-modal');
        
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const modalId = this.getAttribute('data-bs-target');
                document.querySelector(modalId).classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });
        
        closeModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('.fixed');
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        });
        
        // Vérification de la disponibilité du médecin lors de la prise de rendez-vous
        const doctorId = document.getElementById('doctor_id');
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        
        // Fonction pour vérifier la disponibilité
        function checkDoctorAvailability() {
            if (doctorId.value && dateInput.value && timeInput.value) {
                // Ici, vous pourriez faire une requête AJAX pour vérifier la disponibilité
                
                // Créer un élément pour le message d'information s'il n'existe pas déjà
                let infoMessage = document.getElementById('availability_message');
                if (!infoMessage) {
                    infoMessage = document.createElement('div');
                    infoMessage.id = 'availability_message';
                    timeInput.parentNode.appendChild(infoMessage);
                }
                
                infoMessage.innerHTML = '<div class="flex items-center mt-2"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Vérification de la disponibilité...</div>';
                infoMessage.className = 'text-sm text-primary-600';
                
                // Simulation d'une vérification asynchrone
                setTimeout(() => {
                    // Dans un cas réel, vous récupéreriez cette information du serveur
                    const isAvailable = Math.random() > 0.3; // 70% de chance d'être disponible
                    
                    if (isAvailable) {
                        infoMessage.innerHTML = '<div class="flex items-center mt-2"><svg class="h-4 w-4 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>Ce créneau est disponible!</div>';
                        infoMessage.className = 'text-sm text-green-600';
                    } else {
                        infoMessage.innerHTML = '<div class="flex items-center mt-2"><svg class="h-4 w-4 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>Ce médecin n\'est pas disponible à cette date/heure. Veuillez choisir un autre moment.</div>';
                        infoMessage.className = 'text-sm text-red-600';
                    }
                }, 1000);
            }
        }
        
        // Filtre des médecins par spécialité
        const specialitySelect = document.getElementById('speciality_id');
        if (specialitySelect) {
            specialitySelect.addEventListener('change', function() {
                const specialityId = this.value;
                const doctorOptions = doctorId.querySelectorAll('option');
                
                // Réinitialiser la liste des médecins
                doctorId.value = '';
                
                // Si pas de spécialité sélectionnée, afficher tous les médecins
                if (!specialityId) {
                    doctorOptions.forEach(option => {
                        option.style.display = '';
                    });
                    return;
                }
                
                // Filtrer les médecins par spécialité
                // Dans un cas réel, vous feriez une requête AJAX pour obtenir les médecins par spécialité
                // Pour l'exemple, nous supposerons que les médecins ont un attribut data-speciality
                doctorOptions.forEach(option => {
                    if (option.getAttribute('data-speciality') === specialityId || option.value === '') {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });
            });
        }
        
        // Ajouter des écouteurs d'événements pour déclencher la vérification
        if (doctorId && dateInput && timeInput) {
            doctorId.addEventListener('change', checkDoctorAvailability);
            dateInput.addEventListener('change', checkDoctorAvailability);
            timeInput.addEventListener('change', checkDoctorAvailability);
        }
        
        // Configuration des dates minimales
        if (dateInput) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${yyyy}-${mm}-${dd}`;
            dateInput.setAttribute('min', formattedDate);
        }
    });
</script>
@endsection