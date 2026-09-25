@props(['name'])
@error($name)
    <p id="{{ $name }}-error" class="mt-1 text-xs text-red-600 dark:text-red-400" role="alert">{{ $message }}</p>
@enderror
