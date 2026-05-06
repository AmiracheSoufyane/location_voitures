<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <!-- Tes scripts globaux (Lucide, Alpine, etc.) -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>

    @stack('scripts') {{-- <-- Cette ligne est magique --}}
</body>
</html>
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<header class="fixed top-0 left-0 w-full bg-white shadow z-50 flex items-center justify-between px-4 h-14">
    <button onclick="toggleSidebar()" class="md:hidden bg-gray-900 text-white p-2 rounded">
        ☰
    </button>
    <h1 class="font-bold">Dashboard - Location Auto</h1>
</header>

<div class="flex pt-14 min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed top-14 left-0 z-40 w-64 h-full bg-gray-900 text-white p-4 transform -translate-x-full md:translate-x-0 transition-transform duration-300">

        <nav class="space-y-2">
            @auth
            <a href="#" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700">
                <i data-lucide="layout-dashboard"></i>
                Dashboard
            </a>

            <!-- Menu Personnes -->
    <div>
        <button onclick="togglePersonnes()" class="w-full flex items-center justify-between p-2 rounded hover:bg-gray-700">
            <div class="flex items-center gap-3">
                <i data-lucide="users"></i>
                Personnes
            </div>
            <i data-lucide="chevron-down"></i>
        </button>
        <div id="personnesMenu" class="hidden ml-6 mt-2 space-y-1">
            <!-- Lien vers la liste des clients -->
            <a href="{{ route('clients.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm">
                <i data-lucide="users-2" class="w-4 h-4"></i> Liste Clients
            </a>
            <!-- Lien direct pour ajouter un client -->
            <a href="{{ route('clients.create') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Ajouter Client
            </a>
        </div>
    </div>

    <!-- Lien vers les Réservations -->
    <a href="{{ route('reservations.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 mt-2">
        <i data-lucide="file-signature"></i>
        Réservations
    </a>
            <!-- Menu Véhicules -->
            <a href="{{route('cars')}}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700">
                <i data-lucide="car"></i>
                Véhicules
            </a>

            <!-- Déconnexion -->
            <form action="{{route('logout')}}" method='POST' >
                @csrf
                <button class="w-full flex items-center text-red-400 gap-3 p-2 rounded hover:bg-gray-800 mt-10">
                    <i data-lucide="log-out"></i>
                    Déconnexion
                </button>
            </form>
            @endauth

            @guest
                <a href="{{route('login.form')}}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 mt-4">
                    <i data-lucide="log-in"></i>
                    Se connecter
                </a>
            @endguest
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-6 ml-0 md:ml-64">
        <!-- btn success -->

        @if(session('success'))
            <div class="max-w-4xl mx-auto mt-4">
                <div class="flex items-center gap-3 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                    
                    <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div><br>
            </div>
            
        @endif
        @if(session('error'))
            <div class="max-w-4xl mx-auto mt-4">
                <div class="flex items-center gap-3 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div><br>
            
        @endif
        @yield('content')
    </main>

</div>

<script>
    // Initialisation des icônes Lucide
    lucide.createIcons();

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }

    function togglePersonnes() {
        const menu = document.getElementById('personnesMenu');
        menu.classList.toggle('hidden');
    }

    
</script>
    

</body>
</html>