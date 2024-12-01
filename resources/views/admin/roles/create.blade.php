<x-admin-layout>
    <div
        x-data="{ loading: true }"
        x-init="setTimeout(() => loading = false, 1000)">
        <!-- Pulse loading animation -->

        <div x-show="loading" class="shadow rounded-md p-8 h-full w-full mx-auto my-8">
            <p class="text-2xl font-bold animate-pulse">Loading...</p>
        </div>
        <!-- Livewire component -->
        <div x-show="!loading">
            <livewire:admin.roles.create />
        </div>
    </div>
</x-admin-layout>