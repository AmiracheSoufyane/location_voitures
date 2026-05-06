@extends('_layout')

@section('content')

<div class="min-h-[80vh] flex items-center justify-center from-gray-100 to-gray-200">

    <div class="w-full max-w-md bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-8 border border-gray-100">

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">
            Se connecter
        </h2>

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">

            @csrf
                @error('msg')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            <div>
                <input type="email" name="email" placeholder="Email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="password" name="password" placeholder="Mot de passe"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition duration-300 shadow-md hover:shadow-lg">
                Login
            </button>

        </form>
      @if(isset($retryAfter))
    <div class="mt-4 text-center text-red-600 font-semibold">
        <p id="countdown"></p>
    </div>

    <script>
        let time = {{ $retryAfter }};
        const el = document.getElementById('countdown');

        const interval = setInterval(() => {
            if (time <= 0) {
                clearInterval(interval);
                el.innerHTML = "Vous pouvez réessayer maintenant";
            } else {
                el.innerHTML = "Réessayez dans " + time + " seconde" + (time > 1 ? "s" : "");
                time--;
            }
        }, 1000);
    </script>
@endif


    </div>

</div>

@endsection