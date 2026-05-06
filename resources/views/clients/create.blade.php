@extends('_layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i data-lucide="user-plus" class="text-blue-600"></i> Ajouter un Client
    </h2>

    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nom Complet -->
        <div>
            <label class="block text-sm font-medium mb-1 @error('name') text-red-500 @enderror">Nom Complet</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('name') border-red-500 @enderror">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- CIN -->
        <div>
            <label class="block text-sm font-medium mb-1 @error('national_id') text-red-500 @enderror">CIN (National ID)</label>
            <input type="text" name="national_id" value="{{ old('national_id') }}" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('national_id') border-red-500 @enderror">
            @error('national_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Numéro de Permis -->
        <div>
            <label class="block text-sm font-medium mb-1 @error('license_number') text-red-500 @enderror">Numéro de Permis</label>
            <input type="text" name="license_number" value="{{ old('license_number') }}" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('license_number') border-red-500 @enderror">
            @error('license_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Ville -->
        <div>
            <label class="block text-sm font-medium mb-1 @error('city') text-red-500 @enderror">Ville</label>
            <input type="text" name="city" value="{{ old('city') }}" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('city') border-red-500 @enderror">
            @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Adresse -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1 @error('address') text-red-500 @enderror">Adresse</label>
            <textarea name="address" rows="2" 
                class="w-full border rounded-lg p-2.5 bg-gray-50 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            <input type="hidden" name="country" value="Maroc">
        </div>

        <!-- Upload Documents -->
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Permis -->
            <div class="border-2 border-dashed p-4 rounded-lg @error('license_image_front') border-red-300 @enderror">
                <p class="text-sm font-bold mb-2">Permis de conduire</p>
                <label class="text-xs text-gray-500">Recto</label>
                <input type="file" name="license_image_front" class="text-xs mb-2 w-full">
                @error('license_image_front') <p class="text-red-500 text-[10px]">{{ $message }}</p> @enderror

                <label class="text-xs text-gray-500">Verso</label>
                <input type="file" name="license_image_back" class="text-xs w-full">
                @error('license_image_back') <p class="text-red-500 text-[10px]">{{ $message }}</p> @enderror
            </div>

            <!-- CIN -->
            <div class="border-2 border-dashed p-4 rounded-lg @error('national_id_image_front') border-red-300 @enderror">
                <p class="text-sm font-bold mb-2">CIN</p>
                <label class="text-xs text-gray-500">Recto</label>
                <input type="file" name="national_id_image_front" class="text-xs mb-2 w-full">
                @error('national_id_image_front') <p class="text-red-500 text-[10px]">{{ $message }}</p> @enderror

                <label class="text-xs text-gray-500">Verso</label>
                <input type="file" name="national_id_image_back" class="text-xs w-full">
                @error('national_id_image_back') <p class="text-red-500 text-[10px]">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <!-- ... boutons ... -->

       <div class="flex justify-end gap-3 pt-6">

            <a href="{{ route('clients.index') }}" class="px-6 py-2.5 text-gray-600">Annuler</a>

            <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-bold shadow-lg hover:bg-blue-700 transition-all">

                Enregistrer le Client

            </button>

        </div>
</form>
</div>

@endsection