<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<header class="fixed top-0 left-0 w-full bg-white shadow z-50 flex items-center justify-between px-4 h-14">

    <!-- bouton mobile -->
    <button onclick="toggleSidebar()" 
        class="md:hidden bg-gray-900 text-white p-2 rounded">
        ☰
    </button>

    <h1 class="font-bold">Dashboard</h1>

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

            <div>
                <button onclick="togglePersonnes()" 
                    class="w-full flex items-center justify-between p-2 rounded hover:bg-gray-700">

                    <div class="flex items-center gap-3">
                        <i data-lucide="users"></i>
                        Personnes
                    </div>

                    <i data-lucide="chevron-down"></i>
                </button>

                <div id="personnesMenu" class="hidden ml-6 mt-2 space-y-1">

                    <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-gray-700">
                        <i data-lucide="user"></i>
                        Employé
                    </a>

                    <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-gray-700">
                        <i data-lucide="users"></i>
                        Client
                    </a>

                </div>
            </div>

            <a href="{{route('cars')}}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 mt-4">
                <i data-lucide="car"></i>
                Véhicule
            </a>
             <a href="{{route('cars.maintenance')}}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 mt-4" >mintenence needing</a>

                <form action="{{route('logout')}}" method='POST' >
                    @csrf
                    <button class="flex items-center text-red-600 gap-3 p-2 rounded hover:bg-gray-700 mt-4">
                        <i data-lucide="arrow-left-from-line"></i>
                         déconnection

                        </button>
                   </form>
            @endauth
            @guest
                <a href="{{route('login.form')}}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 mt-4">
                    <i data-lucide="log-in"></i>
                    se connecter
                </a>
            @endguest
                
            

        </nav>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-6 ml-0 md:ml-64">
        @yield('content')
    </main>

</div>

</body>
</html>