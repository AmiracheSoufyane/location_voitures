@extends('_layout')

@section('content')
<div class="max-w-2xl mx-auto my-12 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        
        <div class="bg-gradient-to-r from-indigo-700 to-purple-800 px-8 py-7 text-white">
            <div class="flex items-center gap-3 mb-1">
                <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <h2 class="text-xl font-semibold opacity-90">Modifier l'intervention</h2>
            </div>
            <p class="text-2xl font-extrabold flex items-center gap-2">
                {{$car->brand}} <span class="font-light text-indigo-100">{{$car->model}}</span>
                <span class="text-sm font-mono bg-black/20 px-2 py-0.5 rounded ml-2 text-white/80">
                    {{$car->registration}}
                </span>
            </p>
        </div>

        <form action="{{ route('maintenance.update', $maintenance->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="car_id" value="{{ $car->id }}">

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Nature des travaux</label>
                <textarea 
                    name="type" 
                    rows="3"
                    class="w-full px-4 py-3 rounded-xl transition-all duration-200 outline-none resize-none border
                    @error('type') border-red-500 bg-red-50 focus:ring-red-200 @else border-gray-200 bg-gray-50 focus:bg-white focus:ring-indigo-500/10 focus:border-indigo-500 @enderror"
                    placeholder="Détails de l'intervention..."
                >{{ old('type', $maintenance->type) }}</textarea>
                @error('type')
                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Date de l'intervention</label>
                <input 
                    type="date" 
                    name="maintenance_date" 
                    value="{{ old('maintenance_date', $maintenance->maintenance_date) }}"
                    class="w-full pl-4 pr-10 py-3 rounded-xl transition-all duration-200 outline-none appearance-none border
                    @error('maintenance_date') border-red-500 bg-red-50 focus:ring-red-200 @else border-gray-200 bg-gray-50 focus:bg-white focus:ring-indigo-500/10 focus:border-indigo-500 @enderror"
                >
                @error('maintenance_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Coût Total (DH)</label>
                    <div class="relative group">
                        <input 
                            type="number" 
                            step="0.01"
                            name="cost" 
                            value="{{ old('cost', $maintenance->cost) }}"
                            class="w-full pl-4 pr-12 py-3 rounded-xl transition-all duration-200 outline-none border
                            @error('cost') border-red-500 bg-red-50 focus:ring-red-200 @else border-gray-200 bg-gray-50 focus:bg-white focus:ring-indigo-500/10 focus:border-indigo-500 @enderror"
                            placeholder="0.00"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium @error('cost') text-red-400 @else group-focus-within:text-indigo-600 @enderror">DH</span>
                    </div>
                    @error('cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Kilométrage</label>
                    <div class="relative group">
                        <input 
                            type="number" 
                            name="mileage" 
                            value="{{ old('mileage', $maintenance->mileage) }}"
                            class="w-full pl-4 pr-12 py-3 rounded-xl transition-all duration-200 outline-none border
                            @error('mileage') border-red-500 bg-red-50 focus:ring-red-200 @else border-gray-200 bg-gray-50 focus:bg-white focus:ring-indigo-500/10 focus:border-indigo-500 @enderror"
                            placeholder="Ex: 150000"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium @error('mileage') text-red-400 @else group-focus-within:text-indigo-600 @enderror">Km</span>
                    </div>
                    @error('mileage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex flex-col gap-3">
                <button 
                    type="submit"
                    class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Mettre à jour l'intervention
                </button>
                
                <a href="{{ route('maintenance.index', $car->id) }}" class="block text-center py-2 text-sm text-gray-500 hover:text-gray-700 transition font-medium">
                    Annuler les modifications
                </a>
            </div>
        </form>
    </div>
</div>
@endsection