@extends('_layout')

@section('content')


<div class="max-w-5xl mx-auto p-6">

    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden md:grid md:grid-cols-2">

        <div>

            <label for="zoom">
                <img src="{{ asset('storage/' . $car->image) }}"
                    class="w-full h-125 object-cover cursor-pointer">
            </label>

            <!-- hidden checkbox -->
            <input type="checkbox" id="zoom" class="hidden peer">

            <div class="fixed inset-0 bg-black/80 hidden peer-checked:flex items-center justify-center z-50">

                <label for="zoom" class="absolute inset-0 cursor-pointer"></label>

                <img src="{{ asset('storage/' . $car->image) }}"
                    class="max-w-4xl max-h-[90vh] rounded-xl shadow-lg">
            </div>

        </div>

        <div class="p-6 space-y-4">

            <h2 class="text-3xl font-bold text-gray-800">
                {{ $car->brand }} - {{ $car->model }}
            </h2>

            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                {{ $car->status == 'disponible' ? 'bg-green-100 text-green-700' : '' }}
                {{ $car->status == 'loué' ? 'bg-red-100 text-red-700' : '' }}
                {{ $car->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                {{ ucfirst($car->status) }}
            </span>

            <div class="grid grid-cols-2 gap-3 text-gray-600 text-sm mt-4">

                <p><span class="font-semibold">Année:</span> {{ $car->year }}</p>

                <p><span class="font-semibold">Carburant:</span> {{ $car->fuel_type }}</p>

                <p><span class="font-semibold">Kilométrage:</span> {{ $car->mileage }} km</p>

                <p><span class="font-semibold">Immatriculation:</span> {{ $car->registration }}</p>

            </div>

            <div class="text-2xl font-bold text-blue-600 mt-4">
                {{ $car->price_per_day }} MAD / jour
            </div>

            <div class="flex gap-3 mt-6">

                <a href="{{ route('cars.edit', $car->id) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Modifier
                </a>

                <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Supprimer cette voiture ?')"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Supprimer
                    </button>
                </form>

            </div>

        </div>

    </div>

    <div class="mt-6">
        <a href="{{ route('cars') }}"
            class="text-blue-600 hover:underline">
            ← Retour
        </a>
    </div>

</div>

@endsection