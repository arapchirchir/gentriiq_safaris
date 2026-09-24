@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} | Gentriiq Safaris & Tours</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FAF6F0] font-sans text-[#211915] antialiased dark:bg-[#180D08] dark:text-[#FAF6F0]">
    <main class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6">
        <div class="w-full max-w-md space-y-8">
            <a href="{{ route('home') }}"
                class="mx-auto block w-48 rounded-sm focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27]">
                <img src="{{ asset('assets/logo-light.png') }}" alt="Gentriiq Safaris & Tours — home" width="1259"
                    height="821" class="w-full dark:hidden">
                <img src="{{ asset('assets/logo-dark.png') }}" alt="Gentriiq Safaris & Tours — home" width="1259"
                    height="821" class="hidden w-full dark:block">
            </a>
            <section aria-labelledby="page-title"
                class="space-y-6 rounded-sm border border-black/10 bg-white p-6 shadow-sm sm:p-8 dark:border-white/10 dark:bg-[#24140E]">
                <h1 id="page-title" class="text-2xl font-semibold">{{ $title }}</h1>
                {{ $slot }}
            </section>
            <a href="{{ route('home') }}"
                class="block text-center text-sm underline underline-offset-4 hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27]">Back
                to website</a>
        </div>
    </main>
</body>

</html>
