<x-app-layout>

    <div class="flex flex-col items-center">
        <h1 class="text-5xl font-bold pb-4 max-w-4xl text-center text-indigo-800">
            {{ __('Welcome, :name', ['name' => Auth::user()->name]) }}
        </h1>
        <h2 class="text-2xl font-bold pb-4 text-center">{{ __('You\'re logged in!') }}</h2>
    </div>

    <div class="flex justify-center">
        <img src="{{ asset('/animation.gif') }}" alt="dummy image" title="Dummy image" />
    </div>

</x-app-layout>
