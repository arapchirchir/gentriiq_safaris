            <datalist id="tour-destination-locations">
                <template x-for="destination in selectedDestinationDetails" :key="destination.id"><option :value="destination.name"></option></template>
            </datalist>
            {{-- Section: Itinerary Days --}}
            <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Itinerary Days</h3>
                    <button type="button"
                        @click="addDay()" :disabled="days.length >= Number(durationDays)"
                        class="rounded-sm bg-[#D96B27] px-3 py-1.5 text-xs font-bold text-white hover:bg-[#BF5A1B] disabled:cursor-not-allowed disabled:opacity-50">
                        + Add Day
                    </button>
                </div>

                <p class="text-sm text-[#6E635C] dark:text-white/70" aria-live="polite" x-text="`${days.length} of ${durationDays || 0} itinerary days`"></p>
                <p x-show="days.length > Number(durationDays)" class="text-sm text-red-600" role="alert">The duration is shorter than this itinerary. Remove excess days or increase the duration. Your content has been kept.</p>
                <x-form-error name="days" />
                <div class="space-y-4">
                    <template x-for="(day, i) in days" :key="i">
                        <div
                            class="rounded-sm border border-black/10 bg-[#FAF6F0] p-4 dark:border-white/10 dark:bg-[#180D08] space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-[#D96B27]" x-text="`Day ${i + 1}`"></span>
                                <button type="button" @click="days.splice(i, 1)"
                                    class="text-xs text-[#6E635C] hover:text-red-600 dark:text-[#FAF6F0]/60">
                                    Remove
                                </button>
                            </div>
                            <input type="hidden" :name="`days[${i}][day_number]`" :value="i + 1">
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-[#6E635C] dark:text-[#FAF6F0]/70">Title
                                        *</label>
                                    <input type="text" :name="`days[${i}][title]`" x-model="day.title"
                                        :required="status === 'published'" maxlength="255" placeholder="e.g. Arrive Nairobi"
                                        class="mt-1 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#24140E] dark:text-white">
                                    <p class="mt-1 text-xs text-red-600" role="alert" x-show="errors[`days.${i}.title`]" x-text="errors[`days.${i}.title`]?.[0]"></p>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-[#6E635C] dark:text-[#FAF6F0]/70">Location</label>
                                    <input type="text" :name="`days[${i}][location]`" x-model="day.location" list="tour-destination-locations"
                                        maxlength="255" placeholder="e.g. Nairobi"
                                        class="mt-1 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#24140E] dark:text-white">
                                    <p class="mt-1 text-xs text-red-600" role="alert" x-show="errors[`days.${i}.location`]" x-text="errors[`days.${i}.location`]?.[0]"></p>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-[#6E635C] dark:text-[#FAF6F0]/70">Description</label>
                                <textarea :name="`days[${i}][description]`" x-model="day.description" rows="3" maxlength="20000" :required="status === 'published'"
                                    placeholder="What happens on this day..."
                                    class="mt-1 w-full rounded-sm border border-black/20 bg-white p-3 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#24140E] dark:text-white"></textarea>
                                    <p class="mt-1 text-xs text-red-600" role="alert" x-show="errors[`days.${i}.description`]" x-text="errors[`days.${i}.description`]?.[0]"></p>
                            </div>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-[#6E635C] dark:text-[#FAF6F0]/70">Accommodation / overnight stay</label>
                                    <input type="text" :name="`days[${i}][accommodation]`"
                                        x-model="day.accommodation" maxlength="255"
                                        placeholder="e.g. Serena Safari Lodge"
                                        class="mt-1 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#24140E] dark:text-white">
                                    <p class="mt-1 text-xs text-red-600" role="alert" x-show="errors[`days.${i}.accommodation`]" x-text="errors[`days.${i}.accommodation`]?.[0]"></p>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-[#6E635C] dark:text-[#FAF6F0]/70">Meals</label>
                                    <input type="text" :name="`days[${i}][meals]`" x-model="day.meals"
                                        maxlength="255" placeholder="e.g. Breakfast, Lunch, Dinner"
                                        class="mt-1 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#24140E] dark:text-white">
                                    <p class="mt-1 text-xs text-red-600" role="alert" x-show="errors[`days.${i}.meals`]" x-text="errors[`days.${i}.meals`]?.[0]"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                    <p x-show="days.length === 0" class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">No itinerary
                        days yet — click + Add Day.</p>
                </div>
            </div>

