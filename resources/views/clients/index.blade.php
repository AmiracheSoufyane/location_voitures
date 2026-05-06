@extends('_layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Liste des Clients</h2>
    <a href="{{ route('clients.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700">
        <i data-lucide="user-plus" class="w-5 h-5"></i> Nouveau Client
    </a>
</div>

<div class="bg-white shadow-md rounded-xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 font-semibold text-gray-700">Nom</th>
                <th class="p-4 font-semibold text-gray-700">CIN</th>
                <th class="p-4 font-semibold text-gray-700">N° Permis</th>
                <th class="p-4 font-semibold text-gray-700">Ville</th>
                <th class="p-4 font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4 font-medium">{{ $client->name }}</td>
                <td class="p-4 text-gray-600">{{ $client->national_id }}</td>
                <td class="p-4 text-gray-600">{{ $client->license_number }}</td>
                <td class="p-4 text-gray-600">{{ $client->city }}</td>
                <td class="p-4">
                    <div class="flex items-center gap-3">
                    <a href="{{ route('clients.show', $client->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                        Voir le dossier
                    </a>
                    <a href="{{ route('clients.edit', $client->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                        Modifier
                    </a>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce client ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection