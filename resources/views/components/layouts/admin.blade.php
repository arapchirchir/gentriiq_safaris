@props(['title' => 'Staff Portal'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | Gentriiq Safaris Management</title>

    <!-- Theme Initialization (Prevents FOUC) -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @notifyCss
</head>

<body
    class="h-full bg-[#FAF6F0] text-[#211915] antialiased transition-colors duration-200 dark:bg-[#180D08] dark:text-[#FAF6F0]"
    x-data="{
        mobileSidebarOpen: false,
        isDark: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }">

    <div class="min-h-full">
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div x-show="mobileSidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true"
            style="display: none;">
            <div x-show="mobileSidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/80"></div>

            <div class="fixed inset-0 flex">
                <div x-show="mobileSidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                    class="relative mr-16 flex w-full max-w-xs flex-1">
                    <div class="absolute top-0 left-full flex w-16 justify-center pt-5">
                        <button type="button" @click="mobileSidebarOpen = false" class="-m-2.5 p-2.5 text-white">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Sidebar Content -->
                    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-[#24140E] px-6 pb-4">
                        <div class="flex h-16 shrink-0 items-center border-b border-white/10">
                            <span class="font-serif text-lg font-black tracking-wider text-[#FAF6F0]">
                                GENTRIIQ <span class="text-[#D96B27]">STAFF</span>
                            </span>
                        </div>
                        <nav class="flex flex-1 flex-col">
                            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                <li>
                                    <ul role="list" class="-mx-2 space-y-1">
                                        <li>
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#D96B27] text-white' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex gap-x-3 rounded-sm p-2 text-sm font-semibold leading-6">
                                                Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.inquiries.index') }}"
                                                class="{{ request()->routeIs('admin.inquiries.*') ? 'bg-[#D96B27] text-white' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex gap-x-3 rounded-sm p-2 text-sm font-semibold leading-6">
                                                Safari plans
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.tours.index') }}"
                                                class="{{ request()->routeIs('admin.tours.*') ? 'bg-[#D96B27] text-white' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex gap-x-3 rounded-sm p-2 text-sm font-semibold leading-6">
                                                Tours & Packages
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.destinations.index') }}"
                                                class="{{ request()->routeIs('admin.destinations.*') ? 'bg-[#D96B27] text-white' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex gap-x-3 rounded-sm p-2 text-sm font-semibold leading-6">
                                                Destinations
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.experiences.index') }}"
                                                class="{{ request()->routeIs('admin.experiences.*') ? 'bg-[#D96B27] text-white' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex gap-x-3 rounded-sm p-2 text-sm font-semibold leading-6">
                                                Experiences
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mt-auto pt-6">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full rounded-sm border border-white/20 bg-white/5 px-3 py-2 text-center text-xs font-bold text-white transition-colors hover:bg-white/15">
                                            Sign out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <div
                class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-black/10 bg-[#24140E] px-6 pb-4 text-[#FAF6F0]">
                <!-- Brand Header -->
                <div class="flex h-20 shrink-0 items-center justify-between border-b border-white/10">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3">
                        <div
                            class="flex size-10 items-center justify-center rounded-sm bg-[#D96B27] text-white font-black text-xl">
                            G
                        </div>
                        <div>
                            <span
                                class="block font-serif text-sm font-black tracking-widest text-[#FAF6F0]">GENTRIIQ</span>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-[#D96B27]">Management
                                Portal</span>
                        </div>
                    </a>
                </div>

                <!-- Logged In User Card -->
                <div class="rounded-sm border border-white/10 bg-black/20 p-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex size-9 items-center justify-center rounded-full bg-[#D96B27]/20 font-bold text-sm text-[#D96B27]">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-xs font-bold text-white">{{ auth()->user()->name }}</p>
                            <span
                                class="inline-block rounded-xs bg-[#D96B27]/20 px-1.5 py-0.5 text-[10px] font-bold text-[#D96B27]">
                                {{ auth()->user()->role_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <div class="text-[11px] font-bold uppercase tracking-wider text-white/40">Core Operations
                            </div>
                            <ul role="list" class="-mx-2 mt-2 space-y-1">
                                <li>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#D96B27] text-white font-bold shadow-xs' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex items-center gap-x-3 rounded-sm p-2.5 text-xs font-semibold">
                                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span>Dashboard Overview</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.inquiries.index') }}"
                                        class="{{ request()->routeIs('admin.inquiries.*') ? 'bg-[#D96B27] text-white font-bold shadow-xs' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex items-center justify-between rounded-sm p-2.5 text-xs font-semibold">
                                        <div class="flex items-center gap-x-3">
                                            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>Safari plans</span>
                                        </div>
                                        @php
                                            $pendingCount = \App\Models\Inquiry::where('status', 'new')->count();
                                        @endphp
                                        @if ($pendingCount > 0)
                                            <span
                                                class="rounded-full bg-emerald-500 px-2 py-0.5 text-[10px] font-black text-white">
                                                {{ $pendingCount }}
                                            </span>
                                        @endif
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.tours.index') }}"
                                        class="{{ request()->routeIs('admin.tours.*') ? 'bg-[#D96B27] text-white font-bold shadow-xs' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex items-center gap-x-3 rounded-sm p-2.5 text-xs font-semibold">
                                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                                        </svg>
                                        <span>Tours & Packages</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.destinations.index') }}"
                                        class="{{ request()->routeIs('admin.destinations.*') ? 'bg-[#D96B27] text-white font-bold shadow-xs' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex items-center gap-x-3 rounded-sm p-2.5 text-xs font-semibold">
                                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Destinations</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.experiences.index') }}"
                                        class="{{ request()->routeIs('admin.experiences.*') ? 'bg-[#D96B27] text-white font-bold shadow-xs' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} group flex items-center gap-x-3 rounded-sm p-2.5 text-xs font-semibold">
                                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Experiences</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Quick External Links -->
                        <li class="mt-auto">
                            <a href="{{ route('home') }}" target="_blank"
                                class="flex items-center justify-between rounded-sm border border-white/10 p-2.5 text-xs text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white">
                                <span class="flex items-center gap-2">
                                    <svg class="size-4 text-[#D96B27]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    <span>View Live Website</span>
                                </span>
                                <span>&rarr;</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                                @csrf
                                <button type="submit"
                                    class="w-full rounded-sm border border-white/20 bg-white/5 px-3 py-2 text-center text-xs font-bold text-white transition-colors hover:bg-white/15">
                                    Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main Header & Content Area -->
        <div class="lg:pl-72 flex flex-col min-h-screen">
            <!-- Top Navbar -->
            <header
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-black/10 bg-white px-4 shadow-xs sm:gap-x-6 sm:px-6 lg:px-8 dark:border-white/10 dark:bg-[#24140E]">
                <button type="button" @click="mobileSidebarOpen = true"
                    class="-m-2.5 p-2.5 text-gray-700 lg:hidden dark:text-white">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Breadcrumbs/Title -->
                <div class="flex flex-1 items-center justify-between">
                    <div>
                        <h1 class="text-sm font-bold text-[#211915] sm:text-base dark:text-white">
                            {{ $title }}
                        </h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Theme Toggle Button -->
                        <button type="button" @click="toggleTheme()"
                            class="inline-flex items-center justify-center size-9 rounded-sm border border-black/10 bg-[#FAF6F0] text-[#211915] transition-colors hover:bg-black/5 dark:border-white/10 dark:bg-[#180D08] dark:text-[#FAF6F0] dark:hover:bg-white/10"
                            aria-label="Toggle dark mode">
                            <svg x-show="!isDark" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg x-show="isDark" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">
                <!-- Flash Notification Banner -->
                @if (session('success'))
                    <div
                        class="mb-6 rounded-sm border border-emerald-500/30 bg-emerald-500/10 p-4 text-emerald-900 dark:text-emerald-200">
                        <div class="flex items-center gap-3">
                            <svg class="size-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs font-semibold sm:text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    @php
                        notify()->error('Please check the form below and fix the errors.', 'Fix found errors');
                    @endphp
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <x-notify::notify />
    @notifyJs
</body>

</html>
