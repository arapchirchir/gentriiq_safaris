<x-layouts.auth title="Staff account">
    <p>You are signed in as {{ auth()->user()->name }}.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="w-full rounded-sm bg-[#D96B27] px-4 py-3 font-semibold text-white hover:bg-[#BF5A1B] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27]">Sign out</button>
    </form>
</x-layouts.auth>
