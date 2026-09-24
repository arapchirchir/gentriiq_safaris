@props([
    'title' => null,
    'description' =>
        'Discover Kenya and East Africa with Gentriiq Safaris & Tours. Tailor-made luxury, private, and group wildlife safaris across Maasai Mara, Amboseli, Serengeti, and beyond.',
    'ogImage' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ $title ? $title . ' | Gentriiq Safaris & Tours' : 'Gentriiq Safaris & Tours — Authentic East African Safaris & Adventures' }}
    </title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Theme Initialization (Prevents FOUC) -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title"
        content="{{ $title ? $title . ' | Gentriiq Safaris & Tours' : 'Gentriiq Safaris & Tours — Authentic East African Safaris & Adventures' }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('assets/logo.jpg') }}">
    <meta property="og:site_name" content="Gentriiq Safaris & Tours">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title"
        content="{{ $title ? $title . ' | Gentriiq Safaris & Tours' : 'Gentriiq Safaris & Tours — Authentic East African Safaris & Adventures' }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $ogImage ?? asset('assets/logo.jpg') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body id="top"
    class="min-h-screen bg-[#FAF6F0] font-sans text-[#211915] antialiased selection:bg-[#D96B27] selection:text-white dark:bg-[#180D08] dark:text-[#FAF6F0]">
    <!-- Accessibility Skip Link -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-sm focus:bg-[#D96B27] focus:px-4 focus:py-2 focus:text-white focus:shadow-lg">
        Skip to main content
    </a>

    <!-- Sticky Navigation -->
    <x-navbar />

    <!-- Main Content -->
    <main id="main-content">
        {{ $slot }}
    </main>

    <!-- Shared Footer -->
    <x-footer />

    <!-- Sticky Quick WhatsApp Floating Button (Mobile & Desktop) -->
    <aside aria-label="Quick contact" class="fixed right-5 bottom-6 z-40">
        <a href="https://wa.me/254717838061?text=Hello%20Gentriiq%20Safaris,%20I%20would%20like%20to%20plan%20a%20safari."
            target="_blank" rel="noopener noreferrer"
            class="group flex items-center gap-2 rounded-full bg-[#25D366] px-4 py-3 text-sm font-semibold text-white shadow-lg transition-transform hover:scale-105 hover:bg-[#20ba59] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#25D366]"
            aria-label="Chat with Gentriiq Safaris & Tours on WhatsApp">
            <svg class="size-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                <path
                    d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.969.54 1.761.815 2.791.815 3.179 0 5.768-2.587 5.769-5.767.001-3.18-2.586-5.767-5.768-5.767zm9.969 5.765c0 5.518-4.482 10-10 10-1.748 0-3.385-.45-4.819-1.242l-5.181 1.357 1.383-5.053c-.886-1.488-1.383-3.228-1.383-5.062 0-5.518 4.482-10 10-10 5.518 0 10 4.482 10 10z" />
            </svg>
            <span class="hidden sm:inline">WhatsApp</span>
        </a>
    </aside>
</body>

</html>
