<x-layouts.admin title="New Safari Package">

@php
        $formTour = $tour ?? null;
        $formState = [
            'fallbackCountry' => old('country', $formTour?->country ?? 'Kenya'),
            'durationDays' => old('duration_days', $formTour?->duration_days ?? 1),
            'status' => old('status', $formTour?->status ?? 'draft'),
            'days' => old('days', $formTour?->days->map(fn ($day) => $day->only(['title', 'location', 'description', 'accommodation', 'meals']))->values()->all() ?? []),
            'selectedDestinations' => array_map('strval', (array) old('destinations', $formTour?->destinations->pluck('id')->all() ?? [])),
            'destinationOptions' => $destinations->map(fn ($destination) => $destination->only(['id', 'name', 'country']))->values()->all(),
            'errors' => $errors->messages(),
        ];
    @endphp
    <div class="space-y-6 w-full" x-data="tourFormPage(@js($formState))">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tours.index') }}"
                class="inline-flex size-8 items-center justify-center rounded-sm border border-black/10 bg-white text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                &larr;
            </a>
            <div>
                <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">New Safari Package</h2>
                <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Fill in the details — the slug is generated from
                    the title automatically.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-sm border border-red-500/40 bg-red-50 p-4 dark:border-red-500/30 dark:bg-red-950/20">
                <div class="flex items-center gap-2">
                    <svg class="size-5 shrink-0 text-red-600 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                    <h4 class="text-sm font-bold text-red-800 dark:text-red-200">Fix found errors</h4>
                </div>
                <ul class="mt-2.5 list-disc pl-7 text-xs text-red-700 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.tours.store') }}" class="space-y-6">
            @csrf

            <p class="text-sm text-[#6E635C] dark:text-white/70">Drafts can be incomplete. Publishing requires a summary, overview, image, positive price, destinations, and one titled, described itinerary entry for every day.</p>
            {{-- Section: Core Content --}}
            <div
                class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Core Content</h3>

                <div>
                    <label
                        class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="title">Tour
                        Title *</label>
                    <input type="text" id="title" name="title" maxlength="255" value="{{ old('title') }}" required
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="title" />
                </div>

                <div>
                    <label
                        class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="short_description">Short
                        Summary (required to publish)</label>
                    <textarea id="short_description" name="short_description" rows="2" :required="status === 'published'" maxlength="500"
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white p-3 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">{{ old('short_description') }}</textarea>
                        <x-form-error name="short_description" />
                </div>

                <div>
                    <label
                        class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70 mb-1.5">Detailed
                        Overview (required to publish)</label>
                    <x-tiptap-editor name="description" :content="old('description', '')" />
                    <x-form-error name="description" />
                </div>
            </div>

            {{-- Section: Details --}}
            <div
                class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Tour Details</h3>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="duration_days">Days
                            *</label>
                        <input type="number" id="duration_days" name="duration_days" min="1" max="365" x-model="durationDays" value="{{ old('duration_days', 1) }}"
                            required
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="duration_days" />
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="duration_nights">Nights
                            *</label>
                        <input type="number" id="duration_nights" name="duration_nights" min="0" :max="Math.max(0, Number(durationDays) - 1)"
                            value="{{ old('duration_nights', 0) }}" required
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="duration_nights" />
                        <p class="mt-1 text-xs text-[#6E635C] dark:text-white/70" x-text="`Usually ${Math.max(0, Number(durationDays) - 1)} nights. Must be fewer than the number of days.`"></p>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="starting_price">Price
                            *</label>
                        <input type="number" id="starting_price" name="starting_price" :min="status === 'published' ? 0.01 : 0" max="99999999.99" step="0.01"
                            value="{{ old('starting_price', 0) }}" required
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="starting_price" />
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="currency">Currency</label>
                        <select id="currency" name="currency"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                            @foreach (['USD', 'EUR', 'GBP', 'KES'] as $cur)
                                <option value="{{ $cur }}" @selected(old('currency', 'USD') === $cur)>{{ $cur }}
                                </option>
                            @endforeach
                        </select>
                        <x-form-error name="currency" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="tour_type">Tour
                            Type *</label>
                        <select id="tour_type" name="tour_type"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                            <option value="both" @selected(old('tour_type') === 'both')>Private &amp; Group</option>
                            <option value="private" @selected(old('tour_type') === 'private')>Private Only</option>
                            <option value="group" @selected(old('tour_type') === 'group')>Group Only</option>
                        </select>
                        <x-form-error name="tour_type" />
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="difficulty">Difficulty</label>
                        <select id="difficulty" name="difficulty"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                            <option value="">Easy (default)</option>
                            @foreach (['easy', 'moderate', 'challenging', 'extreme'] as $d)
                                <option value="{{ $d }}" @selected(old('difficulty') === $d)>{{ ucfirst($d) }}
                                </option>
                            @endforeach
                        </select>
                        <x-form-error name="difficulty" />
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="badge">Badge
                            Label</label>
                        <input type="text" id="badge" name="badge" maxlength="50" value="{{ old('badge') }}"
                            placeholder="e.g. Best Seller"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="badge" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="country">Country / countries</label>
                        <input type="text" id="country" name="country" maxlength="255" :readonly="selectedDestinations.length > 0" :value="countrySummary || fallbackCountry" value="{{ old('country') }}"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="country" />
                        <p class="mt-1 text-xs text-[#6E635C] dark:text-white/70">Filled from selected destinations. Check destination countries for combined routes.</p>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="location_summary">Location
                            Summary</label>
                        <input type="text" id="location_summary" name="location_summary" maxlength="255"
                            value="{{ old('location_summary') }}" placeholder="e.g. Maasai Mara, Serengeti"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="location_summary" />
                    </div>
                </div>
            </div>

            {{-- Section: Hero Image --}}
            <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4"
                x-data="{ url: @js(old('hero_image')) }">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Hero Image</h3>
                <div>
                    <label
                        class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="hero_image">Image
                        URL</label>
                    <input type="url" id="hero_image" name="hero_image" x-model="url" maxlength="255" :required="status === 'published'"
                        placeholder="https://images.unsplash.com/..."
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="hero_image" />
                </div>
                <div x-show="url" class="mt-3">
                    <img :src="url" alt="Hero preview" class="h-48 w-full rounded-sm object-cover">
                </div>
            </div>

            {{-- Section: Status & Visibility --}}
            <div
                class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Status &amp; Visibility</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="status">Publication
                            Status *</label>
                        <select id="status" name="status" x-model="status"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                            <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft (Hidden)</option>
                            <option value="published" @selected(old('status') === 'published')>Published (Live)</option>
                            <option value="archived" @selected(old('status') === 'archived')>Archived</option>
                        </select>
                        <x-form-error name="status" />
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="sort_order">Sort
                            Order</label>
                        <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', 0) }}"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="sort_order" />
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="featured" name="featured" value="1" @checked(old('featured'))
                                class="size-4 rounded-xs border-black/20 text-[#D96B27] focus:ring-[#D96B27]">
                            <span class="text-xs font-bold text-[#211915] dark:text-white">Featured on Homepage</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Section: Highlights --}}
            <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4"
                x-data="{ items: @js(old('highlights', [])) }">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Safari Highlights</h3>
                    <button type="button" @click="items.push('')"
                        class="rounded-sm bg-[#D96B27] px-3 py-1.5 text-xs font-bold text-white hover:bg-[#BF5A1B]">+
                        Add</button>
                </div>
                <div class="space-y-2">
                    <template x-for="(item, i) in items" :key="i">
                        <div class="flex gap-2">
                            <input type="text" :name="`highlights[${i}]`" x-model="items[i]" maxlength="255"
                                placeholder="e.g. Big Five game drives"
                                class="flex-1 rounded-sm border border-black/20 bg-white px-3.5 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                            <button type="button" @click="items.splice(i, 1)"
                                class="rounded-sm border border-black/10 px-2.5 text-xs text-[#6E635C] hover:bg-red-500/10 hover:text-red-600 dark:border-white/10 dark:text-[#FAF6F0]/60">
                                &times;
                            </button>
                        </div>
                    </template>
                    <p x-show="items.length === 0" class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">No highlights
                        yet — click + Add.</p>
                </div>
            </div>

            {{-- Section: Inclusions & Exclusions --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4"
                    x-data="{ items: @js(old('inclusions', [])) }">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">What's Included</h3>
                        <button type="button" @click="items.push('')"
                            class="rounded-sm bg-[#D96B27] px-3 py-1.5 text-xs font-bold text-white hover:bg-[#BF5A1B]">+
                            Add</button>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(item, i) in items" :key="i">
                            <div class="flex gap-2">
                                <input type="text" :name="`inclusions[${i}]`" x-model="items[i]" maxlength="255"
                                    placeholder="e.g. All park fees"
                                    class="flex-1 rounded-sm border border-black/20 bg-white px-3.5 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                                <button type="button" @click="items.splice(i, 1)"
                                    class="rounded-sm border border-black/10 px-2.5 text-xs text-[#6E635C] hover:bg-red-500/10 hover:text-red-600 dark:border-white/10 dark:text-[#FAF6F0]/60">
                                    &times;
                                </button>
                            </div>
                        </template>
                        <p x-show="items.length === 0" class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">None
                            added yet.</p>
                    </div>
                </div>

                <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4"
                    x-data="{ items: @js(old('exclusions', [])) }">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">What's Excluded</h3>
                        <button type="button" @click="items.push('')"
                            class="rounded-sm bg-[#D96B27] px-3 py-1.5 text-xs font-bold text-white hover:bg-[#BF5A1B]">+
                            Add</button>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(item, i) in items" :key="i">
                            <div class="flex gap-2">
                                <input type="text" :name="`exclusions[${i}]`" x-model="items[i]" maxlength="255"
                                    placeholder="e.g. International flights"
                                    class="flex-1 rounded-sm border border-black/20 bg-white px-3.5 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                                <button type="button" @click="items.splice(i, 1)"
                                    class="rounded-sm border border-black/10 px-2.5 text-xs text-[#6E635C] hover:bg-red-500/10 hover:text-red-600 dark:border-white/10 dark:text-[#FAF6F0]/60">
                                    &times;
                                </button>
                            </div>
                        </template>
                        <p x-show="items.length === 0" class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">None
                            added yet.</p>
                    </div>
                </div>
            </div>
            <x-tour-itinerary />

            <x-form-error name="destinations" />
            {{-- Section: Destinations --}}
            <div
                class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Destinations</h3>
                @if ($destinations->isEmpty())
                    <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">
                        No destinations yet. <a href="{{ route('admin.destinations.create') }}"
                            class="text-[#D96B27] hover:underline">Add one first.</a>
                    </p>
                @else
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                        @foreach ($destinations as $dest)
                            <label
                                class="flex cursor-pointer items-center gap-2 rounded-sm border border-black/10 p-2.5 hover:bg-black/5 dark:border-white/10 dark:hover:bg-white/5">
                                <input type="checkbox" name="destinations[]" x-model="selectedDestinations" value="{{ $dest->id }}"
                                    @checked(in_array((string) $dest->id, (array) old('destinations', [])))
                                    class="size-4 rounded-xs border-black/20 text-[#D96B27] focus:ring-[#D96B27]">
                                <span
                                    class="text-xs font-semibold text-[#211915] dark:text-white">{{ $dest->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            <x-form-error name="experiences" />
            {{-- Section: Experiences --}}
            <div
                class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Experiences / Activities</h3>
                @if ($experiences->isEmpty())
                    <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">No experiences in the system yet.</p>
                @else
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                        @foreach ($experiences as $exp)
                            <label
                                class="flex cursor-pointer items-center gap-2 rounded-sm border border-black/10 p-2.5 hover:bg-black/5 dark:border-white/10 dark:hover:bg-white/5">
                                <input type="checkbox" name="experiences[]" value="{{ $exp->id }}"
                                    @checked(in_array((string) $exp->id, (array) old('experiences', [])))
                                    class="size-4 rounded-xs border-black/20 text-[#D96B27] focus:ring-[#D96B27]">
                                <span
                                    class="text-xs font-semibold text-[#211915] dark:text-white">{{ $exp->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Section: SEO --}}
            <div
                class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">SEO</h3>
                <div>
                    <label
                        class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="meta_title">Meta
                        Title</label>
                    <input type="text" id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title') }}"
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <x-form-error name="meta_title" />
                </div>
                <div>
                    <label
                        class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70" for="meta_description">Meta
                        Description</label>
                    <textarea id="meta_description" name="meta_description" rows="2" maxlength="500"
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white p-3 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">{{ old('meta_description') }}</textarea>
                        <x-form-error name="meta_description" />
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.tours.index') }}"
                    class="rounded-sm border border-black/20 px-4 py-2 text-xs font-semibold text-[#6E635C] hover:bg-black/5 dark:border-white/20 dark:text-[#FAF6F0]/70">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-sm bg-[#D96B27] px-6 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#BF5A1B]">
                    Create Tour
                </button>
            </div>
        </form>
    </div>

</x-layouts.admin>
