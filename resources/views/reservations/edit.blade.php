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
                
                <!-- Sélection Client -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Client</label>
                    <select name="client_id" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $reservation->client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} ({{ $client->national_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sélection Voiture -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Véhicule</label>
                    <select name="car_id" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}" {{ $reservation->car_id == $car->id ? 'selected' : '' }}>
                                {{ $car->brand }} {{ $car->model }} ({{ $car->registration }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Début -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Date de début</label>
                    <input type="date" name="date_start" value="{{ old('date_start', $reservation->date_start) }}" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Date Fin -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Date de fin</label>
                    <input type="date" name="date_end" value="{{ old('date_end', $reservation->date_end) }}" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Prix -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-bold text-gray-700">Prix Total (DH)</label>
                    <div class="relative">
                        <input type="number" name="price" value="{{ old('price', $reservation->price) }}" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 pl-12">
                        <span class="absolute left-4 top-3.5 text-gray-400 font-bold">DH</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <button type="reset" class="px-6 py-3 text-gray-600 font-medium hover:text-gray-800 transition-colors">Annuler</button>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transform active:scale-95 transition-all">
                Mettre à jour le contrat
            </button>
        </div>
    </form>
</div>
@endsection