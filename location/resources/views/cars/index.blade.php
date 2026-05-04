@extends('_layout')

@section('content')
<form class="max-w-md mx-auto mb-6" method="GET" action="{{ route('cars') }}">

    <label class="sr-only">Search</label>

    <div class="relative">

        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
            <i data-lucide="search" class="w-4 h-4 text-gray-500"></i>
        </div>

        <input type="search"
            name="mat"
            value="{{ $mat }}"
            placeholder="Immatriculation..."
            class="block w-full p-3 pl-10 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">

        <div class="absolute right-1.5 bottom-1.5 flex gap-1">

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-2.5 rounded-md">
                Chercher
            </button>

            <a href="{{ route('cars') }}"
                class="bg-gray-400 hover:bg-gray-500 text-white text-xs px-3 py-2.5 rounded-md">
                Annuler
            </a>

        </div>

    </div>

</form>

<a href="{{route('cars.add')}}">Ajouter</a>
@if(session('success'))
    <div class="max-w-4xl mx-auto mb-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">

            <i data-lucide="check-circle" class="w-5 h-5"></i>

            <span>{{ session('success') }}</span>

        </div>
    </div>
@endif

<div class="p-4 sm:p-6">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($cars as $car)
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                <div class="h-48 w-full overflow-hidden">
                  <img src="{{ asset('storage/' . $car->image) }}"
                      class="w-full h-full object-cover hover:scale-105 transition duration-300">
              </div>

                <div class="p-4 space-y-2">

                    <h2 class="text-lg font-bold text-gray-800">
                        {{ $car->brand }} - {{ $car->model }}
                    </h2>

                    <p class="text-sm text-gray-600">
                        Année : {{ $car->year }}
                    </p>

                    <p class="text-sm text-gray-600">
                        Carburant : {{ $car->fuel_type }}
                    </p>

                    <p class="text-sm text-gray-600">
                        Kilométrage : {{ $car->mileage }} km
                    </p>

                    <p class="text-sm text-gray-600">
                        Statut : 
                        <span class="font-semibold 
                            {{ $car->status == 'disponible' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $car->status }}
                        </span>
                    </p>

                    <p class="text-blue-600 font-bold">
                        {{ $car->price_per_day }} MAD / jour
                    </p>

                    <p class="text-xs text-gray-400">
                        Immatriculation : {{ $car->registration }}
                    </p>
                    <a href="{{route('cars.show',$car->id)}}">Détail</a>
                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection