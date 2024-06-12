<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body class="font-sans antialiased">
    <div id="app">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                        </button>
                                    </template>

                                    <template #content>


                                        <div class="border-t border-gray-100"></div>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <dropdown-link href="{{ route('logout') }}" @click.prevent="$refs.logoutForm.submit();">
                                                {{ __('Log Out') }}
                                            </dropdown-link>
                                        </form>
                                    </template>
                                </dropdown>
                            </div>
                        @else
                            <div class="ml-3 relative">
                                <a href="{{ route('login1') }}" class="text-sm text-gray-700 underline">Login</a>
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>
</body>
</html>