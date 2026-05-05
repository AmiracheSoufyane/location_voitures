@extends('_layout')

@section('content')
<div class="bg-white p-4 mb-6 rounded-2xl shadow-sm border border-gray-100">
    <form action="{{ route('maintenance.index', $car->id) }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-50">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Du</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition text-sm text-gray-700">
        </div>

        <div class="flex-1 min-w-50">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Au</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition text-sm text-gray-700">
        </div>

        <div class="flex gap-2">
            <button type="submit" 
                    class="px-5 py-2 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-900 transition-all flex items-center gap-2 text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtrer
            </button>

            @if(request('start_date') || request('end_date'))
                <a href="{{ route('maintenance.index', $car->id) }}" 
                   class="px-5 py-2 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 transition-all text-sm flex items-center">
                    Effacer
                </a>
            @endif
        </div>
    </form>
</div>
<div class="max-w-6xl mx-auto my-12 px-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Historique de Maintenance
            </h1>
            <p class="text-gray-500 mt-1 flex items-center gap-2">
                Véhicule : <span class="font-semibold text-blue-600">{{ $car->brand }} {{ $car->model }}</span> 
                <span class="text-xs bg-gray-100 px-2 py-1 rounded font-mono border border-gray-200">{{ $car->registration }}</span>
            </p>
        </div>

        <a href="{{ route('maintenance.create', $car->id) }}" 
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajouter une intervention
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Type d'intervention</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Kilométrage</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Coût</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($car->maintenances as $maintenance)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="block font-bold text-gray-700">
                                {{ \Carbon\Carbon::parse($maintenance->maintenance_date)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-800 font-medium leading-relaxed max-w-xs">
                                {{ $maintenance->type }}
                            </p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span class="text-sm text-gray-600 font-mono">{{ number_format($maintenance->mileage, 0, ',', ' ') }} Km</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                {{ number_format($maintenance->cost, 2, ',', ' ') }} DH
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end gap-2 opacity-010 ">
                                <a href="{{route("maintenance.edit",$maintenance->id)}}" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{route('maintenance.destroy',$maintenance->id)}}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" onclick="return confirm('Supprimer cette intervention ?')" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-400 font-medium text-lg">Aucune maintenance enregistrée pour le moment.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($car->maintenances->count() > 0)
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center text-sm">
            <p class="text-gray-500 italic">Total des interventions : <span class="font-bold text-gray-700">{{ $car->maintenances->count() }}</span></p>
            <p class="text-gray-500">Dépenses totales : <span class="text-lg font-bold text-blue-600">{{ number_format($car->maintenances->sum('cost'), 2, '.') }} DH</span></p>
        </div>
        @endif
    </div>
</div>
@endsection