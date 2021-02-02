<x-app-layout>

    <div class="flex flex-col items-center">
        <h1 class="text-5xl font-bold pb-4 max-w-4xl text-center text-indigo-800">
            {{ __('Welcome to the demo project for assignment 1') }}
        </h1>
        <h2 class="text-2xl font-bold pb-4 text-center">{{ __('To proceed, please log-in or register') }}</h2>
        <h3 class="text-center">{{ __('Created by ') }} Filip Loja</h3>
        <div class="block pt-4">
            <a href="{{ route('login') }}" class="inline-block border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline mr-2"
            >
                {{ __('Log In') }}
            </a>
            <a href="{{ route('register') }}" class="inline-block border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline"
            >
                {{ __('Register') }}
            </a>
        </div>

    </div>

</x-app-layout>
