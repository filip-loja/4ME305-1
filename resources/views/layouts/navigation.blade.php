@php
    $links = [
        'dashboard' => 'Dashboard',
        'user-list' => 'User List',
        'facebook' => 'Facebook'
    ];
@endphp
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    @auth<a href="{{ route('dashboard') }}">@endauth
                    @guest<a href="{{ route('welcome') }}">@endguest
                        <div class="flex items-center">
                            <div>
                                <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                            </div>
                            <div class="pl-2 font-bold">Assignment 1</div>
                        </div>
                    </a>
                </div>

                @auth
                <!-- Navigation Links -->
                <div class="hidden sm:-my-px sm:ml-10 sm:flex">
                    @foreach($links as $path => $label)
                        <x-nav-link :href="route($path)" :active="request()->routeIs($path)">
                            {{ __($label) }}
                        </x-nav-link>
                    @endforeach
                </div>
                @endauth
            </div>

            <div class="flex items-center">

                @guest<div class="hidden sm:flex sm:items-center sm:ml-6 pt-0.5">@endguest
                @auth<div class="hidden sm:flex sm:items-center sm:ml-6">@endauth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ app()->getLocale() }}</div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @foreach(config('app.allowed_locales') as $locale)
                                <x-dropdown-link :href="url('/set-locale/' . $locale)">
                                    {{ $locale }}
                                </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                </div>

                @guest
                    <div class="self-stretch hidden sm:flex sm:items-stretch sm:ml-6">
                        <x-nav-link :href="route('login')">{{ __('Log In') }}</x-nav-link>
                        <x-nav-link :href="route('register')">{{ __('Register') }}</x-nav-link>
                    </div>
                @endguest

                @auth
                <!-- User Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endauth

            </div>


            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @foreach($links as $path => $label)
                    <x-responsive-nav-link :href="route($path)" :active="request()->routeIs($path)">
                        {{ __($label) }}
                    </x-responsive-nav-link>
                @endforeach
            @endauth
            @guest
                <x-responsive-nav-link :href="route('login')">{{ __('Log In') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
            @endguest
        </div>

        @auth
        <!-- Responsive Settings Options -->
        <div class="pb-1 border-t border-gray-300">
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth

    </div>
</nav>