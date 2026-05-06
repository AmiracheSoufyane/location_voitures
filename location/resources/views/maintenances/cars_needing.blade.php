@extends('_layout')

@section('content')
<div class="max-w-6xl mx-auto my-12 px-4">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2">
                <i data-lucide="car" class="w-10 h-10"></i>
                 Les voitures nécessitent une vidange urgente

                
            </h1>

            <p class="text-gray-500 mt-1">
                Liste des véhicules ayant dépassé le seuil de vidange
            </p>
        </div>

       

    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    @if($cars->count() > 0)

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400">
                            <th class="px-6 py-4 text-center">Date</th>
                            <th class="px-6 py-4">Marque</th>
                            <th class="px-6 py-4">Modèle</th>
                            <th class="px-6 py-4">Année</th>
                            <th class="px-6 py-4">Immatriculation</th>
                            <th class="px-6 py-4">Kilométrage</th>
                            <th class="px-6 py-4">Rest</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($cars as $car)
                            <tr class="hover:bg-blue-50/30 transition">

                                <!-- IMAGE -->
                                <td class="px-6 py-4 text-center">
    <div class="text-sm font-semibold text-gray-700">
        {{ $car->notifications->last()?->created_at->format('d/m/Y') }}
    </div>
    <div class="text-xs text-gray-500">
        {{ $car->notifications->last()?->created_at->format('H:i') }}
    </div>
</td>

                                <!-- DATA -->
                                <td class="px-6 py-4 font-semibold">{{ $car->brand }}</td>
                                <td class="px-6 py-4">{{ $car->model }}</td>
                                <td class="px-6 py-4">{{ $car->year }}</td>

                                <td class="px-6 py-4">
                                    <span class="bg-gray-100 px-3 py-1 rounded-lg text-xs font-mono">
                                        {{ $car->registration }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    {{ number_format($car->mileage, 0, ',', ' ') }} km
                                </td>

                                <td class="px-6 py-4">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                        +{{ $car->rest }} km
                                    </span>
                                </td>

                                <!-- ACTION -->
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('maintenance.create', $car->id) }}"
                                       class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-xs font-bold shadow">
                                         Maintenance
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

    @else

        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl border">
            ✅ Aucune voiture ne nécessite de maintenance.
        </div>

    @endif

</div>
@endsection