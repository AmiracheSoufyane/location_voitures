@extends('_layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i data-lucide="user-plus" class="text-blue-600"></i> Ajouter un Client
    </h2>

    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Infos de base -->
            <div>
                <label class="block text-sm font-medium mb-1">Nom Complet</label>
                <input type="text" name="name" class="w-full border rounded-lg p-2.5 bg-gray-50" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">CIN (National ID)</label>
                <input type="text" name="national_id" class="w-full border rounded-lg p-2.5 bg-gray-50" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Numéro de Permis</label>
                <input type="text" name="license_number" class="w-full border rounded-lg p-2.5 bg-gray-50" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Ville</label>
                <input type="text" name="city" class="w-full border rounded-lg p-2.5 bg-gray-50" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Adresse</label>
                <textarea name="address" rows="2" class="w-full border rounded-lg p-2.5 bg-gray-50" required></textarea>
                <input type="hidden" name="country" value="Maroc">
            </div>

            <!-- Upload Documents -->
            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="border-2 border-dashed p-4 rounded-lg">
                    <p class="text-sm font-bold mb-2">Permis de conduire</p>
                    <label class="text-xs text-gray-500">Recto</label>
                    <input type="file" name="license_image_front" class="text-xs mb-2 w-full">
                    <label class="text-xs text-gray-500">Verso</label>
                    <input type="file" name="license_image_back" class="text-xs w-full">
                </div>
                <div class="border-2 border-dashed p-4 rounded-lg">
                    <p class="text-sm font-bold mb-2">CIN</p>
                    <label class="text-xs text-gray-500">Recto</label>
                    <input type="file" name="national_id_image_front" class="text-xs mb-2 w-full">
                    <label class="text-xs text-gray-500">Verso</label>
                    <input type="file" name="national_id_image_back" class="text-xs w-full">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6">
            <a href="{{ route('clients.index') }}" class="px-6 py-2.5 text-gray-600">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-bold shadow-lg hover:bg-blue-700 transition-all">
                Enregistrer le Client
            </button>
        </div>
    </form>
</div>
@endsection