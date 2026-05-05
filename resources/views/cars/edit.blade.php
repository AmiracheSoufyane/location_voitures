@extends('_layout')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-2xl rounded-2xl p-8 mt-6">

    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <i data-lucide="edit" class="w-6 h-6"></i>
        Modifier la voiture
    </h2>

    <form method="POST" action="{{ route('cars.update', $car->id) }}" enctype="multipart/form-data" class="space-y-6">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- BRAND -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="tag" class="w-4 h-4"></i>
                    Marque
                </label>

                <input type="text" name="brand"
                    value="{{ old('brand', $car->brand) }}"
                    class="w-full mt-1 p-3 border rounded-xl">

                @error('brand')
                    <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- MODEL -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="box" class="w-4 h-4"></i>
                    Modèle
                </label>

                <input type="text" name="model"
                    value="{{ old('model', $car->model) }}"
                    class="w-full mt-1 p-3 border rounded-xl">

                @error('model')
                    <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- MILEAGE -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="gauge" class="w-4 h-4"></i>
                    Kilométrage
                </label>

                <input type="number" name="mileage"
                    value="{{ old('mileage', $car->mileage) }}"
                    class="w-full mt-1 p-3 border rounded-xl">

                @error('mileage')
                    <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- YEAR -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    Année
                </label>

                <input type="number" name="year"
                    value="{{ old('year', $car->year) }}"
                    class="w-full mt-1 p-3 border rounded-xl">

                @error('year')
                    <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- REGISTRATION -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    Immatriculation
                </label>

                <input type="text" name="registration"
                    value="{{ old('registration', $car->registration) }}"
                    class="w-full mt-1 p-3 border rounded-xl">

                @error('registration')
                    <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- FUEL -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="fuel" class="w-4 h-4"></i>
                    Carburant
                </label>

                <select name="fuel_type" class="w-full mt-1 p-3 border rounded-xl">

                    <option value="Diesel" {{ old('fuel_type', $car->fuel_type) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                    <option value="Essence" {{ old('fuel_type', $car->fuel_type) == 'Essence' ? 'selected' : '' }}>Essence</option>
                    <option value="Hybrid" {{ old('fuel_type', $car->fuel_type) == 'Hybrid' ? 'selected' : '' }}>Hybride</option>
                    <option value="Electrique" {{ old('fuel_type', $car->fuel_type) == 'Electrique' ? 'selected' : '' }}>Électrique</option>

                </select>
            </div>

            <!-- STATUS -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4"></i>
                    Statut
                </label>

                <select name="status" class="w-full mt-1 p-3 border rounded-xl">

                    <option value="disponible" {{ old('status', $car->status) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="loué" {{ old('status', $car->status) == 'loué' ? 'selected' : '' }}>Loué</option>
                    <option value="maintenance" {{ old('status', $car->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>

                </select>
            </div>

            <!-- PRICE -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <span class="text-gray-500">DH</span>
                    Prix / Jour
                </label>

                <input type="number" step="0.1" name="price_per_day"
                    value="{{ old('price_per_day', $car->price_per_day) }}"
                    class="w-full mt-1 p-3 border rounded-xl">

                @error('price_per_day')
                    <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- IMAGE -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-2">
                    <i data-lucide="image" class="w-4 h-4"></i>
                    Image
                </label>

                <input type="file" name="image"
                    class="w-full mt-1 p-3 border rounded-xl bg-gray-50">

                <div class="mt-2 w-32 h-24 overflow-hidden rounded">
                    <img src="{{ asset('storage/' . $car->image) }}"
                        class="w-full h-full object-cover">
                </div>

            </div>

        </div>

        <button type="submit"
            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl flex items-center justify-center gap-2">

            <i data-lucide="check-circle" class="w-5 h-5"></i>
            Modifier

        </button>
        <a href="javascript:history.back()"
           class="w-full bg-gray-500 hover:bg-gray-700 text-white font-semibold py-3 rounded-xl flex items-center justify-center gap-2">
        Annuler</a>
    </form>

</div>

@endsection