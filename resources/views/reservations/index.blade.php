@extends('_layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Gestion des Contrats</h2>
        <p class="text-gray-600 text-sm">Liste de toutes les réservations et locations en cours.</p>
    </div>
    <a href="{{ route('reservations.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 hover:bg-blue-700 shadow-lg transition-all">
        <i data-lucide="plus-circle" class="w-5 h-5"></i> Nouveau Contrat
    </a>
</div>

<div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="p-4 font-bold text-gray-700 text-sm uppercase">Référence</th>
                <th class="p-4 font-bold text-gray-700 text-sm uppercase">Client</th>
                <th class="p-4 font-bold text-gray-700 text-sm uppercase">Véhicule</th>
                <th class="p-4 font-bold text-gray-700 text-sm uppercase">Période</th>
                <th class="p-4 font-bold text-gray-700 text-sm uppercase">Prix Total</th>
                <th class="p-4 font-bold text-gray-700 text-sm uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($reservations as $reservation)
            <tr class="hover:bg-blue-50/30 transition-colors">
                <td class="p-4">
                    <span class="font-mono text-sm font-bold text-blue-600">#RES-{{ $reservation->id }}</span>
                </td>
                <td class="p-4">
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-800">{{ $reservation->client->name }}</span>
                        <span class="text-xs text-gray-500">{{ $reservation->client->national_id }}</span>
                    </div>
                </td>
                <td class="p-4 text-gray-700 text-sm">
                    {{ $reservation->car->brand }} {{ $reservation->car->model }}
                    <div class="text-[10px] bg-gray-100 px-1.5 py-0.5 rounded w-fit mt-1">{{ $reservation->car->registration }}</div>
                </td>
                <td class="p-4 text-sm">
                    <div class="flex flex-col">
                        <span class="flex items-center gap-1 text-green-600 font-medium">
                            <i data-lucide="calendar-arrow-right" class="w-3 h-3"></i> {{ \Carbon\Carbon::parse($reservation->date_start)->format('d/m/Y') }}
                        </span>
                        <span class="flex items-center gap-1 text-red-500 font-medium">
                            <i data-lucide="calendar-arrow-down" class="w-3 h-3"></i> {{ \Carbon\Carbon::parse($reservation->date_end)->format('d/m/Y') }}
                        </span>
                    </div>
                </td>
                <td class="p-4">
                    <span class="text-lg font-bold text-gray-900">{{ number_format($reservation->price, 2) }} DH</span>
                </td>
                <td class="p-4">
                    <div class="flex gap-2">
                        <a href="{{ route('reservations.show', $reservation->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600" title="Voir le contrat">
                            Detail
                        </a>
                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Modifier</a>
                        <button class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Imprimer">
                            <i data-lucide="printer" class="w-5 h-5"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-12 text-center">
                    <div class="flex flex-col items-center">
                        <i data-lucide="folder-open" class="w-12 h-12 text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Aucune réservation enregistrée pour le moment.</p>
                        <a href="{{ route('reservations.create') }}" class="text-blue-600 hover:underline mt-2">Créer votre premier contrat</a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection