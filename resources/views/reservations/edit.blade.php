@extends('_layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('reservations.index') }}" class="p-2 bg-white rounded-full shadow-sm hover:bg-gray-100 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Modifier la Réservation #{{ $reservation->id }}</h2>
    </div>

    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Sélection Client (Recherche dynamique) -->
                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-gray-700">Client</label>
                    <input type="text" id="client_search" 
                        value="{{ $reservation->client?->name }}" 
                        placeholder="Chercher par nom ou CIN..."
                        class="w-full p-3 bg-gray-50 border @error('client_id') border-red-500 @else border-gray-200 @enderror rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id', $reservation->client_id) }}">
                    <div id="client_results" class="absolute z-20 w-full bg-white border rounded-xl mt-1 hidden shadow-xl max-h-60 overflow-y-auto"></div>
                    @error('client_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Sélection Voiture (Recherche dynamique) -->
                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-gray-700">Véhicule</label>
                    <input type="text" id="car_search" 
                        value="{{ $reservation->car?->brand }} {{ $reservation->car?->model }} ({{ $reservation->car?->registration }})" 
                        placeholder="Chercher par marque ou immatriculation..."
                        class="w-full p-3 bg-gray-50 border @error('car_id') border-red-500 @else border-gray-200 @enderror rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="hidden" name="car_id" id="car_id" value="{{ old('car_id', $reservation->car_id) }}">
                    <input type="hidden" id="daily_price" value="{{ $reservation->car?->daily_price }}">
                    <div id="car_results" class="absolute z-20 w-full bg-white border rounded-xl mt-1 hidden shadow-xl max-h-60 overflow-y-auto"></div>
                    @error('car_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Date Début -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Date de début</label>
                    <input type="date" name="date_start" id="date_start" 
                        value="{{ old('date_start', $reservation->date_start->format('Y-m-d')) }}" 
                        class="w-full p-3 bg-gray-50 border @error('date_start') border-red-500 @else border-gray-200 @enderror rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                    @error('date_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Date Fin -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Date de fin</label>
                    <input type="date" name="date_end" id="date_end" 
                        value="{{ old('date_end', $reservation->date_end->format('Y-m-d')) }}" 
                        class="w-full p-3 bg-gray-50 border @error('date_end') border-red-500 @else border-gray-200 @enderror rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                    @error('date_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Prix -->
                <div class="md:col-span-2 space-y-2">
                    <div class="flex justify-between">
                        <label class="text-sm font-bold text-gray-700">Prix Total (DH)</label>
                        <span class="text-[10px] text-blue-500 italic">Calculé automatiquement mais modifiable</span>
                    </div>
                    <div class="relative">
                        <input type="number" step="0.01" name="price" id="total_price" 
                            value="{{ old('price', $reservation->price) }}" 
                            class="w-full p-3 bg-blue-50/50 border @error('price') border-red-500 @else border-blue-100 @enderror rounded-xl outline-none focus:ring-2 focus:ring-blue-500 pl-12 font-bold text-blue-700">
                        <span class="absolute left-4 top-3.5 text-blue-300 font-bold">DH</span>
                    </div>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('reservations.index') }}" class="px-6 py-3 text-gray-600 font-medium hover:text-gray-800 transition-colors">Annuler</a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transform active:scale-95 transition-all">
                Mettre à jour le contrat
            </button>
        </div>
    </form>
</div>

{{-- Script pour le calcul du prix automatique --}}
<script>
    const startInput = document.getElementById('date_start');
    const endInput = document.getElementById('date_end');
    const priceInput = document.getElementById('total_price');
    const dailyPriceHidden = document.getElementById('daily_price');

    function calculatePrice() {
        const start = new Date(startInput.value);
        const end = new Date(endInput.value);
        const daily = parseFloat(dailyPriceHidden.value);

        if (start && end && end > start && daily) {
            const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            priceInput.value = (days * daily).toFixed(2);
        }
    }

    startInput.addEventListener('change', calculatePrice);
    endInput.addEventListener('change', calculatePrice);
</script>
@endsection