<x-admin-layout>
    <!-- <div
        x-data="{ loading: true }"
        x-init="setTimeout(() => loading = false, 1000)">
        <div x-show="loading" class="shadow rounded-md p-8 h-full w-auto mx-auto my-8">
            <p class="text-2xl font-bold animate-pulse">Loading...</p>
        </div>
        <div x-show="!loading">
            <livewire:admin.users.index />
        </div>
    </div> -->
    <livewire:admin.users.index />
</x-admin-layout>