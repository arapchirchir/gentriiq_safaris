<x-layouts.public :title="$tour->title" :description="$tour->short_description" :ogImage="$tour->hero_image">
    <div class="bg-[#FAF6F0] py-12 dark:bg-[#180D08] sm:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-8 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                <a href="{{ route('home') }}" class="hover:text-[#D96B27]">Home</a>
                <span class="mx-2">/</span>
                <span class="text-[#211915] dark:text-white">{{ $tour->title }}</span>
            </nav>

            <div class="grid gap-10 lg:grid-cols-[1.4fr_0.6fr] lg:items-start">
                <div>
                    <div class="relative aspect-16/9 overflow-hidden rounded-sm bg-black">
                        <img src="{{ $tour->hero_image }}" alt="{{ $tour->title }}" class="size-full object-cover">
                        @if ($tour->badge)
                            <span
                                class="absolute top-4 left-4 rounded-sm bg-[#D96B27] px-3 py-1.5 text-xs font-bold text-white">{{ $tour->badge }}</span>
                        @endif
                    </div>
                    <div class="mt-8 flex flex-wrap gap-3 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                        <span
                            class="rounded-sm bg-white px-3 py-2 shadow-xs dark:bg-[#24140E]">{{ $tour->duration_days }}
                            Days / {{ $tour->duration_nights }} Nights</span>
                        <span
                            class="rounded-sm bg-white px-3 py-2 shadow-xs dark:bg-[#24140E]">{{ ucfirst($tour->tour_type) }}
                            safari</span>
                        <span
                            class="rounded-sm bg-white px-3 py-2 shadow-xs dark:bg-[#24140E]">{{ $tour->country }}</span>
                    </div>
                </div>

                <aside
                    class="rounded-sm border border-black/10 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-[#24140E] lg:sticky lg:top-28">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Starting from</p>
                    <p class="mt-2 text-3xl font-extrabold text-[#211915] dark:text-white">{{ $tour->formatted_price }}
                        <span class="text-sm font-normal text-[#6E635C] dark:text-[#FAF6F0]/60">/ person</span>
                    </p>
                    <div class="mt-6 grid gap-3">
                        <x-button href="{{ route('plan.create', ['tour' => $tour->slug]) }}" variant="primary"
                            size="lg" class="w-full justify-center">
                            Plan This Safari
                        </x-button>
                        <a href="https://wa.me/254717838061?text={{ urlencode('Hello Gentriiq Safaris & Tours, I am interested in the ' . $tour->title . ' package: ' . route('tours.show', $tour)) }}"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center rounded-sm border border-[#D96B27] px-5 py-3 text-sm font-semibold text-[#D96B27] transition-colors hover:bg-[#D96B27]/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
                            Inquire on WhatsApp
                        </a>
                    </div>
                </aside>
            </div>

            <div class="mt-14 grid gap-12 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-12">
                    <section>
                        <p class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">The journey</p>
                        <h1 class="mt-2 text-3xl font-extrabold text-[#211915] dark:text-white sm:text-4xl">
                            {{ $tour->title }}</h1>
                        <p class="mt-5 text-base leading-7 text-[#6E635C] dark:text-[#FAF6F0]/70">
                            {{ $tour->description ?: $tour->short_description }}</p>
                    </section>

                    @if (!empty($tour->highlights))
                        <section>
                            <h2 class="text-2xl font-bold text-[#211915] dark:text-white">Safari highlights</h2>
                            <ul class="mt-5 grid gap-3 sm:grid-cols-2">
                                @foreach ($tour->highlights as $highlight)
                                    <li class="flex gap-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70"><span
                                            class="text-[#D96B27]">&#10003;</span><span>{{ $highlight }}</span></li>
                                @endforeach
                            </ul>
                        </section>
                    @endif

                    <section>
                        <h2 class="text-2xl font-bold text-[#211915] dark:text-white">Detailed itinerary</h2>
                        <div class="mt-6 space-y-4">
                            @foreach ($tour->days as $day)
                                <article
                                    class="rounded-sm border border-black/10 bg-white p-5 dark:border-white/10 dark:bg-[#24140E]">
                                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                                        <h3 class="text-lg font-bold text-[#211915] dark:text-white">Day
                                            {{ $day->day_number }}: {{ $day->title }}</h3>
                                        <span
                                            class="text-xs font-semibold uppercase tracking-wider text-[#D96B27]">{{ $day->location }}</span>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-[#6E635C] dark:text-[#FAF6F0]/70">
                                        {{ $day->description }}</p>
                                    @if ($day->accommodation || $day->meals)
                                        <p class="mt-3 text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">
                                            {{ $day->accommodation }}@if ($day->accommodation && $day->meals)
                                                <span class="mx-1">&bull;</span>
                                            @endif{{ $day->meals }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="space-y-8">
                    <section>
                        <h2 class="text-2xl font-bold text-[#211915] dark:text-white">Destinations</h2>
                        <div class="mt-4 grid gap-3">
                            @foreach ($tour->destinations as $destination)
                                <a href="{{ route('destinations.show', $destination) }}"
                                    class="group flex items-center gap-3 rounded-sm border border-black/10 bg-white p-3 transition-colors hover:border-[#D96B27] dark:border-white/10 dark:bg-[#24140E]">
                                    <img src="{{ $destination->image }}" alt="{{ $destination->name }}"
                                        class="size-16 rounded-sm object-cover">
                                    <span
                                        class="font-semibold text-[#211915] group-hover:text-[#D96B27] dark:text-white">{{ $destination->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </section>

                    @foreach (['inclusions' => "What's included", 'exclusions' => "What's excluded"] as $field => $heading)
                        @if (!empty($tour->{$field}))
                            <section>
                                <h2 class="text-xl font-bold text-[#211915] dark:text-white">{{ $heading }}</h2>
                                <ul class="mt-4 space-y-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                                    @foreach ($tour->{$field} as $item)
                                        <li class="flex gap-2"><span
                                                class="text-[#D96B27]">&bull;</span><span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
