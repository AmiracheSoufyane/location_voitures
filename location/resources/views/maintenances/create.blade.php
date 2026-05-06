@extends('_layout')

@section('content')
<div class="max-w-2xl mx-auto my-12">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        
        <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-8 py-7 text-white">
            <div class="flex items-center gap-3 mb-1">
                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                <h2 class="text-xl font-semibold opacity-90">Ajouter une intervention</h2>
            </div>
            <p class="text-2xl font-extrabold flex items-center gap-2">
                {{$car->brand}} <span class="font-light text-blue-100">{{$car->model}}</span>
                <span class="text-sm font-mono bg-black/20 px-2 py-0.5 rounded ml-2 text-white/80">
                    {{$car->registration}}
                </span>
            </p>
        </div>

        <form action="{{ route('maintenance.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <input type="hidden" name="car_id" value="{{ $car->id }}">

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Nature des travaux</label>
                <textarea 
                    name="type" 
                    rows="3"
                    class="w-full px-4 py-3 rounded-xl transition-all duration-200 outline-none resize-none
                    @error('type') border-red-500 bg-red-50 focus:ring-red-200 @else border-gray-200 bg-gray-50 focus:bg-white focus:ring-blue-500/10 focus:border-blue-500 @enderror border"
                    placeholder="Ex: Vidange moteur, changement des plaquettes de frein..."
                >{{ old('type') }}</textarea>
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
                    value="{{ old('maintenance_date') }}"
                    class="w-full pl-4 pr-10 py-3 rounded-xl transition-all duration-200 outline-none appearance-none border
                    @error('maintenance_date') border-red-500 bg-red-50 focus:ring-red-200 @else border-gray-200 bg-gray-50 focus:bg-white focus:ring-blue-500/10 focus:border-blue-500 @enderror"
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
                            value="{{ old('cost') }}"
                            class="w-full pl-4 pr-12 py-3 rounded-xl transition-all duration-200 outline-none border
                            @error('cost') border-red-500 bg-red-50 focus:ring-red-200 @else border-gray-200 bg-gray-50 focus:bg-white focus:ring-blue-500/10 focus:border-blue-500 @enderror"
                            placeholder="0.00"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium @error('cost') text-red-400 @else group-focus-within:text-blue-600 @enderror">DH</span>
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
    value="{{ $car->mileage }}"
    readonly
    class="w-full pl-4 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-700 cursor-not-allowed"
/>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium @error('mileage') text-red-400 @else group-focus-within:text-blue-600 @enderror">Km</span>
                    </div>
                    @error('mileage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4">
                <button 
                    type="submit"
                    class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Enregistrer la maintenance
                </button>
                
                <a href="{{ route('maintenance.index', $car->id) }}" class="block text-center mt-4 text-sm text-gray-500 hover:text-gray-700 transition">
                    Annuler et retourner
                </a>
            </div>
        </form>
    </div>
</div>
@endsection