<x-layouts.public title="Plan Your Safari"
    description="Design your dream East African safari with our interactive trip planner. Customize destinations, travel dates, travellers, and get an instant plan to send via WhatsApp.">

    @php
        $minDate = now()->addDays(10);
        $minimumTravelDate = $minDate->toDateString();
        $currentYear = (int) date('Y');
        $currentMonthIndex = (int) date('n');
        $years = range($currentYear, $currentYear + 3);
        $months = [
            ['index' => 1, 'name' => 'January', 'season' => 'High Season &bull; Calving & Wildlife'],
            ['index' => 2, 'name' => 'February', 'season' => 'High Season &bull; Sunny & Dry'],
            ['index' => 3, 'name' => 'March', 'season' => 'Shoulder Season &bull; Good Value'],
            ['index' => 4, 'name' => 'April', 'season' => 'Green Season &bull; Lush & Quiet'],
            ['index' => 5, 'name' => 'May', 'season' => 'Green Season &bull; Beautiful Skies'],
            ['index' => 6, 'name' => 'June', 'season' => 'Shoulder Season &bull; Migration Arrival'],
            ['index' => 7, 'name' => 'July', 'season' => 'Peak Season &bull; Great Migration'],
            ['index' => 8, 'name' => 'August', 'season' => 'Peak Season &bull; Mara River Crossings'],
            ['index' => 9, 'name' => 'September', 'season' => 'Peak Season &bull; Prime Predator Action'],
            ['index' => 10, 'name' => 'October', 'season' => 'Peak Season &bull; Dry Plains & Migration'],
            ['index' => 11, 'name' => 'November', 'season' => 'Short Rains &bull; Baby Animals'],
            ['index' => 12, 'name' => 'December', 'season' => 'High Festive Season'],
        ];

        $initialYear = (string) $minDate->year;
        $initialMonthIndex = (int) $minDate->month;
        $initialMonth = $months[$initialMonthIndex - 1]['name'];
        $initialSeason = $months[$initialMonthIndex - 1]['season'];
    @endphp

    <div class="bg-[#FAF6F0] py-12 dark:bg-[#180D08] sm:py-16" x-data="{
        step: 1,
        totalSteps: 6,
        tripTypes: ['safari'],
        travellerType: 'partner',
        adults: 2,
        children: 0,
        currentYear: {{ $currentYear }},
        currentMonthIndex: {{ $currentMonthIndex }},
        year: '{{ $initialYear }}',
        month: '{{ $initialMonth }}',
        monthIndex: {{ $initialMonthIndex }},
        season: '{{ $initialSeason }}',
        duration: '7-9_days',
        durationDays: 7,
        travelDate: '{{ $minimumTravelDate }}',
        accommodation: 'luxury',
        budget: 'standard',
        name: '',
        email: '',
        phone: '',
        country: '',
        notes: '',
        monthsList: {{ json_encode($months) }},
        minDateStr: '{{ $minimumTravelDate }}',

        getDurationDays() {
            if (this.duration === '2-3_days') return 3;
            if (this.duration === '4-6_days') return 5;
            if (this.duration === '7-9_days') return 7;
            if (this.duration === '10plus_days') return 10;
            return this.durationDays || 7;
        },

        setDuration(dur, days) {
            this.duration = dur;
            this.durationDays = days;
        },

        getEndDateStr() {
            if (!this.travelDate) return '';
            const parts = this.travelDate.split('-');
            if (parts.length !== 3) return '';
            const y = parseInt(parts[0], 10);
            const m = parseInt(parts[1], 10) - 1;
            const d = parseInt(parts[2], 10);
            const dt = new Date(y, m, d);
            dt.setDate(dt.getDate() + (this.getDurationDays() - 1));
            const endY = dt.getFullYear();
            const endM = String(dt.getMonth() + 1).padStart(2, '0');
            const endD = String(dt.getDate()).padStart(2, '0');
            return `${endY}-${endM}-${endD}`;
        },

        formatDisplayDate(dateStr) {
            if (!dateStr) return '';
            const parts = dateStr.split('-');
            if (parts.length !== 3) return dateStr;
            const dt = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
            return dt.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
        },

        isPastMonth(monthIndex) {
            return parseInt(this.year, 10) === this.currentYear && monthIndex < this.currentMonthIndex;
        },

        selectMonth(mObj) {
            if (this.isPastMonth(mObj.index)) return;
            this.month = mObj.name;
            this.season = mObj.season;
            this.monthIndex = mObj.index;

            const expectedPrefix = `${this.year}-${String(mObj.index).padStart(2, '0')}-`;
            if (!this.travelDate || !this.travelDate.startsWith(expectedPrefix)) {
                const totalDays = new Date(parseInt(this.year, 10), mObj.index, 0).getDate();
                const minParts = this.minDateStr.split('-');
                const minDateObj = new Date(parseInt(minParts[0], 10), parseInt(minParts[1], 10) - 1, parseInt(minParts[2], 10));

                for (let d = 1; d <= totalDays; d++) {
                    const check = new Date(parseInt(this.year, 10), mObj.index - 1, d);
                    if (check >= minDateObj) {
                        this.travelDate = `${this.year}-${String(mObj.index).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                        break;
                    }
                }
            }
        },

        selectYear(y) {
            this.year = y;
            if (parseInt(y, 10) === this.currentYear && this.monthIndex < this.currentMonthIndex) {
                const firstAvailable = this.monthsList.find(m => m.index >= this.currentMonthIndex);
                if (firstAvailable) {
                    this.selectMonth(firstAvailable);
                    return;
                }
            }
            const currentM = this.monthsList.find(m => m.index === this.monthIndex);
            if (currentM) {
                this.selectMonth(currentM);
            }
        },

        selectDay(d) {
            if (d.disabled) return;
            this.travelDate = d.dateStr;
            const parts = d.dateStr.split('-');
            this.year = parts[0];
            this.monthIndex = parseInt(parts[1], 10);
            const mObj = this.monthsList.find(m => m.index === this.monthIndex);
            if (mObj) {
                this.month = mObj.name;
                this.season = mObj.season;
            }
        },

        getCalendarDays() {
            const y = parseInt(this.year, 10);
            const m = parseInt(this.monthIndex, 10);
            const totalDays = new Date(y, m, 0).getDate();
            const firstDay = new Date(y, m - 1, 1).getDay();
            const blankCount = (firstDay + 6) % 7;

            const days = [];
            for (let i = 0; i < blankCount; i++) {
                days.push({ isBlank: true, key: 'b-' + i });
            }

            const minParts = this.minDateStr.split('-');
            const minDateObj = new Date(parseInt(minParts[0], 10), parseInt(minParts[1], 10) - 1, parseInt(minParts[2], 10));
            const endStr = this.getEndDateStr();

            for (let d = 1; d <= totalDays; d++) {
                const dStr = String(d).padStart(2, '0');
                const mStr = String(m).padStart(2, '0');
                const fullDateStr = `${y}-${mStr}-${dStr}`;
                const dayObj = new Date(y, m - 1, d);

                const isDisabled = dayObj < minDateObj;
                const isStart = fullDateStr === this.travelDate;
                const isEnd = fullDateStr === endStr;
                const isInRange = this.travelDate && endStr && (fullDateStr >= this.travelDate && fullDateStr <= endStr);

                days.push({
                    isBlank: false,
                    dayNumber: d,
                    dateStr: fullDateStr,
                    disabled: isDisabled,
                    isStart: isStart,
                    isEnd: isEnd,
                    isInRange: isInRange,
                    key: fullDateStr
                });
            }
            return days;
        },

        toggleTripType(type) {
            if (this.tripTypes.includes(type)) {
                if (this.tripTypes.length > 1) {
                    this.tripTypes = this.tripTypes.filter(t => t !== type);
                }
            } else {
                this.tripTypes.push(type);
            }
        },

        isTripTypeSelected(type) {
            return this.tripTypes.includes(type);
        },

        getTripTypeLabel() {
            const labels = {
                'safari': 'Wildlife Safari',
                'mountain_trek': 'Mountain Trek',
                'beach_holiday': 'Beach Holiday',
                'bush_beach_combined': 'Bush to Beach'
            };
            return this.tripTypes.map(t => labels[t] || t).join(' + ');
        },

        getTravellerLabel() {
            const base = {
                'solo': 'Solo Traveler',
                'partner': 'Couple / Partner',
                'family': 'Family Holiday',
                'group': 'Private Group'
            }[this.travellerType] || this.travellerType;
            let counts = `${this.adults} ` + (this.adults === 1 ? 'Adult' : 'Adults');
            if (this.children > 0) {
                counts += `, ${this.children} ` + (this.children === 1 ? 'Child' : 'Children');
            }
            return `${base} (${counts})`;
        },

        getDurationLabel() {
            return {
                '2-3_days': '2 to 3 Days (Short Safari Getaway)',
                '4-6_days': '4 to 6 Days (Highlights)',
                '7-9_days': '7 to 9 Days (Classic Experience)',
                '10plus_days': '10+ Days (Grand Expedition)'
            }[this.duration] || this.duration;
        },

        getAccommodationLabel() {
            return {
                'comfort': 'Comfort / Mid-Range ($)',
                'luxury': 'Luxury Safari Lodges ($$ 4-5 Star)',
                'signature_luxury': 'Signature Ultra-Luxury ($$$)'
            }[this.accommodation] || this.accommodation;
        },

        canProceed() {
            if (this.step === 1) return this.tripTypes.length >= 1;
            if (this.step === 2) return !!this.travellerType && this.adults >= 1;
            if (this.step === 3) return !!this.duration;
            if (this.step === 4) return !!this.travelDate;
            if (this.step === 5) return !!this.accommodation;
            return true;
        },

        nextStep() {
            if (this.canProceed() && this.step < this.totalSteps) {
                this.step++;
                window.scrollTo({ top: 100, behavior: 'smooth' });
            }
        },

        prevStep() {
            if (this.step > 1) {
                this.step--;
                window.scrollTo({ top: 100, behavior: 'smooth' });
            }
        }
    }">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Header & Step Progress Bar -->
            <div class="text-center">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-[#D96B27]/10 px-4 py-1 text-xs font-semibold uppercase tracking-wider text-[#D96B27]">
                    <span>Tailor-Made Trip Planner</span>
                </div>
                <div
                    class="mt-4 flex items-center justify-between text-xs font-medium text-[#6E635C] dark:text-[#FAF6F0]/70">
                    <span x-text="`Step ${step} out of ${totalSteps}`"></span>
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="size-3.5 text-[#D96B27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Takes about 2 minutes
                    </span>
                </div>

                <!-- Progress Track -->
                <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-black/10 dark:bg-white/10">
                    <div class="h-full bg-[#D96B27] transition-all duration-300"
                        :style="`width: ${(step / totalSteps) * 100}%`"></div>
                </div>
            </div>

            <!-- Form Container -->
            <form method="POST" action="{{ route('plan.store') }}"
                class="mt-8 rounded-sm border border-black/10 bg-white p-6 shadow-sm sm:p-10 dark:border-white/10 dark:bg-[#24140E]">
                @csrf

                <!-- Hidden inputs synchronized with Alpine state -->
                <template x-for="t in tripTypes" :key="t">
                    <input type="hidden" name="trip_types[]" :value="t">
                </template>
                <input type="hidden" name="trip_type" :value="tripTypes.join(',')">
                @if ($tour)
                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                @endif
                @if ($destination)
                    <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                @endif
                <input type="hidden" name="traveller_type" :value="travellerType">
                <input type="hidden" name="adults_count" :value="adults">
                <input type="hidden" name="children_count" :value="children">
                <input type="hidden" name="travel_year" :value="year">
                <input type="hidden" name="travel_month" :value="month">
                <input type="hidden" name="travel_date" :value="travelDate">
                <input type="hidden" name="travel_season" :value="season">
                <input type="hidden" name="duration" :value="duration">
                <input type="hidden" name="accommodation_tier" :value="accommodation">

                <!-- STEP 1: What kind of trip are you dreaming of? -->
                <div x-show="step === 1" x-transition.opacity>
                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                        <h2 class="text-2xl font-extrabold text-[#211915] sm:text-3xl dark:text-white">
                            What kind of trip are you dreaming of?
                        </h2>
                        <span class="rounded-full bg-[#D96B27]/10 px-3 py-1 text-xs font-bold text-[#D96B27]">
                            Multi-select enabled
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Choose one or more adventure experiences. You can combine multiple items into a single bespoke
                        itinerary.
                    </p>

                    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Option 1: Safari -->
                        <button type="button" @click="toggleTripType('safari')"
                            :class="isTripTypeSelected('safari') ?
                                'border-[#D96B27] ring-2 ring-[#D96B27]/30 shadow-md bg-[#FAF6F0] dark:bg-[#180D08]' :
                                'border-black/10 dark:border-white/10 opacity-75 hover:opacity-100 bg-[#FAF6F0] dark:bg-[#180D08]'"
                            class="group relative flex flex-col overflow-hidden rounded-sm border p-4 text-left transition-all duration-200">
                            <!-- Check indicator -->
                            <div x-show="isTripTypeSelected('safari')"
                                class="absolute top-3 right-3 z-10 flex size-6 items-center justify-center rounded-full bg-[#D96B27] text-white shadow-xs">
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div x-show="!isTripTypeSelected('safari')"
                                class="absolute top-3 right-3 z-10 size-5 rounded-full border border-black/20 bg-white/80 dark:border-white/20 dark:bg-black/40">
                            </div>

                            <div class="aspect-4/3 w-full overflow-hidden rounded-sm bg-black/10">
                                <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=600&q=80"
                                    alt="Wildlife Safari"
                                    class="size-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <span
                                class="mt-4 text-sm font-bold uppercase tracking-wider text-[#211915] dark:text-white">Wildlife
                                Safari</span>
                            <span class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Big Five game viewing in
                                Maasai Mara, Amboseli & Serengeti.</span>
                        </button>

                        <!-- Option 2: Mountain Trek -->
                        <button type="button" @click="toggleTripType('mountain_trek')"
                            :class="isTripTypeSelected('mountain_trek') ?
                                'border-[#D96B27] ring-2 ring-[#D96B27]/30 shadow-md bg-[#FAF6F0] dark:bg-[#180D08]' :
                                'border-black/10 dark:border-white/10 opacity-75 hover:opacity-100 bg-[#FAF6F0] dark:bg-[#180D08]'"
                            class="group relative flex flex-col overflow-hidden rounded-sm border p-4 text-left transition-all duration-200">
                            <!-- Check indicator -->
                            <div x-show="isTripTypeSelected('mountain_trek')"
                                class="absolute top-3 right-3 z-10 flex size-6 items-center justify-center rounded-full bg-[#D96B27] text-white shadow-xs">
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div x-show="!isTripTypeSelected('mountain_trek')"
                                class="absolute top-3 right-3 z-10 size-5 rounded-full border border-black/20 bg-white/80 dark:border-white/20 dark:bg-black/40">
                            </div>

                            <div class="aspect-4/3 w-full overflow-hidden rounded-sm bg-black/10">
                                <img src="https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?auto=format&fit=crop&w=600&q=80"
                                    alt="Mountain Trek"
                                    class="size-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <span
                                class="mt-4 text-sm font-bold uppercase tracking-wider text-[#211915] dark:text-white">Mountain
                                Trek</span>
                            <span class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Kilimanjaro and Mount Kenya
                                climbing expeditions.</span>
                        </button>

                        <!-- Option 3: Beach Holiday -->
                        <button type="button" @click="toggleTripType('beach_holiday')"
                            :class="isTripTypeSelected('beach_holiday') ?
                                'border-[#D96B27] ring-2 ring-[#D96B27]/30 shadow-md bg-[#FAF6F0] dark:bg-[#180D08]' :
                                'border-black/10 dark:border-white/10 opacity-75 hover:opacity-100 bg-[#FAF6F0] dark:bg-[#180D08]'"
                            class="group relative flex flex-col overflow-hidden rounded-sm border p-4 text-left transition-all duration-200">
                            <!-- Check indicator -->
                            <div x-show="isTripTypeSelected('beach_holiday')"
                                class="absolute top-3 right-3 z-10 flex size-6 items-center justify-center rounded-full bg-[#D96B27] text-white shadow-xs">
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div x-show="!isTripTypeSelected('beach_holiday')"
                                class="absolute top-3 right-3 z-10 size-5 rounded-full border border-black/20 bg-white/80 dark:border-white/20 dark:bg-black/40">
                            </div>

                            <div class="aspect-4/3 w-full overflow-hidden rounded-sm bg-black/10">
                                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80"
                                    alt="Beach Holiday"
                                    class="size-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <span
                                class="mt-4 text-sm font-bold uppercase tracking-wider text-[#211915] dark:text-white">Beach
                                Holiday</span>
                            <span class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Pristine white sand
                                relaxation in Diani Beach & Zanzibar.</span>
                        </button>

                        <!-- Option 4: Bush & Beach -->
                        <button type="button" @click="toggleTripType('bush_beach_combined')"
                            :class="isTripTypeSelected('bush_beach_combined') ?
                                'border-[#D96B27] ring-2 ring-[#D96B27]/30 shadow-md bg-[#FAF6F0] dark:bg-[#180D08]' :
                                'border-black/10 dark:border-white/10 opacity-75 hover:opacity-100 bg-[#FAF6F0] dark:bg-[#180D08]'"
                            class="group relative flex flex-col overflow-hidden rounded-sm border p-4 text-left transition-all duration-200">
                            <!-- Check indicator -->
                            <div x-show="isTripTypeSelected('bush_beach_combined')"
                                class="absolute top-3 right-3 z-10 flex size-6 items-center justify-center rounded-full bg-[#D96B27] text-white shadow-xs">
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div x-show="!isTripTypeSelected('bush_beach_combined')"
                                class="absolute top-3 right-3 z-10 size-5 rounded-full border border-black/20 bg-white/80 dark:border-white/20 dark:bg-black/40">
                            </div>

                            <div class="aspect-4/3 w-full overflow-hidden rounded-sm bg-black/10">
                                <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=600&q=80"
                                    alt="Bush to Beach"
                                    class="size-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <span
                                class="mt-4 text-sm font-bold uppercase tracking-wider text-[#211915] dark:text-white">Bush
                                & Beach</span>
                            <span class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">The ultimate combination:
                                Savannah game drives followed by the coast.</span>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: Who will you be traveling with? -->
                <div x-show="step === 2" x-transition.opacity>
                    <h2 class="text-2xl font-extrabold text-[#211915] sm:text-3xl dark:text-white">
                        Who will you be traveling with?
                    </h2>
                    <p class="mt-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Safari vehicles and lodge configurations are tailored to your travel party.
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <button type="button" @click="travellerType = 'solo'; adults = 1; children = 0"
                            :class="travellerType === 'solo' ?
                                'border-[#D96B27] bg-[#FAF6F0] dark:bg-[#180D08] text-[#D96B27] ring-2 ring-[#D96B27]/20' :
                                'border-black/10 bg-transparent text-[#211915] dark:border-white/10 dark:text-white'"
                            class="flex flex-col items-center justify-center rounded-sm border p-6 text-center transition-all">
                            <span
                                class="flex size-12 items-center justify-center rounded-full bg-[#D96B27]/10 text-[#D96B27]">
                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <span class="mt-3 text-sm font-bold uppercase">Solo</span>
                            <span class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">Independent</span>
                        </button>

                        <button type="button" @click="travellerType = 'partner'; adults = 2"
                            :class="travellerType === 'partner' ?
                                'border-[#D96B27] bg-[#FAF6F0] dark:bg-[#180D08] text-[#D96B27] ring-2 ring-[#D96B27]/20' :
                                'border-black/10 bg-transparent text-[#211915] dark:border-white/10 dark:text-white'"
                            class="flex flex-col items-center justify-center rounded-sm border p-6 text-center transition-all">
                            <span
                                class="flex size-12 items-center justify-center rounded-full bg-[#D96B27]/10 text-[#D96B27]">
                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </span>
                            <span class="mt-3 text-sm font-bold uppercase">Partner</span>
                            <span class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">Couple / Honeymoon</span>
                        </button>

                        <button type="button" @click="travellerType = 'family'; adults = 2; children = 1"
                            :class="travellerType === 'family' ?
                                'border-[#D96B27] bg-[#FAF6F0] dark:bg-[#180D08] text-[#D96B27] ring-2 ring-[#D96B27]/20' :
                                'border-black/10 bg-transparent text-[#211915] dark:border-white/10 dark:text-white'"
                            class="flex flex-col items-center justify-center rounded-sm border p-6 text-center transition-all">
                            <span
                                class="flex size-12 items-center justify-center rounded-full bg-[#D96B27]/10 text-[#D96B27]">
                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <span class="mt-3 text-sm font-bold uppercase">Family</span>
                            <span class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">With Children</span>
                        </button>

                        <button type="button" @click="travellerType = 'group'; adults = 4; children = 0"
                            :class="travellerType === 'group' ?
                                'border-[#D96B27] bg-[#FAF6F0] dark:bg-[#180D08] text-[#D96B27] ring-2 ring-[#D96B27]/20' :
                                'border-black/10 bg-transparent text-[#211915] dark:border-white/10 dark:text-white'"
                            class="flex flex-col items-center justify-center rounded-sm border p-6 text-center transition-all">
                            <span
                                class="flex size-12 items-center justify-center rounded-full bg-[#D96B27]/10 text-[#D96B27]">
                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </span>
                            <span class="mt-3 text-sm font-bold uppercase">Group</span>
                            <span class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">Friends / Family</span>
                        </button>
                    </div>

                    <!-- Passenger Number Counters -->
                    <div
                        class="mt-8 rounded-sm border border-black/10 bg-[#FAF6F0] p-6 dark:border-white/10 dark:bg-[#180D08]">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-[#D96B27]">Number of Travelers
                        </h3>
                        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Adults -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#211915] dark:text-white">Adults</p>

                                    @if ($tour || $destination)
                                        <div
                                            class="mx-auto mt-8 max-w-2xl rounded-sm border border-[#D96B27]/20 bg-[#D96B27]/10 p-4 text-center">
                                            <p class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Your
                                                inquiry is about</p>
                                            <p class="mt-1 font-semibold text-[#211915] dark:text-white">
                                                @if ($tour)
                                                    {{ $tour->title }}
                                                @endif
                                                @if ($tour && $destination)
                                                    <span class="mx-1 text-[#D96B27]">&bull;</span>
                                                @endif
                                                @if ($destination)
                                                    {{ $destination->name }}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                    <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">Ages 12 and above</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="button" @click="if (adults > 1) adults--"
                                        class="flex size-9 items-center justify-center rounded-sm border border-black/20 bg-white font-bold text-lg hover:bg-black/5 dark:border-white/20 dark:bg-white/10 dark:text-white">-</button>
                                    <span class="w-8 text-center text-lg font-bold text-[#211915] dark:text-white"
                                        x-text="adults"></span>
                                    <button type="button" @click="adults++"
                                        class="flex size-9 items-center justify-center rounded-sm border border-black/20 bg-white font-bold text-lg hover:bg-black/5 dark:border-white/20 dark:bg-white/10 dark:text-white">+</button>
                                </div>
                            </div>

                            <!-- Children -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#211915] dark:text-white">Children</p>
                                    <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">Under 12 years</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="button" @click="if (children > 0) children--"
                                        class="flex size-9 items-center justify-center rounded-sm border border-black/20 bg-white font-bold text-lg hover:bg-black/5 dark:border-white/20 dark:bg-white/10 dark:text-white">-</button>
                                    <span class="w-8 text-center text-lg font-bold text-[#211915] dark:text-white"
                                        x-text="children"></span>
                                    <button type="button" @click="children++"
                                        class="flex size-9 items-center justify-center rounded-sm border border-black/20 bg-white font-bold text-lg hover:bg-black/5 dark:border-white/20 dark:bg-white/10 dark:text-white">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Tour Duration -->
                <div x-show="step === 3" x-transition.opacity>
                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                        <h2 class="text-2xl font-extrabold text-[#211915] sm:text-3xl dark:text-white">
                            Tour Duration
                        </h2>
                        <span class="text-xs font-semibold text-[#D96B27]">Step 3 of 6</span>
                    </div>
                    <p class="mt-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                        How many days would you like to spend exploring East Africa? We will calculate your travel dates in the next step.
                    </p>

                    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <button type="button" @click="setDuration('2-3_days', 3)"
                            :class="duration === '2-3_days' ?
                                'border-[#D96B27] bg-[#FAF6F0] ring-2 ring-[#D96B27]/20 dark:bg-[#180D08]' :
                                'border-black/10 bg-transparent dark:border-white/10'"
                            class="flex flex-col rounded-sm border p-6 text-left transition-all">
                            <span class="text-xl font-bold text-[#211915] dark:text-white">2 to 3 DAYS</span>
                            <span class="mt-1 text-xs font-semibold text-[#D96B27]">3 Days Itinerary</span>
                            <span class="mt-2 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Perfect for a short safari getaway to Amboseli or Maasai Mara.</span>
                        </button>

                        <button type="button" @click="setDuration('4-6_days', 5)"
                            :class="duration === '4-6_days' ?
                                'border-[#D96B27] bg-[#FAF6F0] ring-2 ring-[#D96B27]/20 dark:bg-[#180D08]' :
                                'border-black/10 bg-transparent dark:border-white/10'"
                            class="relative flex flex-col rounded-sm border p-6 text-left transition-all">
                            <span class="absolute top-3 right-3 rounded-full bg-[#D96B27] px-2 py-0.5 text-[10px] font-semibold text-white">Recommended</span>
                            <span class="text-xl font-bold text-[#211915] dark:text-white">4 to 6 DAYS</span>
                            <span class="mt-1 text-xs font-semibold text-[#D96B27]">5 Days Itinerary</span>
                            <span class="mt-2 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">East Africa safari highlights: Maasai Mara & Lake Nakuru.</span>
                        </button>

                        <button type="button" @click="setDuration('7-9_days', 7)"
                            :class="duration === '7-9_days' ?
                                'border-[#D96B27] bg-[#FAF6F0] ring-2 ring-[#D96B27]/20 dark:bg-[#180D08]' :
                                'border-black/10 bg-transparent dark:border-white/10'"
                            class="relative flex flex-col rounded-sm border p-6 text-left transition-all">
                            <span class="absolute top-3 right-3 rounded-full bg-[#24140E] px-2 py-0.5 text-[10px] font-semibold text-white">Most Popular</span>
                            <span class="text-xl font-bold text-[#211915] dark:text-white">7 to 9 DAYS</span>
                            <span class="mt-1 text-xs font-semibold text-[#D96B27]">7 Days Itinerary</span>
                            <span class="mt-2 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Classic comprehensive safari: Mara, Amboseli, Nakuru & Naivasha.</span>
                        </button>

                        <button type="button" @click="setDuration('10plus_days', 10)"
                            :class="duration === '10plus_days' ?
                                'border-[#D96B27] bg-[#FAF6F0] ring-2 ring-[#D96B27]/20 dark:bg-[#180D08]' :
                                'border-black/10 bg-transparent dark:border-white/10'"
                            class="flex flex-col rounded-sm border p-6 text-left transition-all">
                            <span class="text-xl font-bold text-[#211915] dark:text-white">10+ DAYS</span>
                            <span class="mt-1 text-xs font-semibold text-[#D96B27]">10 Days Itinerary</span>
                            <span class="mt-2 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Grand wildlife expedition across Kenya & Tanzania combined.</span>
                        </button>
                    </div>
                </div>

                <!-- STEP 4: When would you like to travel? -->
                <div x-show="step === 4" x-transition.opacity>
                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                        <h2 class="text-2xl font-extrabold text-[#211915] sm:text-3xl dark:text-white">
                            When would you like to travel?
                        </h2>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#D96B27]/10 px-3 py-1 text-xs font-bold text-[#D96B27]">
                            <span class="size-2 rounded-full bg-[#D96B27]"></span>
                            <span>Selected Duration: <strong x-text="getDurationDays() + ' Days'"></strong></span>
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Wildlife sightings in East Africa are magnificent year-round. Select your target year and month, then choose your departure date to view your matching itinerary timeframe.
                    </p>

                    <!-- 1. Year Selection -->
                    <div class="mt-8">
                        <label class="text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">
                            1. Select Travel Year
                        </label>
                        <div class="mt-3 flex flex-wrap gap-2.5">
                            @foreach ($years as $y)
                                <button type="button" @click="selectYear('{{ $y }}')"
                                    :class="year === '{{ $y }}' ?
                                        'border-[#D96B27] bg-[#D96B27] text-white shadow-xs font-bold' :
                                        'border-black/10 bg-[#FAF6F0] text-[#211915] hover:border-black/30 dark:border-white/10 dark:bg-[#180D08] dark:text-white font-medium'"
                                    class="rounded-sm border px-5 py-2.5 text-sm transition-all">
                                    {{ $y }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- 2. Month Selection -->
                    <div class="mt-8">
                        <label class="text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">
                            2. Select Month & Wildlife Season
                        </label>
                        <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                            <template x-for="m in monthsList" :key="m.index">
                                <button type="button" @click="selectMonth(m)" :disabled="isPastMonth(m.index)"
                                    :class="{
                                        'opacity-30 cursor-not-allowed bg-black/5 dark:bg-white/5 border-transparent text-[#6E635C]': isPastMonth(m.index),
                                        'border-[#D96B27] ring-2 ring-[#D96B27]/30 bg-[#FAF6F0] dark:bg-[#180D08] text-[#D96B27] font-bold shadow-xs': month === m.name && !isPastMonth(m.index),
                                        'border-black/10 bg-[#FAF6F0] text-[#211915] hover:border-[#D96B27]/40 dark:border-white/10 dark:bg-[#180D08] dark:text-white': month !== m.name && !isPastMonth(m.index)
                                    }"
                                    class="flex flex-col rounded-sm border p-2.5 text-left transition-all">
                                    <span class="text-sm font-bold" x-text="m.name"></span>
                                    <span class="mt-1 line-clamp-1 text-[10px] text-[#6E635C] dark:text-[#FAF6F0]/60"
                                        x-text="isPastMonth(m.index) ? 'Past Month' : m.season.replace('&bull;', '•')"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- 3. Interactive Month Dates Grid (Calendar) -->
                    <div class="mt-8 rounded-sm border border-black/10 bg-[#FAF6F0] p-4 sm:p-6 dark:border-white/10 dark:bg-[#180D08]">
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-black/10 pb-4 dark:border-white/10">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">
                                    Select Travel Date
                                </label>
                                <h3 class="mt-0.5 text-lg font-bold text-[#211915] dark:text-white"
                                    x-text="month + ' ' + year + ' — Choose Departure Date'"></h3>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="size-3 rounded-xs bg-[#D96B27]"></span> Start
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="size-3 rounded-xs bg-[#D96B27]/30"></span> Safari Days
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="size-3 rounded-xs bg-[#24140E] dark:bg-white"></span> Return
                                </span>
                            </div>
                        </div>

                        <!-- Days of week header -->
                        <div class="mt-4 grid grid-cols-7 gap-1 text-center text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">
                            <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                        </div>

                        <!-- Days grid -->
                        <div class="mt-2 grid grid-cols-7 gap-1">
                            <template x-for="item in getCalendarDays()" :key="item.key">
                                <div class="p-0.5">
                                    <template x-if="item.isBlank">
                                        <div class="h-10 sm:h-12 w-full"></div>
                                    </template>
                                    <template x-if="!item.isBlank">
                                        <button type="button" @click="selectDay(item)" :disabled="item.disabled"
                                            :class="{
                                                'opacity-35 cursor-not-allowed bg-black/5 dark:bg-white/5 text-[#6E635C]': item.disabled,
                                                'bg-[#D96B27] text-white font-bold ring-2 ring-[#D96B27] shadow-sm z-10': item.isStart,
                                                'bg-[#24140E] text-white font-bold ring-2 ring-[#24140E] shadow-sm z-10 dark:bg-white dark:text-[#24140E]': item.isEnd && !item.isStart,
                                                'bg-[#D96B27]/20 text-[#211915] font-semibold dark:bg-[#D96B27]/30 dark:text-white': item.isInRange && !item.isStart && !item.isEnd,
                                                'border border-black/10 bg-white text-[#211915] hover:border-[#D96B27] hover:bg-[#D96B27]/10 dark:border-white/10 dark:bg-[#24140E] dark:text-white': !item.disabled && !item.isInRange
                                            }"
                                            class="group relative flex h-10 sm:h-12 w-full flex-col items-center justify-center rounded-sm text-xs transition-all">
                                            <span x-text="item.dayNumber" class="text-xs sm:text-sm"></span>
                                            <template x-if="item.isStart">
                                                <span class="text-[8px] font-bold uppercase tracking-tighter sm:text-[9px]">Start</span>
                                            </template>
                                            <template x-if="item.isEnd && !item.isStart">
                                                <span class="text-[8px] font-bold uppercase tracking-tighter sm:text-[9px]">Return</span>
                                            </template>
                                        </button>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <!-- Dates summary & notice -->
                        <div class="mt-6 flex flex-col gap-4 border-t border-black/10 pt-4 md:flex-row md:items-center md:justify-between dark:border-white/10">
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-[#211915] dark:text-white">
                                    <span class="inline-flex items-center gap-1 text-[#D96B27]">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Departure:
                                    </span>
                                    <strong x-text="formatDisplayDate(travelDate)"></strong>
                                    <span>&rarr;</span>
                                    <span class="text-[#D96B27]">Return:</span>
                                    <strong x-text="formatDisplayDate(getEndDateStr()) + ' (' + getDurationDays() + ' Days)'"></strong>
                                </div>
                                <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                                    <span class="font-bold text-[#D96B27]" x-text="month + ' ' + year + ': '"></span>
                                    <span x-html="season"></span>
                                </p>
                            </div>

                            <p class="text-right text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60 md:max-w-xs">
                                Dates within the next 10 days are unavailable. This gives us time to plan your safari properly.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- STEP 5: Accommodation Style -->
                <div x-show="step === 5" x-transition.opacity>
                    <h2 class="text-2xl font-extrabold text-[#211915] sm:text-3xl dark:text-white">
                        Where would you like to stay?
                    </h2>
                    <p class="mt-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Select your preferred safari comfort tier. All selected properties are vetted by our directors.
                    </p>

                    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <button type="button" @click="accommodation = 'comfort'"
                            :class="accommodation === 'comfort' ?
                                'border-[#D96B27] bg-[#FAF6F0] ring-2 ring-[#D96B27]/20 dark:bg-[#180D08]' :
                                'border-black/10 bg-transparent dark:border-white/10'"
                            class="flex flex-col rounded-sm border p-6 text-left transition-all">
                            <span class="text-lg font-bold text-[#211915] dark:text-white">Comfort & Mid-Range</span>
                            <span class="mt-1 text-xs font-semibold text-[#D96B27]">$ &bull; Standard Tented
                                Camps</span>
                            <p class="mt-3 text-xs leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                                Clean, scenic tented camps and safari lodges with ensuite hot showers, authentic dining,
                                and prime wildlife access.
                            </p>
                        </button>

                        <button type="button" @click="accommodation = 'luxury'"
                            :class="accommodation === 'luxury' ?
                                'border-[#D96B27] bg-[#FAF6F0] ring-2 ring-[#D96B27]/20 dark:bg-[#180D08]' :
                                'border-black/10 bg-transparent dark:border-white/10'"
                            class="relative flex flex-col rounded-sm border p-6 text-left transition-all">
                            <span
                                class="absolute top-3 right-3 rounded-full bg-[#D96B27] px-2 py-0.5 text-[10px] font-semibold text-white">Recommended</span>
                            <span class="text-lg font-bold text-[#211915] dark:text-white">Luxury Lodges</span>
                            <span class="mt-1 text-xs font-semibold text-[#D96B27]">$$ &bull; 4 to 5 Star Lodges</span>
                            <p class="mt-3 text-xs leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                                Superior tented camps, gourmet multi-course meals, swimming pools, stunning valley
                                views, and exceptional service.
                            </p>
                        </button>

                        <button type="button" @click="accommodation = 'signature_luxury'"
                            :class="accommodation === 'signature_luxury' ?
                                'border-[#D96B27] bg-[#FAF6F0] ring-2 ring-[#D96B27]/20 dark:bg-[#180D08]' :
                                'border-black/10 bg-transparent dark:border-white/10'"
                            class="flex flex-col rounded-sm border p-6 text-left transition-all">
                            <span class="text-lg font-bold text-[#211915] dark:text-white">Signature
                                Ultra-Luxury</span>
                            <span class="mt-1 text-xs font-semibold text-[#D96B27]">$$$ &bull; Exclusive
                                Boutiques</span>
                            <p class="mt-3 text-xs leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                                Private plunge pools, dedicated butler service, bush spa treatments, private
                                concessions, and vintage champagne sundowners.
                            </p>
                        </button>
                    </div>
                </div>

                <!-- STEP 6: Selected Details Preview & Contact Information -->
                <div x-show="step === 6" x-transition.opacity>
                    <h2 class="text-2xl font-extrabold text-[#211915] sm:text-3xl dark:text-white">
                        Where should we send your custom safari plan?
                    </h2>
                    <p class="mt-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Review your chosen safari specifications below and enter your contact details to generate your
                        unique plan link and send via WhatsApp.
                    </p>

                    <!-- Preview of Selected Details -->
                    <div
                        class="mt-6 rounded-sm border border-[#D96B27]/30 bg-[#FAF6F0] p-5 dark:border-[#D96B27]/30 dark:bg-[#180D08]">
                        <div
                            class="flex items-center justify-between border-b border-black/10 pb-3 dark:border-white/10">
                            <div class="flex items-center gap-2">
                                <span class="size-2 rounded-full bg-[#D96B27]"></span>
                                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Safari Plan Preview</span>
                            </div>
                            <span class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">Selected
                                Specifications</span>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 text-xs">
                            <div
                                class="rounded-sm border border-black/5 bg-white p-3 dark:border-white/5 dark:bg-[#24140E]">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Trip
                                        Focus</span>
                                    <button type="button" @click="step = 1"
                                        class="text-[11px] font-semibold text-[#D96B27] hover:underline">Edit</button>
                                </div>
                                <p class="mt-1 font-bold text-[#211915] dark:text-white" x-text="getTripTypeLabel()">
                                </p>
                            </div>

                            <div
                                class="rounded-sm border border-black/5 bg-white p-3 dark:border-white/5 dark:bg-[#24140E]">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Travelers</span>
                                    <button type="button" @click="step = 2"
                                        class="text-[11px] font-semibold text-[#D96B27] hover:underline">Edit</button>
                                </div>
                                <p class="mt-1 font-bold text-[#211915] dark:text-white" x-text="getTravellerLabel()">
                                </p>
                            </div>

                            <div
                                class="rounded-sm border border-black/5 bg-white p-3 dark:border-white/5 dark:bg-[#24140E]">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Duration</span>
                                    <button type="button" @click="step = 3"
                                        class="text-[11px] font-semibold text-[#D96B27] hover:underline">Edit</button>
                                </div>
                                <p class="mt-1 font-bold text-[#211915] dark:text-white" x-text="getDurationLabel()">
                                </p>
                            </div>

                            <div
                                class="rounded-sm border border-black/5 bg-white p-3 sm:col-span-2 dark:border-white/5 dark:bg-[#24140E]">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Travel Dates & Season</span>
                                    <button type="button" @click="step = 4"
                                        class="text-[11px] font-semibold text-[#D96B27] hover:underline">Edit</button>
                                </div>
                                <p class="mt-1 font-bold text-[#211915] dark:text-white">
                                    <span x-text="formatDisplayDate(travelDate)"></span> &rarr;
                                    <span x-text="formatDisplayDate(getEndDateStr())"></span>
                                    <span class="text-[#D96B27]" x-text="' (' + getDurationDays() + ' Days)'"></span>
                                </p>
                                <p class="text-[10px] text-[#D96B27]" x-html="season"></p>
                            </div>

                            <div
                                class="rounded-sm border border-black/5 bg-white p-3 dark:border-white/5 dark:bg-[#24140E]">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Accommodation</span>
                                    <button type="button" @click="step = 5"
                                        class="text-[11px] font-semibold text-[#D96B27] hover:underline">Edit</button>
                                </div>
                                <p class="mt-1 font-bold text-[#211915] dark:text-white"
                                    x-text="getAccommodationLabel()"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Input Fields -->
                    <div class="mt-8 space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="name"
                                    class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Full
                                    Name *</label>
                                <input type="text" id="name" name="name" x-model="name" required
                                    placeholder="e.g. John Doe"
                                    class="mt-1.5 w-full rounded-sm border border-black/20 bg-transparent px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:text-white">
                            </div>

                            <div>
                                <label for="email"
                                    class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Email
                                    Address *</label>
                                <input type="email" id="email" name="email" x-model="email" required
                                    placeholder="e.g. john@example.com"
                                    class="mt-1.5 w-full rounded-sm border border-black/20 bg-transparent px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="phone"
                                    class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">WhatsApp
                                    / Phone Number</label>
                                <input type="tel" id="phone" name="phone" x-model="phone"
                                    placeholder="e.g. +1 555 123 4567"
                                    class="mt-1.5 w-full rounded-sm border border-black/20 bg-transparent px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:text-white">
                            </div>

                            <div>
                                <label for="country"
                                    class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Country
                                    of Residence</label>
                                <input type="text" id="country" name="country" x-model="country"
                                    placeholder="e.g. United States, UK, Germany"
                                    class="mt-1.5 w-full rounded-sm border border-black/20 bg-transparent px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label for="special_requests"
                                class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Special
                                Requests & Safari Wishlist (Optional)</label>
                            <textarea id="special_requests" name="special_requests" x-model="notes" rows="3"
                                placeholder="Tell us if you have particular animals you wish to see (e.g. leopards, rhinos), flight preferences, dietary needs, or milestone celebrations."
                                class="mt-1.5 w-full rounded-sm border border-black/20 bg-transparent px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:text-white"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Navigation Controls -->
                <div
                    class="mt-10 flex items-center justify-between border-t border-black/10 pt-6 dark:border-white/10">
                    <button type="button" x-show="step > 1" @click="prevStep()"
                        class="inline-flex items-center gap-2 rounded-sm border border-black/20 px-5 py-2.5 text-sm font-semibold text-[#211915] transition-colors hover:bg-black/5 dark:border-white/20 dark:text-white dark:hover:bg-white/10">
                        &larr; Back
                    </button>

                    <div class="ml-auto flex items-center gap-3">
                        <button type="button" x-show="step < totalSteps" @click="nextStep()"
                            :disabled="!canProceed()"
                            class="inline-flex items-center gap-2 rounded-sm bg-[#D96B27] px-6 py-2.5 text-sm font-semibold text-white shadow-xs transition-colors hover:bg-[#BF5A1B] disabled:opacity-50 disabled:cursor-not-allowed">
                            <span>Next Step</span>
                            <span>&rarr;</span>
                        </button>

                        <button type="submit" x-show="step === totalSteps" :disabled="!name || !email"
                            class="inline-flex items-center gap-2 rounded-sm bg-[#D96B27] px-7 py-3 text-sm font-bold text-white shadow-md transition-colors hover:bg-[#BF5A1B] disabled:opacity-50 disabled:cursor-not-allowed">
                            <span>Get my plan</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layouts.public>
