<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" type="image/svg" href="{{ asset('img/fire.svg') }}" />
        <title>
            {{ $title ? $title.' | '. config("app.name") : config("app.name")}}
        </title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Fonts -->
        <!-- <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
            rel="stylesheet"
        /> -->
    </head>
    <body
        class="antialiased figtree bg-gray-50 dark:bg-gray-800 text-gray-800 flex flex-col min-h-screen"
    >
        <!-- Header -->
        <header class="bg-white shadow dark:bg-gray-900 sticky top-0 z-50">
            <div
                class="container mx-auto px-4 md:px-20 py-4 flex items-center justify-between"
            >
                <h1
                    class="text-xl font-bold text-custom-red-600 hover:text-custom-red-500"
                >
                    <a href="{{ route('/') }}">
                        <i
                            class="ri-fire-fill text-2xl text-custom-red-500 hover:text-custom-red-500"
                        ></i>
                        {{ config("app.name") }}
                    </a>
                </h1>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a
                        href="{{ route('/') }}"
                        class="font-semibold
                        {{
                            $title === ''
                                ? 'active'
                                : 'text-custom-red-950 dark:text-custom-red-50 hover:text-custom-red-600 hover:dark:text-custom-red-600'
                        }}
                        "
                    >
                        Home
                    </a>
                    <a
                        href="{{ route('posts') }}"
                        class="font-semibold
                        {{
                            $title === 'Posts' ||
                            $title === 'Post Detail' ||
                            $title === 'Post Create'
                                ? 'active'
                                : 'text-custom-red-950 dark:text-custom-red-50 hover:text-custom-red-600 hover:dark:text-custom-red-600'
                        }}
                        "
                    >
                        Post
                    </a>
                    <a
                        href="{{ route('users') }}"
                        class="font-semibold
                        {{
                            $title === 'Users' || $title === 'User Profile'
                                ? 'active'
                                : 'text-custom-red-950 dark:text-custom-red-50 hover:text-custom-red-600 hover:dark:text-custom-red-600'
                        }}
                        "
                    >
                        User
                    </a>

                    <!-- Toggle Theme (desktop) -->
                    <button
                        id="theme-toggle"
                        class="ml-4 w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:text-custom-red-800 hover:dark:text-custom-red-600 hover:bg-gray-200 hover:dark:bg-gray-800"
                    >
                        <i
                            id="theme-toggle-icon"
                            class="ri-moon-line text-xl"
                        ></i>
                    </button>
                </nav>

                <div class="flex items-center gap-2 md:hidden">
                    <!-- Toggle Theme (mobile) -->
                    <button
                        id="theme-toggle-mobile"
                        class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:text-custom-red-800 hover:dark:text-custom-red-600 hover:bg-gray-200 hover:dark:bg-gray-800"
                    >
                        <i
                            id="theme-toggle-icon-mobile"
                            class="ri-moon-line text-lg"
                        ></i>
                    </button>

                    <!-- Hamburger -->
                    <button
                        id="hamburger"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-400 hover:dark:bg-gray-500"
                        aria-expanded="false"
                        aria-controls="mobile-sidebar"
                    >
                        <i id="hamburger-icon" class="ri-menu-line text-xl"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Sidebar Mobile (Right Drawer) -->
        <aside
            id="mobile-sidebar"
            class="fixed top-0 right-0 h-full w-64 bg-white dark:bg-gray-900 shadow-lg transform translate-x-full transition-transform duration-300 z-[60]"
        >
            <div class="p-6 space-y-4">
                <!-- Header Sidebar -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-custom-red-600">
                        Menu
                    </h2>
                    <button
                        id="close-sidebar"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 hover:dark:bg-gray-600"
                    >
                        <i class="ri-close-line text-lg"></i>
                    </button>
                </div>

                <!-- Navigasi -->
                <nav class="flex flex-col space-y-3">
                    <a
                        href="{{ route('/') }}"
                        class="font-semibold border-b border-custom-red-50
                        {{
                            $title === ''
                                ? 'active'
                                : 'text-custom-red-950 dark:text-custom-red-50 hover:text-custom-red-600 hover:dark:text-custom-red-600'
                        }}
                        "
                    >
                        Home
                    </a>
                    <a
                        href="{{ route('posts') }}"
                        class="font-semibold border-b border-custom-red-50
                        {{
                            $title === 'Posts' || $title === 'Post Detail'
                                ? 'active'
                                : 'text-custom-red-950 dark:text-custom-red-50 hover:text-custom-red-600 hover:dark:text-custom-red-600'
                        }}
                        "
                    >
                        Post
                    </a>
                    <a
                        href="{{ route('users') }}"
                        class="font-semibold border-b border-custom-red-50
                        {{
                            $title === 'Users' || $title === 'User Profile'
                                ? 'active'
                                : 'text-custom-red-950 dark:text-custom-red-50 hover:text-custom-red-600 hover:dark:text-custom-red-600'
                        }}
                        "
                    >
                        User
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Backdrop -->
        <div
            id="backdrop"
            class="fixed inset-0 bg-black/40 hidden z-[55]"
        ></div>

        <!-- Alert -->
        @if (session('success'))
        <x-alert type="success" :message="session('success')" />
        @endif @if (session('error'))
        <x-alert type="error" :message="session('error')" />
        @endif @if (session('info'))
        <x-alert type="info" :message="session('info')" />
        @endif

        <!-- Main Content -->
        <main class="container mx-auto py-2 md:px-20 md:py-4 flex-grow">
            @yield('content')
        </main>

        <!-- Scroll To Top -->
        <button
            id="scroll-to-top"
            class="hidden fixed bottom-6 right-6 w-12 h-12 rounded-full bg-custom-red-600 text-white shadow-lg hover:bg-custom-red-500 transition flex items-center justify-center"
        >
            <i class="ri-arrow-up-line text-xl"></i>
        </button>

        <!-- Footer -->
        <footer
            class="bg-gray-100 dark:bg-gray-900 text-center text-gray-600 dark:text-custom-red-50 py-10 text-sm"
        >
            &copy; {{ date("Y") }} {{ config("app.name", "Laravel") }} - All
            rights reserved.
        </footer>

        @yield('scripts')
    </body>
</html>
