@extends('_layout')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Entête avec bouton retour -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('clients.index') }}" class="p-2 bg-white rounded-full shadow hover:bg-gray-100">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Dossier Client : {{ $client->name }}</h2>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('clients.edit', $client->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                        Modifier
                    </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Colonne Gauche : Infos Personnelles -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Informations</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">CIN / ID National</p>
                        <p class="text-gray-800 font-medium">{{ $client->national_id }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">N° Permis de conduire</p>
                        <p class="text-gray-800 font-medium">{{ $client->license_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Localisation</p>
                        <p class="text-gray-800 font-medium">{{ $client->city }}, {{ $client->country }}</p>
                        <p class="text-sm text-gray-600">{{ $client->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Historique rapide -->
            <div class="bg-gray-900 text-white p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-bold mb-2">Activité</h3>
                <p class="text-gray-400 text-sm mb-4">Historique des locations</p>
                <div class="text-3xl font-bold text-blue-400">{{ $client->reservations->count() }}</div>
                <p class="text-xs text-gray-500 mt-1">Contrats au total</p>
            </div>
        </div>

        <!-- Colonne Droite : Documents & Galerie -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <i data-lucide="file-text" class="text-blue-600"></i> Documents Numérisés
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Permis -->
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-gray-700">Permis (Recto/Verso)</p>
                        <div class="group relative overflow-hidden rounded-lg border">
                            <img src="{{ asset($client->license_image_front) }}" class="w-full h-32 object-cover transition-transform hover:scale-110">
                        </div>
                        <div class="group relative overflow-hidden rounded-lg border">
                            <img src="{{ asset($client->license_image_back) }}" class="w-full h-32 object-cover transition-transform hover:scale-110">
                        </div>
                    </div>

                    <!-- CIN -->
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-gray-700">CIN (Recto/Verso)</p>
                        <div class="group relative overflow-hidden rounded-lg border">
                            <img src="{{ asset($client->national_id_image_front) }}" class="w-full h-32 object-cover transition-transform hover:scale-110">
                        </div>
                        <div class="group relative overflow-hidden rounded-lg border">
                            <img src="{{ asset($client->national_id_image_back) }}" class="w-full h-32 object-cover transition-transform hover:scale-110">
                        </div>
                    </div>
                </div>
            </div>
            
            @if($client->notes)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl">
                <p class="text-sm font-bold text-yellow-800">Notes Internes :</p>
                <p class="text-sm text-yellow-700 mt-1">{{ $client->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

