@extends('_layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('clients.index') }}" class="p-2 bg-white rounded-full shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Modifier le client : {{ $client->name }}</h2>
    </div>

    <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nom Complet -->
        <div>
            <label class="block text-sm font-medium mb-1 @error('name') text-red-500 @enderror">Nom Complet</label>
            <input type="text" name="name" value="{{ old('name', $client->name) }}" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('name') border-red-500 @enderror">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- CIN -->
        <div>
            <label class="block text-sm font-medium mb-1 @error('national_id') text-red-500 @enderror">CIN (National ID)</label>
            <input type="text" name="national_id" value="{{ old('national_id', $client->national_id) }}" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('national_id') border-red-500 @enderror">
            @error('national_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Numéro de Permis -->
        <div>
            <label class="block text-sm font-medium mb-1 @error('license_number') text-red-500 @enderror">Numéro de Permis</label>
            <input type="text" name="license_number" value="{{ old('license_number', $client->license_number) }}" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('license_number') border-red-500 @enderror">
            @error('license_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Ville -->
        <div>
            <label class="block text-sm font-medium mb-1 @error('city') text-red-500 @enderror">Ville</label>
            <input type="text" name="city" value="{{ old('city', $client->city) }}" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('city') border-red-500 @enderror">
            @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Adresse -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1 @error('address') text-red-500 @enderror">Adresse</label>
            <textarea name="address" rows="2" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('address') border-red-500 @enderror">{{ old('address', $client->address) }}</textarea>
            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Documents (Images) -->
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            
            <!-- Section Permis -->
            <div class="border-2 border-dashed p-4 rounded-lg bg-white">
                <p class="text-sm font-bold mb-3 text-blue-600">Permis de conduire (Laisser vide pour garder l'actuel)</p>
                
                <div class="mb-4">
                    <label class="text-xs text-gray-500 block mb-1">Recto</label>
                    @if($client->license_image_front)
                        <p class="text-[10px] text-green-600 mb-1">Fichier actuel : {{ $client->license_image_front }}</p>
                    @endif
                    <input type="file" name="license_image_front" class="text-xs w-full">
                    @error('license_image_front') <p class="text-red-500 text-[10px]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 block mb-1">Verso</label>
                    @if($client->license_image_back)
                        <p class="text-[10px] text-green-600 mb-1">Fichier actuel : {{ $client->license_image_back }}</p>
                    @endif
                    <input type="file" name="license_image_back" class="text-xs w-full">
                    @error('license_image_back') <p class="text-red-500 text-[10px]">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Section CIN -->
            <div class="border-2 border-dashed p-4 rounded-lg bg-white">
                <p class="text-sm font-bold mb-3 text-blue-600">CIN (Laisser vide pour garder l'actuel)</p>
                
                <div class="mb-4">
                    <label class="text-xs text-gray-500 block mb-1">Recto</label>
                    @if($client->national_id_image_front)
                        <p class="text-[10px] text-green-600 mb-1">Fichier actuel : {{ $client->national_id_image_front }}</p>
                    @endif
                    <input type="file" name="national_id_image_front" class="text-xs w-full">
                    @error('national_id_image_front') <p class="text-red-500 text-[10px]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 block mb-1">Verso</label>
                    @if($client->national_id_image_back)
                        <p class="text-[10px] text-green-600 mb-1">Fichier actuel : {{ $client->national_id_image_back }}</p>
                    @endif
                    <input type="file" name="national_id_image_back" class="text-xs w-full">
                    @error('national_id_image_back') <p class="text-red-500 text-[10px]">{{ $message }}</p> @enderror
                </div>
            </div>

        </div>
    </div>

    <div class="flex justify-end gap-3 pt-6 border-t">
        <a href="{{ route('clients.index') }}" class="px-6 py-2.5 text-gray-600 hover:underline">Annuler</a>
        <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-bold shadow-lg hover:bg-blue-700 transition-all">
            Mettre à jour le Client
        </button>
    </div>
</form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Initialisation des icônes pour les éléments chargés dynamiquement
        lucide.createIcons();

        // 2. Logique de calcul du prix
        const startInput = document.getElementById('date_start');
        const endInput = document.getElementById('date_end');
        const priceInput = document.getElementById('total_price');
        const dailyPriceHidden = document.getElementById('daily_price');

        function calculatePrice() {
            const start = new Date(startInput.value);
            const end = new Date(endInput.value);
            const daily = parseFloat(dailyPriceHidden.value);

            if (start && end && end > start && daily) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                priceInput.value = (diffDays * daily).toFixed(2);
            }
        }

        if(startInput) {
            startInput.addEventListener('change', calculatePrice);
            endInput.addEventListener('change', calculatePrice);
        }

        // 3. Logique de l'Autocomplete (Recherche Client)
        const clientInput = document.getElementById('client_search');
        const clientResults = document.getElementById('client_results');
        const clientIdHidden = document.getElementById('client_id');

        if(clientInput) {
            clientInput.addEventListener('input', function() {
                let query = this.value;
                if (query.length > 2) {
                    fetch(`/api/search-clients?q=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            clientResults.innerHTML = '';
                            clientResults.classList.remove('hidden');
                            data.forEach(client => {
                                let div = document.createElement('div');
                                div.className = 'p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 text-sm';
                                div.innerHTML = `<span class="font-bold">${client.name}</span> <span class="text-gray-400">(${client.national_id})</span>`;
                                div.onclick = () => {
                                    clientInput.value = client.name;
                                    clientIdHidden.value = client.id;
                                    clientResults.classList.add('hidden');
                                };
                                clientResults.appendChild(div);
                            });
                        });
                } else {
                    clientResults.classList.add('hidden');
                }
            });
        }
        
        // Fermer les résultats si on clique ailleurs
        document.addEventListener('click', (e) => {
            if (!clientInput.contains(e.target)) clientResults.classList.add('hidden');
        });
    });
</script>
@endpush
@endsection