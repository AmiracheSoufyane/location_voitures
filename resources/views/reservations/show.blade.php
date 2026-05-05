
<!-- ¨!!!!!!!!!!!!!!!!!!!!!!! Not Working Yet !!!!!!!!!!!!!!!!!!!! Makhdamach !!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
@extends('_layout')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Actions -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('reservations.index') }}" class="p-2 bg-white rounded-full shadow-sm hover:bg-gray-100 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Contrat #RES-{{ $reservation->id }}</h2>
                <p class="text-sm text-gray-500">
                Créé le {{ $reservation->created_at ? $reservation->created_at->format('d/m/Y à H:i') : 'Date non disponible' }}
            </p>
            </div>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="flex items-center gap-2 bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all font-medium">
                <i data-lucide="printer" class="w-4 h-4"></i> Imprimer
            </button>
            <button class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all font-medium shadow-md">
                <i data-lucide="download" class="w-4 h-4"></i> PDF
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Contract Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Période et Prix -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex justify-between items-start mb-8">
                    <div class="space-y-1">
                        <span class="text-xs font-bold uppercase text-blue-600 tracking-wider">Période de location</span>
                        <div class="flex items-center gap-4 text-xl font-bold text-gray-800">
                            <span>{{ \Carbon\Carbon::parse($reservation->date_start)->format('d M Y') }}</span>
                            <i data-lucide="arrow-right" class="text-gray-300"></i>
                            <span>{{ \Carbon\Carbon::parse($reservation->date_end)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold uppercase text-gray-400 tracking-wider">Montant Total</span>
                        <div class="text-3xl font-black text-gray-900">{{ number_format($reservation->price, 2) }} <span class="text-lg font-medium">DH</span></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 pt-8 border-t border-dashed border-gray-100">
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase mb-4">Informations Véhicule</h4>
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-50 rounded-2xl">
                                <i data-lucide="car" class="w-8 h-8 text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-lg">{{ $reservation->car->brand }} {{ $reservation->car->model }}</p>
                                <p class="text-sm text-gray-500 font-mono">{{ $reservation->car->registration }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase mb-4">Agent Responsable</h4>
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-gray-50 rounded-2xl">
                                <i data-lucide="shield-check" class="w-8 h-8 text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $reservation->user->name ?? 'Système' }}</p>
                                <p class="text-sm text-gray-500">Validation certifiée</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clauses rapides (Style professionnel) -->
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                <h4 class="font-bold text-gray-700 mb-3">Conditions de retour :</h4>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start gap-2 italic">
                        <i data-lucide="info" class="w-4 h-4 mt-0.5 text-blue-500"></i>
                        Le véhicule doit être rendu avec le même niveau de carburant qu'au départ.
                    </li>
                    <li class="flex items-start gap-2 italic">
                        <i data-lucide="info" class="w-4 h-4 mt-0.5 text-blue-500"></i>
                        Toute heure de retard sera facturée selon le tarif en vigueur.
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar: Client Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-900 p-6 text-white text-center">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-gray-700">
                        <i data-lucide="user" class="w-10 h-10 text-gray-400"></i>
                    </div>
                    <h3 class="font-bold text-xl">{{ $reservation->client->name }}</h3>
                    <p class="text-sm text-gray-400">{{ $reservation->client->national_id }}</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Téléphone</span>
                        <span class="font-medium text-gray-800">-- -- -- --</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">N° Permis</span>
                        <span class="font-medium text-gray-800">{{ $reservation->client->license_number }}</span>
                    </div>
                    <div class="pt-4">
                        <a href="{{ route('clients.show', $reservation->client->id) }}" class="block w-full text-center py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                            Consulter le dossier complet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>