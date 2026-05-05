@extends('_layout')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Fil d'Ariane / Titre -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Créer un Nouveau Contrat</h2>
        <p class="text-gray-600">Remplissez les informations pour générer la réservation.</p>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <form action="{{ route('reservations.store') }}" method="POST" class="p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Sélection du Client -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4"></i> Client
                    </label>
                    <select name="client_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 bg-gray-50">
                        <option value="" disabled selected>Choisir un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->national_id }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sélection de la Voiture -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="car" class="w-4 h-4"></i> Véhicule
                    </label>
                    <select name="car_id" id="car_select" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 bg-gray-50">
                        <option value="" disabled selected>Choisir une voiture</option>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}" data-price="{{ $car->price_per_day }}">
                                {{ $car->brand }} {{ $car->model }} ({{ $car->registration }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date de début -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4"></i> Date de début
                    </label>
                    <input type="date" name="date_start" id="date_start" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 bg-gray-50">
                </div>

                <!-- Date de fin -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i> Date de fin
                    </label>
                    <input type="date" name="date_end" id="date_end"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 bg-gray-50">
                </div>

                <!-- Prix Total -->
                <div class="col-span-2 bg-blue-50 p-4 rounded-xl border border-blue-100 mt-2">
                    <label class="block text-sm font-semibold text-blue-800 mb-2 flex items-center gap-2">
                        <i data-lucide="banknote" class="w-5 h-5"></i> Prix Total Estimé (DH)
                    </label>
                    <input type="number" name="price" id="total_price" step="0.01" readonly
                        class="w-full bg-white border-blue-200 rounded-lg text-xl font-bold text-blue-700 p-3 shadow-inner cursor-not-allowed">
                    <p class="text-xs text-blue-600 mt-2 italic">* Le prix est calculé automatiquement selon la durée et le tarif journalier.</p>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex items-center justify-end gap-4 border-t pt-6">
                <a href="{{ route('cars') }}" class="text-gray-600 hover:text-gray-800 font-medium">Annuler</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> Finaliser le Contrat
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT DE CALCUL AUTOMATIQUE -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carSelect = document.getElementById('car_select');
        const dateStart = document.getElementById('date_start');
        const dateEnd = document.getElementById('date_end');
        const totalPrice = document.getElementById('total_price');

        function calculatePrice() {
            const selectedCar = carSelect.options[carSelect.selectedIndex];
            const pricePerDay = selectedCar ? selectedCar.getAttribute('data-price') : 0;
            
            const start = new Date(dateStart.value);
            const end = new Date(dateEnd.value);

            if (start && end && end > start && pricePerDay) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                totalPrice.value = (diffDays * pricePerDay).toFixed(2);
            } else {
                totalPrice.value = 0;
            }
        }

        [carSelect, dateStart, dateEnd].forEach(el => el.addEventListener('change', calculatePrice));
    });
</script>

@endsection