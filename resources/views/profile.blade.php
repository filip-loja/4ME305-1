<x-app-layout>

    <div class="flex justify-center">
        <div class="w-full sm:w-10/12 px-6 py-4 my-4 bg-white border border-gray-200 shadow-md overflow-hidden sm:rounded-lg">
            <h1 class="text-xl font-bold text-center mb-3">{{ __('Update your profile') }}</h1>

            @if ($message = session('success'))
                <div class="flex justify-between text-sm text-left text-green-600 bg-green-200 border border-green-400 min-h-12 flex items-center p-4 rounded-md mb-4" role="alert">
                    <div>{{ $message }}</div>
                    <a class="cursor-pointer" href="{{ request()->url() }}">X</a>
                </div>
            @endif

            @if ($message = session('error'))
                <div class="flex justify-between text-sm text-left text-red-600 bg-red-200 border border-red-400 min-h-12 flex items-center p-4 rounded-md mb-4" role="alert">
                    <div>{{ $message }}</div>
                    <a class="cursor-pointer" href="{{ request()->url() }}">X</a>
                </div>
            @endif

            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('update-profile') }}">
            @csrf

                <div>
                    <x-label for="name" :value="__('Name')" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $model['name'])" required autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="language" :value="__('Language')" />
                    <select id="language" name="language" required class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                        @foreach(config('app.allowed_locales') as $locale)
                            <option value="{{ $locale }}"
                            @if ($locale === old('language', $model['language']))
                                selected
                            @endif
                            >{{ $locale }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <x-label for="token" :value="__('Facebook token')" />
                    <x-input id="token" class="block mt-1 w-full" type="text" name="token" :value="old('facebook_token', $model['facebook_token'])" />
                </div>

                <div class="mt-4">
                    <x-label for="page" :value="__('Facebook page ID')" />
                    <x-input id="page" class="block mt-1 w-full" type="text" name="page" :value="old('facebook_page', $model['facebook_page'])" />
                </div>


                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
