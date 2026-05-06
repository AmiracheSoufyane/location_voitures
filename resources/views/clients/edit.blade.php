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
        @method('PUT') <!-- CRUCIAL pour Laravel lors d'une mise à jour -->

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Nom Complet -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700">Nom Complet</label>
                <input type="text" name="name" value="{{ old('name', $client->name) }}" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- CIN -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700">CIN / ID National</label>
                <input type="text" name="national_id" value="{{ old('national_id', $client->national_id) }}" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- N° Permis -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700">Numéro de Permis</label>
                <input type="text" name="license_number" value="{{ old('license_number', $client->license_number) }}" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- Ville -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700">Ville</label>
                <input type="text" name="city" value="{{ old('city', $client->city) }}" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- Preview Image Actuelle -->
            <div class="md:col-span-2 p-4 bg-blue-50 rounded-2xl flex items-center gap-4">
                <div class="w-16 h-16 rounded-lg overflow-hidden border">
                    <img src="{{ asset($client->national_id_image_front) }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="text-sm font-bold text-blue-800">Document actuel</p>
                    <p class="text-xs text-blue-600">Laissez vide si vous ne voulez pas changer l'image.</p>
                </div>
                <input type="file" name="national_id_image_front" class="ml-auto text-sm">
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <button type="reset" class="px-6 py-3 text-gray-600 font-medium">Annuler</button>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition-all">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection