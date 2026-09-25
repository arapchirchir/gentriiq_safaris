@props(['title' => 'Staff Portal'])

@php
    $user = auth()->user();
    $pendingCount = $user->isSales() ? \App\Models\Inquiry::where('status', 'new')->count() : 0;

    // Single source for desktop and mobile navigation; each link is shown only to roles that can open it.
    $navigation = collect([
        [
            'label' => 'Dashboard Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'visible' => true,
            'icon' => ['M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ],
        [
            'label' => 'Safari plans', 'route' => 'admin.inquiries.index', 'active' => 'admin.inquiries.*', 'visible' => $user->isSales(), 'badge' => $pendingCount,
            'icon' => ['M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ],
        [
            'label' => 'Tours & Packages', 'route' => 'admin.tours.index', 'active' => 'admin.tours.*', 'visible' => $user->isEditor(),
            'icon' => ['M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064'],
        ],
        [
            'label' => 'Destinations', 'route' => 'admin.destinations.index', 'active' => 'admin.destinations.*', 'visible' => $user->isEditor(),
            'icon' => ['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ],
        [
            'label' => 'Experiences', 'route' => 'admin.experiences.index', 'active' => 'admin.experiences.*', 'visible' => $user->isEditor(),
            'icon' => ['M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ],
    ])->where('visible');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

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

{{-- App shell: full-width top bar; below it the sidebar and main content scroll independently. --}}
<body
    class="h-full overflow-hidden bg-[#FAF6F0] text-[#211915] antialiased transition-colors duration-200 dark:bg-[#180D08] dark:text-[#FAF6F0]"
    x-data="{
        mobileSidebarOpen: false,
        toggleTheme() {
            const dark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', dark ? 'dark' : 'light');
        }
    }"
    @keydown.escape.window="mobileSidebarOpen = false">

    <div class="flex h-full flex-col">
        <!-- Top Navigation -->
        <header class="z-40 flex h-16 shrink-0 items-center gap-3 border-b border-white/10 bg-[#24140E] px-4 text-[#FAF6F0] sm:px-6">
            <button type="button" @click="mobileSidebarOpen = !mobileSidebarOpen" :aria-expanded="mobileSidebarOpen"
                aria-controls="admin-sidebar-mobile"
                class="-ml-1 rounded-sm p-2 text-[#FAF6F0]/80 hover:bg-white/10 hover:text-white focus-visible:outline-2 focus-visible:outline-[#D96B27] lg:hidden">
                <span class="sr-only">Toggle navigation</span>
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <a href="{{ route('admin.dashboard') }}" class="flex shrink-0 items-center focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27]"
                aria-label="Gentriiq Safaris & Tours — staff dashboard">
                <img src="{{ asset('assets/logo-dark.png') }}" alt="Gentriiq Safaris & Tours" width="1259" height="821"
                    class="h-11 w-auto object-contain">
            </a>

            <div class="ml-auto flex items-center gap-2 sm:gap-3">
                <button type="button" @click="toggleTheme()" aria-label="Toggle dark mode"
                    class="inline-flex size-9 items-center justify-center rounded-sm border border-white/15 text-[#FAF6F0] transition-colors hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-[#D96B27]">
                    {{-- CSS-driven so the correct icon shows on first paint. --}}
                    <svg class="size-4 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg class="hidden size-4 dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <!-- User menu -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button type="button" @click="open = !open" :aria-expanded="open" aria-expanded="false" aria-haspopup="menu"
                        aria-controls="admin-user-menu"
                        class="flex items-center gap-2 rounded-sm py-1 pr-2 pl-1 text-left transition-colors hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-[#D96B27]">
                        <span class="flex size-8 items-center justify-center rounded-full bg-[#D96B27] text-sm font-bold text-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                        <span class="hidden max-w-40 truncate text-xs font-bold text-white sm:block">{{ $user->name }}</span>
                        <svg class="size-4 text-[#FAF6F0]/70 transition-transform" :class="open && 'rotate-180'" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                        <span class="sr-only">Open user menu</span>
                    </button>

                    <div id="admin-user-menu" x-show="open" x-cloak role="menu"
                        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 z-50 mt-2 w-64 origin-top-right overflow-hidden rounded-sm border border-black/10 bg-white text-[#211915] shadow-lg dark:border-white/10 dark:bg-[#24140E] dark:text-[#FAF6F0]">
                        <div class="border-b border-black/10 px-4 py-3 dark:border-white/10">
                            <p class="truncate text-sm font-bold">{{ $user->name }}</p>
                            <p class="truncate text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">{{ $user->email }}</p>
                            <span class="mt-1.5 inline-block rounded-xs bg-[#D96B27]/15 px-1.5 py-0.5 text-[10px] font-bold text-[#BF5A1B] dark:text-[#D96B27]">
                                {{ $user->role_label }}
                            </span>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('home') }}" target="_blank" rel="noopener" role="menuitem"
                                class="flex items-center justify-between px-4 py-2 text-xs font-semibold hover:bg-black/5 focus-visible:bg-black/5 focus-visible:outline-none dark:hover:bg-white/10 dark:focus-visible:bg-white/10">
                                View Live Website
                                <svg class="size-3.5 text-[#6E635C] dark:text-[#FAF6F0]/60" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-black/10 py-1 dark:border-white/10">
                            @csrf
                            <button type="submit" role="menuitem"
                                class="w-full px-4 py-2 text-left text-xs font-semibold text-red-600 hover:bg-red-500/10 focus-visible:bg-red-500/10 focus-visible:outline-none dark:text-red-400">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="relative flex min-h-0 flex-1">
            <!-- Sidebar (desktop) -->
            <aside class="hidden w-64 shrink-0 overflow-y-auto border-r border-white/10 bg-[#24140E] lg:block"
                aria-label="Staff navigation">
                @include('admin.partials.nav', ['navigation' => $navigation])
            </aside>

            <!-- Sidebar (mobile drawer, below the top bar) -->
            <div x-show="mobileSidebarOpen" x-cloak class="absolute inset-0 z-30 lg:hidden">
                <div x-show="mobileSidebarOpen" x-transition.opacity @click="mobileSidebarOpen = false"
                    class="absolute inset-0 bg-black/60"></div>
                <aside id="admin-sidebar-mobile" x-show="mobileSidebarOpen"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                    class="relative h-full w-72 max-w-[85%] overflow-y-auto bg-[#24140E] shadow-xl" aria-label="Staff navigation">
                    @include('admin.partials.nav', ['navigation' => $navigation, 'mobile' => true])
                </aside>
            </div>

            <!-- Main Content -->
            <main class="min-w-0 flex-1 overflow-y-auto">
                <div class="px-4 py-8 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="mb-6 rounded-sm border border-emerald-500/30 bg-emerald-500/10 p-4 text-emerald-900 dark:text-emerald-200"
                            role="status">
                            <div class="flex items-center gap-3">
                                <svg class="size-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
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
                </div>
            </main>
        </div>
    </div>

    <x-notify::notify />
    @notifyJs
</body>

</html>
