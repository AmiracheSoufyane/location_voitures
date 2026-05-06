@extends('_layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('reservations.index') }}" class="p-2 bg-white rounded-full shadow-sm hover:bg-gray-100 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Détails du Contrat #{{ substr($reservation->id, 0, 8) }}</h2>
        </div>
        
        <div class="flex gap-3">
            <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors">
                <i data-lucide="printer" class="w-4 h-4"></i> Imprimer
            </button>
            <a href="{{ route('reservations.edit', $reservation->id) }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors">
                <i data-lucide="edit-3" class="w-4 h-4"></i> Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Colonne Gauche : Client et Véhicule -->
        <div class="md:col-span-2 space-y-6">
            <!-- Infos Client -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="user" class="text-blue-500"></i> Informations Client
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Nom Complet</p>
                        <p class="text-gray-800 font-medium">{{ $reservation->client->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">CIN / ID</p>
                        <p class="text-gray-800 font-medium">{{ $reservation->client->national_id }}</p>
                    </div>
                </div>
            </div>

            <!-- Infos Véhicule -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="car" class="text-blue-500"></i> Détails du Véhicule
                </h3>
                <div class="flex items-center gap-6">
                    <div class="p-4 bg-blue-50 rounded-2xl">
                        <i data-lucide="car" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <div class="grid grid-cols-2 flex-1 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Modèle</p>
                            <p class="text-gray-800 font-medium">{{ $reservation->car->brand }} {{ $reservation->car->model }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Immatriculation</p>
                            <span class="px-2 py-1 bg-gray-100 border border-gray-200 rounded text-sm font-mono tracking-wider font-bold">
                                {{ $reservation->car->registration }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Résumé financier et dates -->
        <div class="space-y-6">
            <div class="bg-blue-600 p-6 rounded-3xl shadow-lg text-white">
                <h3 class="text-sm font-bold opacity-80 mb-4 uppercase">Résumé du Contrat</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-blue-500 pb-2">
                        <span class="text-sm">Début</span>
                        <span class="font-bold">{{ \Carbon\Carbon::parse($reservation->date_start)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-blue-500 pb-2">
                        <span class="text-sm">Fin</span>
                        <span class="font-bold">{{ \Carbon\Carbon::parse($reservation->date_end)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-blue-500 pb-2">
                        <span class="text-sm">Durée</span>
                        <span class="font-bold">
                            {{ \Carbon\Carbon::parse($reservation->date_start)->diffInDays($reservation->date_end) }} jours
                        </span>
                    </div>
                    <div class="pt-2">
                        <p class="text-xs opacity-80 uppercase font-bold mb-1">Montant Total</p>
                        <p class="text-3xl font-black">{{ number_format($reservation->price, 2) }} <span class="text-lg">DH</span></p>
                    </div>
                </div>
            </div>

            <!-- Statut du contrat -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center">
                 <p class="text-xs text-gray-500 uppercase font-bold mb-2">Statut</p>
                 @php
                    $now = now();
                    $start = \Carbon\Carbon::parse($reservation->date_start);
                    $end = \Carbon\Carbon::parse($reservation->date_end);
                 @endphp

                 @if($now->between($start, $end))
                    <span class="inline-flex items-center px-4 py-1 rounded-full bg-green-100 text-green-700 text-sm font-bold">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span> En cours
                    </span>
                 @elseif($now->lt($start))
                    <span class="inline-flex items-center px-4 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-bold">
                         À venir
                    </span>
                 @else
                    <span class="inline-flex items-center px-4 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-bold">
                         Terminé
                    </span>
                 @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) lucide.createIcons();
    });
</script>
@endsection