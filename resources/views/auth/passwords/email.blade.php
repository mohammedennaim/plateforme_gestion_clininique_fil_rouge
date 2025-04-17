@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-indigo-600 flex items-center justify-between rounded-t-lg">
            <h2 class="text-2xl font-extrabold text-white">{{ __('Réinitialisation du mot de passe') }}</h2>
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10">
        </div>

        <div class="p-6">
            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">{{ __('Adresse e-mail') }}</label>
                    <input id="email" type="email" class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-opacity-50 transition duration-300 ease-in-out" aria-label="Envoyer le lien de réinitialisation">
                        {{ __('Envoyer le lien de réinitialisation') }}
                    </button>

                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm transition duration-300 ease-in-out" aria-label="Retour à la connexion">
                        {{ __('Retour à la connexion') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
