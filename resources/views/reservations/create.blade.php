@extends('_layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('reservations.index') }}" class="p-2 bg-white rounded-full shadow-sm hover:bg-gray-100 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Nouveau Contrat de Location</h2>
    </div>

    <form action="{{ route('reservations.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Bloc Client -->
                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-gray-700">Client</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-3.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" id="client_search" autocomplete="off"
                            value="{{ old('client_name') }}" name="client_name"
                            placeholder="Taper le nom..."
                            class="w-full pl-10 p-3 bg-gray-50 border {{ $errors->has('client_id') ? 'border-red-500' : 'border-gray-200' }} rounded-xl outline-none">
                    </div>
                    <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id') }}">
                    <div id="client_results" class="absolute z-[100] w-full bg-white border rounded-xl mt-1 hidden shadow-2xl max-h-60 overflow-y-auto"></div>
                </div>

                <!-- Bloc Véhicule -->
                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-gray-700">Véhicule</label>
                    <div class="relative">
                         <i data-lucide="car" class="absolute left-3 top-3.5 w-4 h-4 text-gray-400"></i>
                         <input type="text" id="car_search" name="car_name" value="{{ old('car_name') }}" autocomplete="off" 
                            placeholder="Marque ou Modèle..."
                            class="w-full pl-10 p-3 bg-gray-50 border {{ $errors->has('car_id') ? 'border-red-500' : 'border-gray-200' }} rounded-xl outline-none">
                    </div>
                    <input type="hidden" name="car_id" id="car_id" value="{{ old('car_id') }}">
                    <div id="car_results" class="absolute z-[100] w-full bg-white border rounded-xl mt-1 hidden shadow-2xl max-h-48 overflow-y-auto"></div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Date de début</label>
                    <input type="date" name="date_start" id="date_start" value="{{ old('date_start', date('Y-m-d')) }}" class="w-full p-3 bg-gray-50 border rounded-xl outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Date de fin</label>
                    <input type="date" name="date_end" id="date_end" value="{{ old('date_end') }}" class="w-full p-3 bg-gray-50 border rounded-xl outline-none">
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-bold text-gray-700">Prix Total (DH)</label>
                    <input type="number" name="price" id="total_price" step="0.01" value="{{ old('price') }}" class="w-full p-3 bg-blue-50 border border-blue-100 rounded-xl font-bold text-blue-700 outline-none">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700">
                Enregistrer le contrat
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log("Script chargé !");
    if (window.lucide) lucide.createIcons();

    let carPricePerDay = 0;

    const selectors = {
        client: {
            input: document.getElementById('client_search'),
            hidden: document.getElementById('client_id'),
            results: document.getElementById('client_results'),
            url: '/api/search-clients'
        },
        car: {
            input: document.getElementById('car_search'),
            hidden: document.getElementById('car_id'),
            results: document.getElementById('car_results'),
            url: '/api/search-cars'
        },
        dates: {
            start: document.getElementById('date_start'),
            end: document.getElementById('date_end'),
            total: document.getElementById('total_price')
        }
    };

    function calculateTotal() {
        if (selectors.dates.start.value && selectors.dates.end.value && carPricePerDay > 0) {
            const d1 = new Date(selectors.dates.start.value);
            const d2 = new Date(selectors.dates.end.value);
            const days = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
            if (days > 0) {
                selectors.dates.total.value = (days * carPricePerDay).toFixed(2);
            }
        }
    }

    // Fonction de recherche générique
    function initAutocomplete(type) {
        const s = selectors[type];
        
        s.input.addEventListener('input', function() {
            const query = this.value;
            console.log(`Recherche ${type}:`, query);

            if (query.length < 2) {
                s.results.classList.add('hidden');
                return;
            }

            fetch(`${s.url}?q=${query}`)
                .then(res => res.json())
                .then(data => {
                    console.log(`Données reçues pour ${type}:`, data);
                    s.results.innerHTML = '';
                    
                    if (data.length > 0) {
                        s.results.classList.remove('hidden');
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'p-3 hover:bg-blue-50 cursor-pointer border-b text-sm';
                            
                            const label = (type === 'car') 
                                ? `${item.brand} ${item.model} (${item.registration})` 
                                : item.name;
                            
                            div.innerHTML = `<strong>${label}</strong>`;
                            
                            div.addEventListener('mousedown', function(e) {
                                console.log(`${type} sélectionné:`, item.id);
                                s.input.value = label;
                                s.hidden.value = item.id;
                                
                                if (type === 'car') {
                                    carPricePerDay = item.daily_price;
                                    calculateTotal();
                                }
                                
                                s.results.classList.add('hidden');
                            });
                            s.results.appendChild(div);
                        });
                    } else {
                        s.results.classList.add('hidden');
                    }
                })
                .catch(err => console.error(`Erreur ${type}:`, err));
        });

        // Fermer la liste si on perd le focus
        s.input.addEventListener('blur', () => {
            setTimeout(() => s.results.classList.add('hidden'), 200);
        });
    }

    initAutocomplete('client');
    initAutocomplete('car');

    selectors.dates.start.addEventListener('change', calculateTotal);
    selectors.dates.end.addEventListener('change', calculateTotal);
});
</script>
@endpush
@endsection