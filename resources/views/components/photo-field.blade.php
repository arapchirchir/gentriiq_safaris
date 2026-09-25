@props(['name', 'value' => null, 'label' => 'Photo'])

@php
    // Uploaded photos default to the upload tab; external links to the link tab.
    $mode = filled($value) && ! \App\Actions\SavePhoto::isUploaded($value) ? 'link' : 'upload';
    $link = $mode === 'link' ? $value : '';
@endphp

<div {{ $attributes->class('space-y-3') }}
    x-data="{
        mode: @js($mode),
        value: @js($value),
        link: @js($link),
        preview: @js($value),
        fileName: '',
        pick(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.fileName = file.name;
            this.preview = URL.createObjectURL(file);
        },
        useLink() {
            this.value = this.link;
            this.preview = this.link;
            this.fileName = '';
            this.$refs.file.value = '';
        },
        clear() {
            this.value = '';
            this.link = '';
            this.preview = '';
            this.fileName = '';
            this.$refs.file.value = '';
        }
    }">
    <div class="flex flex-wrap items-center justify-between gap-2">
        <span class="text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">{{ $label }}</span>
        <div class="inline-flex rounded-sm border border-black/15 p-0.5 text-xs font-semibold dark:border-white/15" role="group"
            aria-label="Photo source">
            @foreach (['upload' => 'Upload photo', 'link' => 'Paste link'] as $option => $text)
                <button type="button" @click="mode = @js($option)" :data-selected="mode === @js($option)"
                    @if ($mode === $option) data-selected="true" @endif
                    :aria-pressed="mode === @js($option)"
                    class="rounded-xs px-3 py-1.5 text-[#6E635C] transition-colors hover:text-[#211915] dark:text-[#FAF6F0]/70 dark:hover:text-white data-selected:bg-[#D96B27] data-selected:text-white data-selected:hover:text-white">
                    {{ $text }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Always submitted: the external link or the existing uploaded path. A new file upload takes precedence server-side. --}}
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" :value="value">

    <div x-show="mode === 'upload'" @if ($mode !== 'upload') x-cloak @endif>
        <label for="{{ $name }}_upload"
            class="flex cursor-pointer flex-col items-center justify-center gap-1 rounded-sm border-2 border-dashed border-black/15 bg-[#FAF6F0] px-4 py-6 text-center transition-colors hover:border-[#D96B27] dark:border-white/15 dark:bg-[#180D08]">
            <span class="text-sm font-bold text-[#211915] dark:text-white" x-text="fileName || 'Choose a photo from your device'">Choose a photo from your device</span>
            <span class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">JPG, PNG or WebP, up to 15 MB. Resized for the web and location data removed automatically.</span>
        </label>
        <input type="file" id="{{ $name }}_upload" name="{{ $name }}_upload" x-ref="file" @change="pick($event)"
            accept="image/jpeg,image/png,image/webp" class="sr-only">
        <x-form-error name="{{ $name }}_upload" />
    </div>

    <div x-show="mode === 'link'" @if ($mode !== 'link') x-cloak @endif>
        <label for="{{ $name }}_link" class="sr-only">{{ $label }} link</label>
        <input type="url" id="{{ $name }}_link" x-model="link" @input="useLink()" maxlength="255" value="{{ $link }}"
            placeholder="https://images.unsplash.com/..."
            class="w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
        <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">Links must be to Unsplash or this website to display publicly.</p>
    </div>

    <x-form-error name="{{ $name }}" />

    <div x-show="preview" @if (blank($value)) x-cloak @endif class="relative">
        <img @if (filled($value)) src="{{ $value }}" @endif :src="preview" alt="{{ $label }} preview" class="h-48 w-full rounded-sm object-cover">
        <button type="button" @click="clear()"
            class="absolute top-2 right-2 rounded-sm bg-black/70 px-2.5 py-1 text-[11px] font-semibold text-white hover:bg-black">
            Remove photo
        </button>
    </div>
</div>
