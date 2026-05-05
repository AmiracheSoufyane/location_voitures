@extends('_layout')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-2xl rounded-2xl p-8 mt-6">

    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <i data-lucide="car"></i>
        Ajouter une voiture
    </h2>

    <form method="POST" action="{{ route('cars.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- BRAND -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="tag" class="w-4 h-4"></i>
                    Marque
                </label>

                <input type="text" name="brand" value="{{ old('brand') }}"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500
                    @error('brand') border-red-500 @enderror">

                @error('brand')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- MODEL -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="box"></i>
                    Modèle
                </label>

                <input type="text" name="model" value="{{ old('model') }}"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500
                    @error('model') border-red-500 @enderror">

                @error('model')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- MILEAGE -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="gauge"></i>
                    Kilométrage
                </label>

                <input type="number" name="mileage" value="{{ old('mileage') }}"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500
                    @error('mileage') border-red-500 @enderror">

                @error('mileage')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- YEAR -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="calendar"></i>
                    Année
                </label>

                <input type="number" name="year" value="{{ old('year') }}"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500
                    @error('year') border-red-500 @enderror">

                @error('year')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- REGISTRATION -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="credit-card"></i>
                    Immatriculation
                </label>

                <input type="text" name="registration" value="{{ old('registration') }}"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500
                    @error('registration') border-red-500 @enderror">

                @error('registration')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- FUEL -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="fuel"></i>
                    Carburant
                </label>

                <select name="fuel_type"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500">

                    <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                    <option value="Essence" {{ old('fuel_type') == 'Essence' ? 'selected' : '' }}>Essence</option>
                    <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybride</option>
                    <option value="Electrique" {{ old('fuel_type') == 'Electrique' ? 'selected' : '' }}>Électrique</option>

                </select>
            </div>

            <!-- STATUS -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="activity"></i>
                    Statut
                </label>

                <select name="status"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500">

                    <option value="disponible" {{ old('status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="loué" {{ old('status') == 'loué' ? 'selected' : '' }}>Loué</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>

                </select>
            </div>

            <!-- PRICE -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <span>DH</span>
                    Prix / Jour
                </label>

                <input type="number" step="0.1" name="price_per_day" value="{{ old('price_per_day') }}"
                    class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500
                    @error('price_per_day') border-red-500 @enderror">

                @error('price_per_day')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="image"></i>
                    Image
                </label>

                <input type="file" name="image" id="imageInput"
                    class="w-full mt-1 p-3 border rounded-xl bg-gray-50">

                <!-- preview -->
                <div class="mt-3 w-40 h-32 border rounded overflow-hidden bg-gray-100">
                    <img id="previewImg" class="w-full h-full object-cover hidden">
                </div>

                @error('image')
                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i data-lucide="alert-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <!-- BUTTON -->
        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2">
            <i data-lucide="send"></i>
            Ajouter la voiture
        </button>

    </form>

</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.getElementById('previewImg');
            img.src = event.target.result;
            img.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endsection